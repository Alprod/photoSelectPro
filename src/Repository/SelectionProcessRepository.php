<?php

namespace App\Repository;

use App\Entity\SelectionProcess;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SelectionProcess>
 *
 * @method SelectionProcess|null find($id, $lockMode = null, $lockVersion = null)
 * @method SelectionProcess|null findOneBy(array $criteria, array $orderBy = null)
 * @method SelectionProcess[]    findAll()
 * @method SelectionProcess[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SelectionProcessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SelectionProcess::class);
    }

    //    /**
    //     * @return SelectionProcess[] Returns an array of SelectionProcess objects
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

    //    public function findOneBySomeField($value): ?SelectionProcess
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
