<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;

class UserController extends Controller
{

    function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("App\Entity\User")->findAll();

        return $this->render("User/index.html.twig", array(
            'users' => $users
        ));

    }

    function newAction() {

        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('password', TextType::class)
            ->add('email', TextType::class)
            ->add('Créer', SubmitType::class, array('attr' => array('class' => 'save')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('app_posts_index');
        }

        return $this->render('posts/new.html.twig', array(
            'form' => $form->createView()
        ));

    }

}