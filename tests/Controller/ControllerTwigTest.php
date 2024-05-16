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
        $this->assertSelectorTextContains('h1', 'Home');
    }

    public function testAbout(): void
    {
        $client = static::createClient();
        $client->request('GET', '/about');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'About');
    }

    public function testReport(): void
    {
        $client = static::createClient();
        $client->request('GET', '/report');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Report');
    }

    public function testMetrics(): void
    {
        $client = static::createClient();
        $client->request('GET', '/metrics');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Metrics');
    }
}
