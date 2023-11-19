<?php

namespace App\Repository;

use App\Entity\BinomialFinalSelection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BinomialFinalSelection>
 *
 * @method BinomialFinalSelection|null find($id, $lockMode = null, $lockVersion = null)
 * @method BinomialFinalSelection|null findOneBy(array $criteria, array $orderBy = null)
 * @method BinomialFinalSelection[]    findAll()
 * @method BinomialFinalSelection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BinomialFinalSelectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BinomialFinalSelection::class);
    }

    //    /**
    //     * @return BinomialFinalSelection[] Returns an array of BinomialFinalSelection objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BinomialFinalSelection
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
