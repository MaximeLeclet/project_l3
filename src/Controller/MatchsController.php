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

        $datas =  json_decode($this->mooc(),true);
        return $this->render("matchs/livescore.html.twig", array('results'=>$datas));
/*
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://http://daudenthun.fr/api/listing');
        $datas =  json_decode($res->getBody(),true);
        return $this->render("matchs/livescore.html.twig", array('results'=>$datas));
*/
    }

    function mooc()
    {
        return file_get_contents("/var/www/html/project_l3/src/mooc/fakeFights.json");
    }

}
