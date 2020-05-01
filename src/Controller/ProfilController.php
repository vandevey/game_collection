<?php


namespace App\Controller;

use App\Entity\Item;
use App\Entity\User;
use App\Form\Profil\ProfilType;
use App\Services\PasswordManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController 
{

    /**
     * @Route("/profil/{id}", name="show_profil")
     *
     * @param User $user
     * @param Request $request
     * @param PasswordManager $passwordManager
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function show(User $user, Request $request, PasswordManager $passwordManager, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ProfilType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData(); 

            // change password
            $oldPassword = $form->get('oldPassword');
            $newPassword = $form->get('newPassword')->getData();
            if (!$passwordManager->change($user, $oldPassword->getData(), $newPassword)) {
                $oldPassword->addError(new FormError('Wrong password'));
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        $authorItem = $entityManager->getRepository(Item::class)->getAuthorItem($user->getId());
        
        return $this->render('views/profil/profil.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'items' => $authorItem,

        ]);
    }
}