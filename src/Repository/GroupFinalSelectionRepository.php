<?php

namespace App\Repository;

use App\Entity\GroupFinalSelection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GroupFinalSelection>
 *
 * @method GroupFinalSelection|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupFinalSelection|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupFinalSelection[]    findAll()
 * @method GroupFinalSelection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupFinalSelectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupFinalSelection::class);
    }

    //    /**
    //     * @return GroupFinalSelection[] Returns an array of GroupFinalSelection objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GroupFinalSelection
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
