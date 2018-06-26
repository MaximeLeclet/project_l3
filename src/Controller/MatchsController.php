<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsType;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/posts")
 */
class MatchsController extends Controller
{
    /**
     *
     */
    function index() {

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://daudenthun.fr/api/listing');
        $datas =  json_decode($res->getBody(),true);
        return $this->render("matchs/livescore.html.twig", array('results'=>$datas));
    }

}
