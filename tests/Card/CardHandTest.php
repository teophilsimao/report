<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class CardHandTest extends TestCase
{
    public function testCreateObject()
    {
        $hand = new CardHand();
        $this->assertInstanceOf(CardHand::class, $hand);
    }

    public function testAddCard()
    {
        $hand = new CardHand();
        $card1 = new Card();
        $card2 = new Card();
        $hand->add($card1);
        $hand->add($card2);
        $this->assertCount(2, $hand->getCard());
    }

    public function testDrawCard()
    {
        $hand = new CardHand();
        $card1 = new Card();
        $card2 = new Card();
        $hand->add($card1);
        $hand->add($card2);
        $hand->drawCard();
        foreach ($hand->getCard() as $card) {
            $this->assertNotNull($card[0]);
            $this->assertNotNull($card[1]);
        }
    }

    public function testGetNumberOfCards()
    {
        $hand = new CardHand();
        $card1 = new Card();
        $card2 = new Card();
        $hand->add($card1);
        $hand->add($card2);
        $this->assertSame(2, $hand->getNumberOfCards());
    }

    public function testGetString()
    {
        $hand = new CardHand();
        $card1 = new Card();
        $card1->setSuit('Heart');
        $card1->setRank('Ace');
        $card2 = new Card();
        $card2->setSuit('Diamond');
        $card2->setRank('King');
        $hand->add($card1);
        $hand->add($card2);
        $this->assertSame(['[Ace Heart]', '[King Diamond]'], $hand->getString());
    }
}
