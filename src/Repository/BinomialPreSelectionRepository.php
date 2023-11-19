<?php

namespace App\Repository;

use App\Entity\BinomialPreSelection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BinomialPreSelection>
 *
 * @method BinomialPreSelection|null find($id, $lockMode = null, $lockVersion = null)
 * @method BinomialPreSelection|null findOneBy(array $criteria, array $orderBy = null)
 * @method BinomialPreSelection[]    findAll()
 * @method BinomialPreSelection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BinomialPreSelectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BinomialPreSelection::class);
    }

    //    /**
    //     * @return BinomialPreSelection[] Returns an array of BinomialPreSelection objects
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

    //    public function findOneBySomeField($value): ?BinomialPreSelection
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
