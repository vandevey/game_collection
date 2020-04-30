<?php


namespace App\Controller;


use App\Entity\Image;
use App\Entity\Item;
use App\Form\Items\ItemType;
use App\Services\ImageManager;
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
     * @param ImageManager $imageManager
     * @return RedirectResponse|Response
     */
    public function new(Request $request, ImageManager $imageManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var User $user */
        $user = $this->getUser();

        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Item $item */
            $item = $form->getData();
            $item->setCreatedAt();
            $item->setUpdatedAt();

            $item->setAuthor($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($item->getAuthor());
            $entityManager->persist($item);

            // image
            $coverImageName = $imageManager->download($form->get('image_cover')->getData(), 'items');
            if ($coverImageName) {
                $coverImageParts = pathinfo($coverImageName);
                $image = (new Image())->setItem($item)
                    ->setKey($coverImageParts['filename'])
                    ->setExtension($coverImageParts['extension']);

                $entityManager->persist($image);
            }
            $largeImageName = $imageManager->download($form->get('image_large')->getData(), 'items');
            if ($largeImageName) {
                $largeImageParts = pathinfo($largeImageName);
                $image = (new Image())
                    ->setItem($item)
                    ->setKey($largeImageParts['filename'])
                    ->setExtension($largeImageParts['extension']);

                $entityManager->persist($image);
            }

            $entityManager->flush();
        }

        return $this->render('views/item/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}