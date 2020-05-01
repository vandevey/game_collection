<?php


namespace App\Controller;


use App\Entity\Image;
use App\Entity\Item;
use App\Entity\User;
use App\Form\Items\ItemType;
use App\Services\ImageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
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

            $entityManager = $this->getDoctrine()->getManager();
            $item->setAuthor($user);
            $entityManager->persist($item->getAuthor());
            $entityManager->persist($item);

            $categories = $item->getCategories();
            if ($categories->isEmpty()) {
                $form->addError(new FormError('Your item need to have one genre or more.'));
                return $this->render('views/item/new.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            foreach ($categories as $category) {
                $category->addItem($item);
                $entityManager->persist($category);
            }


            // image
            $coverImageName = $imageManager->download($form->get('image_cover')->getData(), 'items');
            if ($coverImageName) {
                $image = (new Image())->setItem($item)
                    ->setPath($coverImageName);

                $entityManager->persist($image);
            }
            $largeImageName = $imageManager->download($form->get('image_large')->getData(), 'items');
            if ($largeImageName) {
                $image = (new Image())
                    ->setItem($item)
                    ->setPath($largeImageName);

                $entityManager->persist($image);
            }

            $entityManager->flush();

            return $this->redirectToRoute('show_profil', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('views/item/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}