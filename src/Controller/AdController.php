<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\ItemAd;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class AdController extends  AbstractController
{
    /**
     * @Route("/ad/new", name="new_ad")
     *
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return Response
     */


    public function new(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        //dd($user);
        $ad = new ItemAd();
        $form = $this->createFormBuilder($ad)
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Create ad'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $ad = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!

            $ad->setAuthor($user);
            $ad->setUpdatedAt();
            $ad->setCreatedAt();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ad);
            $entityManager->flush();

            return $this->redirectToRoute('new_ad');
        }
 
        return $this->render('views/ad/new.html.twig', [
            'form' => $form->CreateView(),
        ]);
    }
}
