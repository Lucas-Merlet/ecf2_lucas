<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Form\AbsenceType;
use App\Repository\AbsenceRepository;
use App\Repository\InternRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/absence/crud')]
final class AbsenceCrudController extends AbstractController
{
    #[Route(name: 'app_absence_crud_index', methods: ['GET'])]
    public function index(AbsenceRepository $absenceRepository): Response
    {
        return $this->render('absence_crud/index.html.twig', [
            'absences' => $absenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_absence_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, InternRepository $internRepository, SluggerInterface $slugger): Response
    {
        $absence = new Absence();

        // If an intern id is passed in the URL (?intern=5), pre-select that intern.
        $internId = $request->query->get('intern');
        if ($internId !== null) {
            $intern = $internRepository->find($internId);
            if ($intern !== null) {
                $absence->setIntern($intern);
            }
        }

        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleProofUpload($form, $absence, $slugger);

            $entityManager->persist($absence);
            $entityManager->flush();

            return $this->redirectToRoute('app_absence_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('absence_crud/new.html.twig', [
            'absence' => $absence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_absence_crud_show', methods: ['GET'])]
    public function show(Absence $absence): Response
    {
        return $this->render('absence_crud/show.html.twig', [
            'absence' => $absence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_absence_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Absence $absence, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleProofUpload($form, $absence, $slugger);

            $entityManager->flush();

            return $this->redirectToRoute('app_absence_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('absence_crud/edit.html.twig', [
            'absence' => $absence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_absence_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Absence $absence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$absence->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($absence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_absence_crud_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Handle the proof (PDF) upload: rename safely, move it, store its name.
     */
    private function handleProofUpload($form, Absence $absence, SluggerInterface $slugger): void
    {
        $proofFile = $form->get('proof')->getData();

        if ($proofFile) {
            $originalName = pathinfo($proofFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = $slugger->slug($originalName);
            $newFilename = $safeName . '-' . uniqid() . '.' . $proofFile->guessExtension();

            $proofFile->move(
                $this->getParameter('proofs_directory'),
                $newFilename
            );

            $absence->setProofPath($newFilename);
        }
    }
}
