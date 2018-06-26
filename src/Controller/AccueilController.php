<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{

    function indexAction() {

        return $this->render("Accueil/index.html.twig", array());

    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('Admin/index.html.twig');
    }

}

