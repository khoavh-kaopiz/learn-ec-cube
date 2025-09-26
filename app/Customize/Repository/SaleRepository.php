<?php

declare(strict_types=1);

namespace Customize\Repository;

use Customize\Entity\Sale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sale::class);
    }

    /**
     * @param bool $visible
     * @return Sale[]
     */
    public function findActive($visible = true)
    {
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
            ->andWhere('s.visible = :visible')
            ->andWhere('s.from_date <= :now')
            ->andWhere('s.to_date >= :now')
            ->setParameter('visible', $visible)
            ->setParameter('now', $now)
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
