<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTwigTest extends WebTestCase
{
    public function testHome(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function testAbout(): void
    {
        $client = static::createClient();
        $client->request('GET', '/about');
        $this->assertResponseIsSuccessful();
    }

    public function testReport(): void
    {
        $client = static::createClient();
        $client->request('GET', '/report');
        $this->assertResponseIsSuccessful();
    }

    public function testLucky(): void
    {
        $client = static::createClient();
        $client->request('GET', '/lucky');
        $this->assertResponseIsSuccessful();
    }
}