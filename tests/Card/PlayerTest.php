<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testCreateObject()
    {
        $player = new Player();
        $this->assertInstanceOf(Player::class, $player);
    }

    public function testHit()
    {
        $deck = new DeckOfCard();
        $player = new Player();
        $player->hit($deck);
        $this->assertCount(1, $player->getCards());
    }

    public function testGetScore()
    {
        $deck = new DeckOfCard();
        $player = new Player();
        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
        $player->hit($deck);
        $player->hit($deck);

        $score = $player->getScore();
        $this->assertIsInt($score);
    }

    public function testGetString()
    {
        $deck = new DeckOfCard();
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
