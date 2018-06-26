<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PariControllerTest extends WebTestCase {

    // idée de test pour les paris. Importé depuis ce que l'on a fait il y a 21 jours. ;)

    public function testLisingPosts()
    {
        $client = static::createClient();
        $crawler = $client->request('Get', '/posts');
        $this->assertGreaterThan(0,
            $crawler->filter('html:contains("Hello World")')->count()
        );

    }
}