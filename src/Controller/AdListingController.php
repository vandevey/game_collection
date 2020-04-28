<?php

namespace App\Controller;


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
     * @Route("/request", name="show_request")
     * @param EntityManagerInterface $entityManager
     */
    public function request(EntityManagerInterface $entityManager)
    {
        $request = $entityManager->getRepository(Request::class)->findAll();

        dd($request);
    }

    /**
     * @Route("/offer", name="show_offer")
     */
    public function offer()
    {

    }

}