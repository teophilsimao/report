<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class CardGraphicTest extends TestCase
{
    public function testCreateObject()
    {
        $card = new CardGraphic();
        $this->assertInstanceOf(CardGraphic::class, $card);
    }

    public function testGetAsString()
    {
        $card = new CardGraphic();

        $card->setSuit('Heart');
        $card->setRank('Ace');
        $this->assertSame('[A ♥️]', $card->getAsString());

        $card->setSuit('Diamond');
        $card->setRank('King');
        $this->assertSame('[K ♦️]', $card->getAsString());

        $card->setSuit('Club');
        $card->setRank('10');
        $this->assertSame('[10 ♣️]', $card->getAsString());

        $card->setSuit('Spade');
        $card->setRank('Jack');
        $this->assertSame('[J ♠️]', $card->getAsString());
    }
}
