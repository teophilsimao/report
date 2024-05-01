<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class DeckOfCardTest extends TestCase
{
    public function testCreateDeck()
    {
        $deck = new DeckOfCard();
        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
        $this->assertCount(52, $deck->getDeck());
        $this->assertEquals(52, $deck->getAmount());
    }

    public function testShuffle()
    {
        $deck = new DeckOfCard();
        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
        $originalDeck = $deck->getDeck();
        $deck->shuffle();
        $shuffledDeck = $deck->getDeck();
        $this->assertNotEquals($originalDeck, $shuffledDeck);
    }

    public function testSetDeck()
    {
        $deck = new DeckOfCard();
        $knownDeck = [
            new CardPoint(), 
            new CardPoint(),
        ];
        $deck->setDeck($knownDeck);
        $this->assertEquals($knownDeck, $deck->getDeck());
    }

    public function testDrawnCard()
    {
        $deck = new DeckOfCard();
        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
        $drawnCard = $deck->drawnCard();
        $this->assertInstanceOf(CardPoint::class, $drawnCard);
    }

    public function testDrawnCards()
    {
        $deck = new DeckOfCard();
        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
        $hand = new CardHand();
        $drawnCard = $deck->drawnCards($hand);
        $this->assertIsString($drawnCard);
    }

    public function testDrawnCardsWhenEmpty()
    {
        $deck = new DeckOfCard();
        $hand = new CardHand();
        $drawnCard = $deck->drawnCards($hand);
        $this->assertNull($drawnCard);
    }

    public function testGetString()
    {
        $deck = new DeckOfCard();

        $card1 = new CardPoint();
        $card1->setSuit('Spade');
        $card1->setRank('Ace');
        $deck->add($card1);

        $card2 = new CardPoint();
        $card2->setSuit('Heart');
        $card2->setRank('2');
        $deck->add($card2);

        $result = $deck->getString();

        $this->assertContainsOnly('string', $result);
    }
}
