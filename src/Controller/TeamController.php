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

        if (!$this->getUser()) {return $this->redirectToRoute('security_login'); }

        $em = $this->getDoctrine()->getManager();

        $team = new Team();

        $form = $this->createFormBuilder($team)
            ->add('nom_team', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $team = $form->getData();

            $user = $this->getUser();

            $user->setTeam($team);

            $bcrypt = self::generateRandomString(6);

            $team->setBcrypt($bcrypt);

            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute("app_team_bcrypt", array(
                "idTeam" => $team->getid()
            ));

        }

        return $this->render("Team/new.html.twig", array(
            'form' => $form->createView()
        ));

    }

    function bcryptAction($idTeam)
    {

        $em = $this->getDoctrine()->getManager();

        $team = $em->getRepository("App\Entity\Team")->find($idTeam);

        return $this->render("Team/bcrypt.html.twig", array(
            'bcrypt' => $team->getBcrypt()
        ));

    }

    function joinAction($idTeam)
    {

        if (!$this->getUser()) return $this->redirectToRoute('security_login');

        $em = $this->getDoctrine()->getManager();

        $team = $em->getRepository("App\Entity\Team")->find($idTeam);

        if($team) {

            $this->getUser()->setTeam($team);
            $em->flush();

        }

        return $this->redirectToRoute('app_team_index');

    }

    function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}