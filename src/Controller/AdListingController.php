<?php


namespace App\Controller;


use App\Entity\Item;
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
        $items = $entityManager->getRepository(Item::class)->findAll();

        dd($items[0]->getImages()->first());
    }

    /**
     * @Route("/offer", name="show_offer")
     */
    public function offer()
    {

    }

}