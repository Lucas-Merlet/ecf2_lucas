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
        $interns = $internRepository->findAll();

        return $this->render('intern/index.html.twig', [
            'interns' => $interns,
        ]);
    }
}