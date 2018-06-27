<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsType;
use App\Repository\PostsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class MatchController extends Controller
{
    /**
     *
     * return array
     */
    function indexAction() {

        //$datas =  json_decode($this->mooc(),true);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://daudenthun.fr/api/listing');
        $datas =  json_decode($res->getBody(),true);
        $livescore = array();
        $i = 0;
        foreach ($datas as $teams){
            foreach ($teams as $team =>$match){
                $livescore[$i]['team1'] = $team;
                $livescore[$i]['team2'] = $match['vs'];
                $livescore[$i]['score1'] = $match['score'][0];
                $livescore[$i]['score2'] = $match['score'][1];
                $livescore[$i]['date'] = \DateTime::createFromFormat('d/m/Y',$match['date']);
                $livescore[$i]['live'] = $match['live'];
            }
            $i++;
        }

        $em = $this->getDoctrine()->getManager();

        $userParis = $em->getRepository("App\Entity\Pari")->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render("Matchs/index.html.twig", array('results'=>$livescore, 'userParis'=>$userParis));
    }

    static function mooc()
    {
        return file_get_contents("/var/www/html/project_l3/src/mooc/fakeFights.json");
    }

}
