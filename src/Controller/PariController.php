<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PariController extends Controller
{

    function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paris = $em->getRepository("App\Entity\Pari")->findAll();

        return $this->render("Pari/index.html.twig", array('paris' => $paris));
    }

    function newAction()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://daudenthun.fr/api/listing');
        $matchs =  json_decode($res->getBody(),true);

        return $this->render("Pari/new.html.twig", array(
            'results' => $matchs
        ));
    }



}