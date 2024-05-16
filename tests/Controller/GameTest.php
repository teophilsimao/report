<?php

namespace App\Controller;

use App\Controller\Game;
use App\Card\CardPoint;
use App\Card\CardHand;
use App\Card\DeckDraw;
use App\Card\Player;
use App\Card\Game21;
use App\Card\GameFlash;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameTest extends WebTestCase
{
    public function testGame21Home(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game');
        $this->assertResponseIsSuccessful();
    }

    public function testGameDoc(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/doc');
        $this->assertResponseIsSuccessful();
    }
}