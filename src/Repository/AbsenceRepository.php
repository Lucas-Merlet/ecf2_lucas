<?php

namespace App\Repository;

use App\Entity\Absence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Absence>
 */
class AbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Absence::class);
    }

    /**
     * Return each intern with their total number of absences,
     * ordered from most to least absent.
     *
     * @return array<int, array{firstName: string, lastName: string, total: int}>
     */
    public function countAbsencesByIntern(): array
    {
        return $this->createQueryBuilder('a')
            ->select('i.firstName AS firstName', 'i.lastName AS lastName', 'COUNT(a.id) AS total')
            ->join('a.intern', 'i')
            ->groupBy('i.id')
            ->orderBy('total', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
