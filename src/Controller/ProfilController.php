<?php


namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{

    /**
     * @Route("/profil/{id}", name="show_profil")
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        return $this->render('views/profil/profil.html.twig');
    }

    // TODO: edit user information (pwd, username and email)
}