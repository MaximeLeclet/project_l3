<?php

namespace App\Controller;


use App\Entity\Pari;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PariController extends Controller
{

    function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paris = $em->getRepository("App\Entity\Pari")->findAll();

        return $this->render("Pari/index.html.twig", array('paris' => $paris));
    }

    function newAction(Request $request)
    {
       // just setup a fresh $post object (remove the dummy data)
        $post = new Pari();

        $urls = explode('/', $request->getUri());
        $equipe1 = $urls[3];
        $equipe2 = $urls[4];


        $form = $this->createFormBuilder($post)
            ->add('equipe1', TextType::class, array('label' => $equipe1))
            ->add('equipe2', TextType::class, array('label' => $equipe2))
            ->add('score_equipe1', TextType::class)
            ->add('score_equipe2', TextType::class)
            ->add('validate', SubmitType::class, array('label' => 'Valider le pari'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$post` variable has also been updated
            $post = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_pari_new');
        }

        return $this->render('Pari/new.html.twig',  array(
            'form' => $form->createView()
            ));
    }

}