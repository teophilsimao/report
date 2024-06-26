<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class Game21Test extends TestCase
{
    public function testConstructor():void
    {
        $game = new Game21();

        $this->assertInstanceOf(DeckOfCard::class, $game->getDeck());

        $this->assertInstanceOf(Player::class, $game->getPlayer());

        $this->assertInstanceOf(Player::class, $game->getDealer());
    }

    public function testGetDeck():void
    {
        $game = new Game21();
        $deck = $game->getDeck();

        $this->assertInstanceOf(DeckOfCard::class, $deck);
    }

    public function testGetPlayer():void
    {
        $game = new Game21();
        $player = $game->getPlayer();

        $this->assertInstanceOf(Player::class, $player);
    }

    public function testGetDealer():void
    {
        $game = new Game21();
        $dealer = $game->getDealer();

        $this->assertInstanceOf(Player::class, $dealer);
    }
}
