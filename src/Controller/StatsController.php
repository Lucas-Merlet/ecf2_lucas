<?php

namespace App\Controller;

use App\Repository\AbsenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StatsController extends AbstractController
{
    #[Route('/stats', name: 'app_stats')]
    public function index(AbsenceRepository $absenceRepository): Response
    {
        $ranking = $absenceRepository->countAbsencesByIntern();

        return $this->render('stats/index.html.twig', [
            'ranking' => $ranking,
        ]);
    }
}
