<?php

namespace App\Card;

use App\Card\DeckDraw;

use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{   
    public function testCreateObject():void
    {
        $player = new Player();
        $this->assertInstanceOf(Player::class, $player);
    }

    public function testHit():void
    {
        $deck = new DeckDraw();
        $player = new Player();
        $player->hit($deck);
        $this->assertCount(1, $player->getCards());
    }

    public function testGetScore():void
    {
        $deck = new DeckDraw();
        $player = new Player();
        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
        $player->hit($deck);
        $player->hit($deck);

        $score = $player->getScore();
        $this->assertIsInt($score);
    }

    public function testGetString():void
    {
        $deck = new DeckDraw();
        $player = new Player();
        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
        $player->hit($deck);
        $player->hit($deck);

        $strings = $player->getString();

        $this->assertIsArray($strings);
    }
}
