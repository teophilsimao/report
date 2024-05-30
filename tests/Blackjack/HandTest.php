<?php

namespace App\Blackjack;

use PHPUnit\Framework\TestCase;

class HandTest extends TestCase
{
    public function testAddCard(): void
    {
        $hand = new Hand();
        $card = new CardGraphic('A', 'Hearts');
        $hand->addCard($card);

        $reflection = new \ReflectionClass($hand);
        $property = $reflection->getProperty('cards');
        $property->setAccessible(true);
        $cards = $property->getValue($hand);

        // @phpstan-ignore-next-line
        $this->assertCount(1, $cards);
        // @phpstan-ignore-next-line
        $this->assertSame($card, $cards[0]);
    }

    public function testClearHand(): void
    {
        $hand = new Hand();
        $card1 = new CardGraphic('A', 'Hearts');
        $card2 = new CardGraphic('10', 'Clubs');
        $hand->addCard($card1);
        $hand->addCard($card2);
        $hand->clear();

        $reflection = new \ReflectionClass($hand);
        $property = $reflection->getProperty('cards');
        $property->setAccessible(true);
        $cards = $property->getValue($hand);

        // @phpstan-ignore-next-line
        $this->assertCount(0, $cards);
    }

    public function testGetValue(): void
    {
        $hand = new Hand();
        $card1 = new CardGraphic('10', 'Hearts');
        $card2 = new CardGraphic('7', 'Diamonds');
        $hand->addCard($card1);
        $hand->addCard($card2);

        $this->assertEquals(17, $hand->getValue());
    }

    public function testGetValueAce(): void
    {
        $hand = new Hand();
        $card1 = new CardGraphic('A', 'Hearts');
        $card2 = new CardGraphic('7', 'Diamonds');
        $hand->addCard($card1);
        $hand->addCard($card2);

        $this->assertEquals(18, $hand->getValue());

        $card3 = new CardGraphic('A', 'Clubs');
        $hand->addCard($card3);

        $this->assertEquals(19, $hand->getValue());
    }

    public function testGetValueAces(): void
    {
        $hand = new Hand();
        $card1 = new CardGraphic('A', 'Hearts');
        $card2 = new CardGraphic('A', 'Diamonds');
        $card3 = new CardGraphic('A', 'Clubs');
        $hand->addCard($card1);
        $hand->addCard($card2);
        $hand->addCard($card3);

        $this->assertEquals(13, $hand->getValue());

        $card4 = new CardGraphic('5', 'Spades');
        $hand->addCard($card4);

        $this->assertEquals(18, $hand->getValue());
    }

    public function testString(): void
    {
        $hand = new Hand();
        $card1 = new CardGraphic('A', 'Hearts');
        $card2 = new CardGraphic('10', 'Clubs');
        $hand->addCard($card1);
        $hand->addCard($card2);

        $this->assertEquals('[A ♥️], [10 ♣️]', $hand->__toString());
    }
}
