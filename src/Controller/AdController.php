<?php


namespace App\Controller;

use App\Entity\ItemAd;
use App\Entity\Offer;
use App\Entity\Request as RequestEntity;
use App\Entity\User;
use App\Form\Ad\OfferType;
use App\Form\Ad\RequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AdController extends AbstractController
{
    /**
     * @Route("/ad/offer/new", name="new_offer")
     *
     * @param Request $request
     * @return Response
     */
    public function newOffer(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var User $user */
        $user = $this->getUser();

        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Offer $offer */
            $offer = $form->getData();
            // Item
            $offer->getItem()->setOffer($offer);
            // ItemAd
            $offer->getItemAd()->setAuthor($user);
            $offer->getItemAd()->setOffer($offer);
            $offer->getItemAd()->setCreatedAt();
            $offer->getItemAd()->setUpdatedAt();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer->getItemAd());
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('show_profil', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('views/ad/new.html.twig', [
            'form' => $form->CreateView(),
            'title' => 'Create an offer',
            'type' => 'offer',
        ]);
    }

    /**
     * @Route("/ad/request/new", name="new_request")
     *
     * @param Request $request
     * @return Response
     */
    public function newRequest(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(RequestType::class, new RequestEntity());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var RequestEntity $requestEntity */
            $requestEntity = $form->getData();
            $requestEntity->getItemAd()->setAuthor($user);
            $requestEntity->getItemAd()->setRequest($requestEntity);
            $requestEntity->getItemAd()->setUpdatedAt();
            $requestEntity->getItemAd()->setCreatedAt();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($requestEntity);
            $entityManager->flush();

            return $this->redirectToRoute('show_profil', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('views/ad/new.html.twig', [
            'form' => $form->CreateView(),
            'title' => 'Create a request',
            'type' => 'request',
        ]);
    }

    /**
     * @Route("/ad/{id}", name="detail")
     */
    public function detail(ItemAd $itemAd)
    {   
        return $this->render('views/ad/detail.html.twig', [
            'itemAd' => $itemAd,
        ]);
    }
}
