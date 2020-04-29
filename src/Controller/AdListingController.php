<?php

namespace App\Controller;

use App\Entity\ItemAd;
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
        ]);
       
     
    }

    /**
     * @Route("/request", name="show_request")
     * @param EntityManagerInterface $entityManager
     */
    public function request(EntityManagerInterface $entityManager)
    {
        $request = $entityManager->getRepository(Request::class)->findAll();

        //dd($request);
        return $this->render('views/home/request.html.twig', [
            'requests' => $request,
        ]);
       
    
    }

    /**
     * @Route("/offer", name="show_offer")
     */
    public function offer()
    {
       
    }

}