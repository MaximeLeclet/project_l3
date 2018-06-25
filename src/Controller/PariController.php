<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PariController extends Controller
{

    function PariIndexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paris = $em->getRepository("App\Entity\Pari")->findAll();

        return $this->render("Pari/index.html.twig", array('paris' => $paris));
    }

    function PariCreateAction()
    {
        $em = $this->getDoctrine()->getManager();

        $matchs = $em->getRepository("App\Entity\Matchs")->findAll();

        return $this->render("Pari/create.html.twig", array('matchs' => $matchs));
    }



}