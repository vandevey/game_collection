<?php

namespace App\Repository;

use App\Entity\ItemAdLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ItemAdLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemAdLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemAdLike[]    findAll()
 * @method ItemAdLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemAdLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemAdLike::class);
    }

    // /**
    //  * @return ItemAdLike[] Returns an array of ItemAdLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ItemAdLike
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
