<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class MatchsControllerTest extends WebTestCase {

    public function testIndex ()
    {
        $client = static::createClient();
        $client->request('GET','/livescore');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}
