<?php

namespace App\Blackjack;

use PHPUnit\Framework\TestCase;

class CardGraphicTest extends TestCase
{
    public function testCardGraphicCreation(): void
    {
        $cardGraphic = new CardGraphic('A', 'Hearts');
        $this->assertInstanceOf(CardGraphic::class, $cardGraphic);
        $this->assertEquals('A', $cardGraphic->getRank());
        $this->assertEquals('Hearts', $cardGraphic->getSuit());
    }

    public function testString(): void
    {
        $cardGraphic = new CardGraphic('A', 'Hearts');
        $this->assertEquals('[A ♥️]', $cardGraphic->__toString());

        $cardGraphic = new CardGraphic('10', 'Hearts');
        $this->assertEquals('[10 ♥️]', $cardGraphic->__toString());
    }
}
