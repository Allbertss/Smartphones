<?php

namespace App\Repository;

use App\Entity\Smartphone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Smartphone>
 */
class SmartphoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Smartphone::class);
    }

    public function findDistinctValues(string $field): array
    {
        $queryBuilder = $this->createQueryBuilder('smartphone')
            ->select("smartphone.$field")
            ->distinct()
            ->orderBy("smartphone.$field", 'ASC');

        $results = $queryBuilder->getQuery()->getResult();

        return array_map(function ($item) use ($field) {
            return $item[$field];
        }, $results);
    }

    public function findPriceRange(): array
    {
        $queryBuilder = $this->createQueryBuilder('smartphone')
            ->select('MIN(smartphone.price) AS min, MAX(smartphone.price) AS max');

        return $queryBuilder->getQuery()->getSingleResult();
    }

    //    /**
    //     * @return Smartphone[] Returns an array of Smartphone objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Smartphone
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
