<?php

namespace App\Card;
use App\Card\DeckDraw;

use PHPUnit\Framework\TestCase;

class DeckOfCardTest extends TestCase
{   
    public function testCreateDeck():void
    {
        $deck = new DeckDraw();
        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
        $this->assertCount(52, $deck->getDeck());
        $this->assertEquals(52, $deck->getAmount());
    }

    public function testShuffle():void
    {
        $deck = new DeckDraw();
        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
        $originalDeck = $deck->getDeck();
        $deck->shuffle();
        $shuffledDeck = $deck->getDeck();
        $this->assertNotEquals($originalDeck, $shuffledDeck);
    }

    public function testSetDeck():void
    {
        $deck = new DeckDraw();
        $knownDeck = [
            new CardPoint(), 
            new CardPoint(),
        ];
        $deck->setDeck($knownDeck);
        $this->assertEquals($knownDeck, $deck->getDeck());
    }

    public function testDrawnCard():void
    {
        $deck = new DeckDraw();
        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
        $drawnCard = $deck->drawCard();
        $this->assertInstanceOf(CardPoint::class, $drawnCard);
    }

    public function testDrawnCards():void
    {
        $deck = new DeckDraw();
        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
        $hand = new CardHand();
        $drawnCard = $deck->drawCards($hand);
        $this->assertIsString($drawnCard);
    }

    public function testDrawnWhenEmpty():void
    {
        $deck = new DeckDraw();
        $hand = new CardHand();
        $drawnCard = $deck->drawCards($hand);
        $this->assertNull($drawnCard);
    }

    public function testGetString():void
    {
        $deck = new DeckDraw();

        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();

        $result = $deck->getString();

        $this->assertIsArray($result);
    }

    public function testIsCardNotPresent():void
    {
        $deck = new DeckDraw();

        $card = new CardPoint();
        $deck->add($card);
        $deck->createDeck();
    
        $result = $deck->isCardInDeck('[3 Club]');
    
        $this->assertFalse($result);
    }
    
}
