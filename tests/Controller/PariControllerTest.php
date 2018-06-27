<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PariControllerTest extends WebTestCase {

    // idée de test pour les paris. Importé depuis ce que l'on a fait il y a 21 jours. ;)

    public function test()
    {
        $client = static::createClient();
        //$crawler = $client->request('Get', '/livescore');
        $crawler = $client->request('POST','/submit', array('results'=>$livescore));

        $datas =  json_decode($this->mooc(),true);
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

        $this->assertGreaterThan(1,
            $crawler->filter('html:contains("Parier")')->count()
        );

    }
}