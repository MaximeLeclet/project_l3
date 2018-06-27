<?php

namespace App\Tests\Controller;

use App\Controller\MatchController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PariControllerTest extends WebTestCase {

    // idée de test pour les paris. Importé depuis ce que l'on a fait il y a 21 jours. ;)

    public function testPari()
    {
        $client = static::createClient();
        $datas =  json_decode(MatchController::mooc(),true);
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
        $crawler = $client->request('POST','/submit', array('results'=>$livescore));
        $this->assertGreaterThan(0,
            $crawler->filter('html:contains("Parier")')->count()
        );



    }

    public function testIndex ()
    {
        $client = static::createClient();
        $client->request('GET','/paris/new/Angleterre/Belgique');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }





}