<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Form\AbsenceType;
use App\Repository\AbsenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $absence = new Absence();
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function edit(Request $request, Absence $absence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
}
