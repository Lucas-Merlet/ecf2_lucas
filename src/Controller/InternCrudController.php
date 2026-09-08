<?php

namespace App\Controller;

use App\Entity\Intern;
use App\Form\InternType;
use App\Repository\InternRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/intern/crud')]
final class InternCrudController extends AbstractController
{
    #[Route(name: 'app_intern_crud_index', methods: ['GET'])]
    public function index(InternRepository $internRepository): Response
    {
        return $this->render('intern_crud/index.html.twig', [
            'interns' => $internRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_intern_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $intern = new Intern();
        $form = $this->createForm(InternType::class, $intern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handlePhotoUpload($form, $intern, $slugger);

            $entityManager->persist($intern);
            $entityManager->flush();

            return $this->redirectToRoute('app_intern_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('intern_crud/new.html.twig', [
            'intern' => $intern,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_intern_crud_show', methods: ['GET'])]
    public function show(Intern $intern): Response
    {
        return $this->render('intern_crud/show.html.twig', [
            'intern' => $intern,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_intern_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Intern $intern, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(InternType::class, $intern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handlePhotoUpload($form, $intern, $slugger);

            $entityManager->flush();

            return $this->redirectToRoute('app_intern_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('intern_crud/edit.html.twig', [
            'intern' => $intern,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/archive', name: 'app_intern_crud_archive', methods: ['POST'])]
    public function archive(Request $request, Intern $intern, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('archive'.$intern->getId(), $request->getPayload()->getString('_token'))) {
            $intern->setArchived(true);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_intern_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/restore', name: 'app_intern_crud_restore', methods: ['POST'])]
    public function restore(Request $request, Intern $intern, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('restore'.$intern->getId(), $request->getPayload()->getString('_token'))) {
            $intern->setArchived(false);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_intern_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_intern_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Intern $intern, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$intern->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($intern);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_intern_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Handle the photo upload: rename safely, move it, store its name.
     */
    private function handlePhotoUpload($form, Intern $intern, SluggerInterface $slugger): void
    {
        $photoFile = $form->get('photo')->getData();

        if ($photoFile) {
            $originalName = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = $slugger->slug($originalName);
            $newFilename = $safeName . '-' . uniqid() . '.' . $photoFile->guessExtension();

            $photoFile->move(
                $this->getParameter('photos_directory'),
                $newFilename
            );

            $intern->setPhotoPath($newFilename);
        }
    }
}