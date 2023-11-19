<?php

namespace App\Repository;

use App\Entity\BinomalPreSelection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BinomalPreSelection>
 *
 * @method BinomalPreSelection|null find($id, $lockMode = null, $lockVersion = null)
 * @method BinomalPreSelection|null findOneBy(array $criteria, array $orderBy = null)
 * @method BinomalPreSelection[]    findAll()
 * @method BinomalPreSelection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BinomalPreSelectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BinomalPreSelection::class);
    }

//    /**
//     * @return BinomalPreSelection[] Returns an array of BinomalPreSelection objects
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

//    public function findOneBySomeField($value): ?BinomalPreSelection
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
