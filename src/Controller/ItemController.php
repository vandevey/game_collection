<?php


namespace App\Controller;


use App\Entity\Item;
use App\Form\Items\ItemType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    /**
     * @Route("/item/new", name="new_item")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function new(Request $request): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Item $item */
            $item = $form->getData();
            $item->setCreatedAt();
            $item->setUpdatedAt();

             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($item);
             $entityManager->flush();
        }

        return $this->render('views/item/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}