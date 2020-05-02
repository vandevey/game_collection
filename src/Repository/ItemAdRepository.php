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

    
    public function getAllRecent(array $categories = null)
    {
        // to update, this very bad sorry
        if (null !== $categories) {
            return array_merge(
                $this->getRequest($categories),
                $this->getOffer($categories)
            );
        }

        return $this->createQueryBuilder('ad')
            ->where('ad.is_visible = true')
            ->orderBy('ad.updatedAt', 'DESC')
            ->getQuery() 
            ->getResult();
           
    }
 
    public function getOffer(array $categories = null)
    {
        if (null !== $categories) {
            $categoriesString = '(' . implode(',', $categories) . ')';

            return $this->createQueryBuilder('ad')
                ->where('ad.is_visible = true')
                ->leftJoin('ad.offer', 'o')
                ->leftJoin('o.item', 'i')
                ->leftJoin('i.categories', 'ci')
                ->andWhere('ci.id in ' . $categoriesString)
                ->leftJoin('ad.request','r')
                ->having('COUNT(r.id) = 0')
                ->orderBy('ad.updatedAt', 'DESC')
                ->groupBy('ad.id, ad.title')
                ->getQuery()
                ->getResult();
        }

        return $this->createQueryBuilder('ad')
            ->leftJoin('ad.request','o')
            ->having('COUNT(o.id) = 0')
            ->orderBy('ad.updatedAt', 'DESC')
            ->groupBy('ad.id, ad.title')
            ->getQuery() 
            ->getResult();
           
    }

    public function getRequest(array $categories = null)
    {
        if (null !== $categories) {
            $categoriesString = '(' . implode(',', $categories) . ')';

            return $this->createQueryBuilder('ad')
                ->where('ad.is_visible = true')
                ->leftJoin('ad.offer','o')
                ->having('COUNT(o.id) = 0')
                ->leftJoin('ad.request', 'r')
                ->leftJoin('r.categories', 'cr')
                ->andWhere('cr.id in ' . $categoriesString)
                ->orderBy('ad.updatedAt', 'DESC')
                ->groupBy('ad.id, ad.title')
                ->getQuery()
                ->getResult();
        }

        return $this->createQueryBuilder('ad')
        ->leftJoin('ad.offer','o')
        ->having('COUNT(o.id) = 0')
        ->orderBy('ad.updatedAt', 'DESC')
        ->groupBy('ad.id, ad.title')
        ->getQuery() 
        ->getResult();
    }
}
