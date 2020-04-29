<?php

namespace App\Repository;

use App\Entity\ItemAd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ItemAd|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemAd|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemAd[]    findAll()
 * @method ItemAd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemAdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemAd::class);
    }

    
    public function getAllRecent()
    {
        return $this->createQueryBuilder('ad')
            ->orderBy('ad.updatedAt', 'ASC')
            ->getQuery() 
            ->getResult();
           
    }
    

    // /**
    //  * @return ItemAd[] Returns an array of ItemAd objects
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
    public function findOneBySomeField($value): ?ItemAd
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
