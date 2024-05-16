<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerWebTest extends WebTestCase
{
    public function testLibrary(): void
        {
            $client = static::createClient();
            $client->request('GET', '/library');
            
            $this->assertResponseIsSuccessful();
            $this->assertSelectorTextContains('h1', 'Bibliotek');
        }
}