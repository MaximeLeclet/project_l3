<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{

    function indexAction()
    {

        return $this->render("accueil/index.html.twig", array());

    }

}