<?php

namespace App\Controller;

use App\Entity\ItemAd;
use App\Entity\Offer;
use App\Entity\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdListingController
 * @package App\Controller
 */
class AdListingController extends AbstractController
{
     /**
     * @Route("/", name="show_all")
     * @param EntityManagerInterface $entityManager
     */
    public function all(EntityManagerInterface $entityManager)
    {
        $all = $entityManager->getRepository(ItemAd::class)->getAllRecent();
     
        return $this->render('views/home/listing.html.twig', [
            'all' => $all,
            'page' => 'home',
        ]);
       
     
    }

    /**
     * @Route("/request", name="show_request")
     * @param EntityManagerInterface $entityManager
     */
    public function request(EntityManagerInterface $entityManager)
    {
        $request = $entityManager->getRepository(ItemAd::class)->getRequest();
      
       
        return $this->render('views/ad/request.html.twig', [
            'requests' => $request,
            'page' => 'request',
        ]);
    }
 
    /**
     * @Route("/offers", name="show_offer")
     * @param EntityManagerInterface $entityManager
     */
    public function offer(EntityManagerInterface $entityManager)
    {
        $offers = $entityManager->getRepository(ItemAd::class)->getOffer();
        

        return $this->render('views/ad/offer.html.twig', [
            'offers' => $offers,
            'page' => 'offer',
        ]);
    }

}