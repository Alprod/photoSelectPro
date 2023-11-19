<?php

namespace App\Repository;

use App\Entity\Binomial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Binomial>
 *
 * @method Binomial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Binomial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Binomial[]    findAll()
 * @method Binomial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BinomialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Binomial::class);
    }

    //    /**
    //     * @return Binomial[] Returns an array of Binomial objects
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

    //    public function findOneBySomeField($value): ?Binomial
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
