<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Team;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends Controller
{

    function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository("App\Entity\Team")->findAll();

        return $this->render("Team/index.html.twig", array(
            'teams' => $teams
        ));

    }

    function newAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $team = new Team();

        $form = $this->createFormBuilder($team)
            ->add('nom_team', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $team = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('app_team_index');
        }

        return $this->render("Team/new.html.twig", array(
            'form' => $form->createView()
        ));

    }

}