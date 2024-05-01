<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class CardPointTest extends TestCase
{
    public function testCreateObject()
    {
        $card = new CardPoint();
        $this->assertInstanceOf(CardPoint::class, $card);
    }

    public function testSetAndGetAceValue()
    {
        $card = new CardPoint();
        $card->setAceValue(14);
        $this->assertSame(14, $card->getAceValue());
    }

    public function testGetPoints()
    {
        $card = new CardPoint();

        $card->setRank('2');
        $this->assertSame(2, $card->getPoints());

        $card->setRank('Ace');
        $this->assertSame(1, $card->getPoints());

        $card->setAceValue(14);
        $this->assertSame(14, $card->getPoints());

        $card->setRank('Jack');
        $this->assertSame(11, $card->getPoints());
    }
}
