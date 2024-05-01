<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;


class CardTest extends TestCase
{
    public function testCreateObject()
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);
    }

    public function testDrawCard()
    {
        $card = new Card();
        $card->drawCard();
        $this->assertContains($card->getRank(), $card->getRanks());
        $this->assertContains($card->getSuit(), $card->getSuits());
    }

    public function testGetCard()
    {
        $card = new Card();
        $card->drawCard();
        $this->assertIsArray($card->getCard());
        $this->assertCount(2, $card->getCard());
        $this->assertContains($card->getCard()[0], $card->getRanks());
        $this->assertContains($card->getCard()[1], $card->getSuits());
    }

    public function testGetAsString()
    {
        $card = new Card();
        $card->setRank('Ace');
        $card->setSuit('Spade');
        $this->assertSame('[Ace Spade]', $card->getAsString());
    }

    public function testSetAceValue()
    {
        $card = new Card();

        $card->setAceValue(1);

        $this->assertEquals(1, $card->aceValue);

        $card->setAceValue(14);

        $this->assertEquals(14, $card->aceValue);
    }
}