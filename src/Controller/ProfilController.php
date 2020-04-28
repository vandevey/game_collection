<?php


namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{

    /**
     * @Route("/profil/{id}", name="show_profil")
     *
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function show(User $user, EntityManagerInterface $entityManager)
    {
        return $this->render('views/profil/profil.html.twig');
    }

    // TODO: edit user information (pwd, username and email)
}