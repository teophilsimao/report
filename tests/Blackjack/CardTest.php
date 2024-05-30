<?php

namespace App\Blackjack;

use PHPUnit\Framework\TestCase;


class CardTest extends TestCase
{   
    public function testCardCreation(): void
    {
        $card = new Card('A', 'Hearts');
        $this->assertInstanceOf(Card::class, $card);
        $this->assertEquals('A', $card->getRank());
        $this->assertEquals('Hearts', $card->getSuit());
    }

    public function testGetValueFace(): void
    {
        $card = new Card('K', 'Spades');
        $this->assertEquals(10, $card->getValue());
    }

    public function testGetValueAce(): void
    {
        $card = new Card('A', 'Diamonds');
        $this->assertEquals(11, $card->getValue());
    }

    public function testGetValueNumb(): void
    {
        $card = new Card('7', 'Clubs');
        $this->assertEquals(7, $card->getValue());
    }

}