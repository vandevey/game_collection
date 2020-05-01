<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\ItemAd;
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
        if ($categories = $request->request->get('item')) {
            $categories = $categories['categories'];
        }
        $all = $entityManager->getRepository(ItemAd::class)->getAllRecent($categories);
        $this->persistCategories($categories);  // weird but no time (can make a global form that persist datas)

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
    public function request(Request $request, EntityManagerInterface $entityManager)
    {
        if ($categories = $request->request->get('item')) {
            $categories = $categories['categories'];
        }
        $request = $entityManager->getRepository(ItemAd::class)->getRequest($categories);
        $this->persistCategories($categories);  // weird but no time (can make a global form that persist datas)

        return $this->render('views/ad/request.html.twig', [
            'requests' => $request,
            'categories' => $this->categories,
            'page' => 'request',
        ]);
    }

    /**
     * @Route("/offers", name="show_offer")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function offer(Request $request, EntityManagerInterface $entityManager)
    {
        if ($categories = $request->request->get('item')) {
            $categories = $categories['categories'];
        }
        $offers = $entityManager->getRepository(ItemAd::class)->getOffer($categories);
        $this->persistCategories($categories);  // weird but no time (can make a global form that persist datas)

        return $this->render('views/ad/offer.html.twig', [
            'offers' => $offers,
            'categories' => $this->categories,
            'page' => 'offer',
        ]);
    }

    /**
     * @param $categories
     */
    public function persistCategories($categories)
    {
        /** @var Category $category */
        foreach ($this->categories as $key => $category) {
            $this->categories[$key]->selected = false;
            if (null !== $categories && \in_array($category->getId(), $categories)) {
                $this->categories[$key]->selected = true;
            }
        }
    }
}