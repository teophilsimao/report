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

    public function testDrawnWhenEmpty()
    {
        $deck = new DeckOfCard();
        $hand = new CardHand();
        $drawnCard = $deck->drawnCards($hand);
        $this->assertNull($drawnCard);
    }

    public function testGetString()
    {
        $deck = new DeckOfCard();

        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();

        $result = $deck->getString();

        $this->assertIsArray($result);
    }

    public function testIsCardNotPresent()
    {
        $deck = new DeckOfCard();

        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
    
        $result = $deck->isCardInDeck('[3 Club]');
    
        $this->assertFalse($result);
    }

}
