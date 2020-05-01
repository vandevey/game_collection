<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\ItemAd;
use App\Entity\Request as RequestEntity;
use App\Entity\Offer;
use App\Entity\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function all(Request $request, EntityManagerInterface $entityManager)
    {
        $all = $entityManager->getRepository(ItemAd::class)->getAllRecent();


        return $this->render('views/home/listing.html.twig', [
            'all' => $all,
            'categories' => $this->categories,
            'page' => 'home',
        ]);
       
     
    }

    /**
     * @Route("/request", name="show_request")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function request(EntityManagerInterface $entityManager)
    {
        $request = $entityManager->getRepository(RequestEntity::class)->findAll();

        return $this->render('views/home/request.html.twig', [
        $request = $entityManager->getRepository(ItemAd::class)->getRequest();


        return $this->render('views/ad/request.html.twig', [
            'requests' => $request,
            'categories' => $this->categories,
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