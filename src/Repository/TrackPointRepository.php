<?php

namespace App\Repository;

use App\Entity\TrackPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrackPoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrackPoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrackPoint[]    findAll()
 * @method TrackPoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrackPointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrackPoint::class);
    }

    // /**
    //  * @return TrackPoint[] Returns an array of TrackPoint objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrackPoint
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
