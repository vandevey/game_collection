<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\ItemAd;
use App\Entity\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdListingController
 * @package App\Controller
 */
class AdListingController extends AbstractController
{
    /** @var array */
    private $categories;

    public function __construct(ParameterBagInterface $parameterBag, EntityManagerInterface $entityManager)
    {
        $this->categories = $entityManager->getRepository(Category::class)
            ->findByParent($parameterBag->get('cat_genre'));
    }

    /**
     * @Route("/", name="show_all")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function all(EntityManagerInterface $entityManager)
    {
        $all = $entityManager->getRepository(ItemAd::class)->getAllRecent();


        return $this->render('views/home/listing.html.twig', [
            'all' => $all,
            'categories' => $this->categories,
        ]);
       
     
    }

    /**
     * @Route("/request", name="show_request")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function request(EntityManagerInterface $entityManager)
    {
        $request = $entityManager->getRepository(Request::class)->findAll();

        return $this->render('views/home/request.html.twig', [
            'requests' => $request,
            'categories' => $this->categories,
        ]);
       
    
    }

    /**
     * @Route("/offer", name="show_offer")
     */
    public function offer()
    {
       
    }

}