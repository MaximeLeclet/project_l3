<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;

class UserController extends Controller
{

    function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("App\Entity\User")->find($this->getUser()->getId());

        $userParis = $em->getRepository("App\Entity\Pari")->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render('User/index.html.twig', array(
            'user' => $user,
            'paris' => $userParis
        ));
    }

}