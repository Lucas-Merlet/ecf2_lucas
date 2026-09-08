<?php

namespace App\Controller;

use App\Repository\InternRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InternController extends AbstractController
{
        #[Route('/', name: 'app_intern_index')]
    public function index(InternRepository $internRepository): Response
    {
        // Admin: sees everyone (active + archived). Visitor: only active interns.
        if ($this->isGranted('ROLE_ADMIN')) {
            $interns = $internRepository->findBy([], ['lastName' => 'ASC']);
        } else {
            $interns = $internRepository->findBy(['archived' => false], ['lastName' => 'ASC']);
        }

        return $this->render('intern/index.html.twig', [
            'interns' => $interns,
        ]);
    }
}