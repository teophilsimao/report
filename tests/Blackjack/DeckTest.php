<?php

namespace App\Blackjack;

use PHPUnit\Framework\TestCase;

class DeckTest extends TestCase
{
    public function testDeck(): void
    {
        $deck1 = new Deck();
        $deck2 = new Deck();

        $reffclass1 = new \ReflectionClass($deck1);
        $property1 = $reffclass1->getProperty('cards');
        $property1->setAccessible(true);
        $cards1 = $property1->getValue($deck1);

        $reffclass2 = new \ReflectionClass($deck2);
        $property2 = $reffclass2->getProperty('cards');
        $property2->setAccessible(true);
        $cards2 = $property2->getValue($deck2);

        $this->assertNotEquals($cards1, $cards2);
    }

    public function testDraw(): void
    {
        $deck = new Deck();
        $countnum = 52;

        $drawnCard = $deck->draw();
        $this->assertInstanceOf(CardGraphic::class, $drawnCard);

        $reffclass = new \ReflectionClass($deck);
        $property = $reffclass->getProperty('cards');
        $property->setAccessible(true);
        $cards = $property->getValue($deck);

        // @phpstan-ignore-next-line
        $this->assertCount($countnum - 1, $cards);
    }
}
