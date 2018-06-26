<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{

    function indexAction() {

        return $this->render("Accueil/index.html.twig", array());

    }

}

