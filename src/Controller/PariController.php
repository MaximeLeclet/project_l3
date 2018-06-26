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
        if (!$this->getUser()) {return $this->redirectToRoute('security_login'); }

       // just setup a fresh $post object (remove the dummy data)
        $pari = new Pari();

        $urls = explode('/', $request->getUri());
        $equipe_1 = $urls[5];
        $equipe_2 = $urls[6];


        $form = $this->createFormBuilder($pari)
            ->add('equipe1', TextType::class, array('label' => 'Equipe No 1', 'data' => $equipe_1))
            ->add('equipe2', TextType::class, array('label' => 'Equipe No 2', 'data' => $equipe_2))
            ->add('score_equipe1', TextType::class)
            ->add('score_equipe2', TextType::class)
            ->add('validate', SubmitType::class, array('label' => 'Valider le pari'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$post` variable has also been updated
            $pari = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();

            $pari->setUser($this->getUser());

            $entityManager->persist($pari);
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil_index');
        }

        return $this->render('Pari/new.html.twig',  array(
            'form' => $form->createView()
            ));
    }

}