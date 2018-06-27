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

        if (!$this->getUser()) {
            return $this->redirectToRoute('security_login');
        }


        $em = $this->getDoctrine()->getManager();

        $userParis = $em->getRepository("App\Entity\Pari")->findBy([
            'user' => $this->getUser()
        ]);

        //$datas =  json_decode($this->mooc(),true);
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://daudenthun.fr/api/listing');
        $datas =  json_decode($res->getBody(),true);
        $livescore = array();
        $i = 0;
        foreach ($datas as $teams){
            foreach ($teams as $team =>$match){
                $livescore[$i]['team1']             = $team;
                $livescore[$i]['team2']             = $match['vs'];
                $livescore[$i]['score1']            = $match['score'][0];
                $livescore[$i]['score2']            = $match['score'][1];
                $livescore[$i]['date']              = \DateTime::createFromFormat('d/m/Y',$match['date']);
                $livescore[$i]['live']              = $match['live'];

                $pointsgagnes = 0;
                foreach ($userParis as $uP => $onePari)
                {
                    if ($onePari->getEquipe1() == $team AND $onePari->getEquipe2() == $match['vs'])
                    {
                        if ($onePari->getScoreEquipe1() == $match['score'][0] AND $onePari->getScoreEquipe2() == $match['score'][1])
                        { $pointsgagnes = 20; }
                        elseif (($match['score'][0] < $match['score'][1] AND $onePari->getScoreEquipe1() < $onePari->getScoreEquipe2())
                                OR ($match['score'][0] > $match['score'][1] AND $onePari->getScoreEquipe1() > $onePari->getScoreEquipe2()))
                        { // On a le bon vainqueur
                            $pointsgagnes = 5;
                        }
                    }
                }
                $livescore[$i]['pointsgagnes']      = $pointsgagnes;
                $this->getUser()->setPoints($this->getUser()->getPoints() + $pointsgagnes);
            }
            $i++;
        }

        return $this->render("Matchs/index.html.twig", array(
            'user'=>$this->getUser(),
            'userParis'=>$userParis,
            'results'=>$livescore
        ));
    }

    static function mooc()
    {
        return file_get_contents("/var/www/html/project_l3/src/mooc/fakeFights.json");
    }

}
