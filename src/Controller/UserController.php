<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;

class UserController extends Controller
{

    function indexAction()
    {

        $user = $this->getUser();

        return $this->render("User/index.html.twig", array(
            'user' => $user
        ));

    }

}