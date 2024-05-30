<?php

namespace App\Blackjack;

use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testCreate(): void
    {
        $player = new Player('Jinga');
        $this->assertInstanceOf(Player::class, $player);
        $this->assertEquals('Jinga', $player->getName());
        $this->assertEquals(1000, $player->getMoney());
        $this->assertInstanceOf(Hand::class, $player->getHand());
        $this->assertFalse($player->isStanding());
        $this->assertEquals(0, $player->getCurrentBet());
    }

    public function testPlaceBet(): void
    {
        $player = new Player('Jinga');
        $player->placeBet(100);
        $this->assertEquals(100, $player->getCurrentBet());
        $this->assertEquals(900, $player->getMoney());
    }

    public function testWinBet(): void
    {
        $player = new Player('Jinga');
        $player->placeBet(100);
        $player->winBet();
        $this->assertEquals(1100, $player->getMoney());
        $this->assertEquals(0, $player->getCurrentBet());
    }

    public function testLoseBet(): void
    {
        $player = new Player('Jinga');
        $player->placeBet(100);
        $player->loseBet();
        $this->assertEquals(900, $player->getMoney());
        $this->assertEquals(0, $player->getCurrentBet());
    }

    public function testDrawBet(): void
    {
        $player = new Player('Jinga');
        $player->placeBet(100);
        $player->drawBet();
        $this->assertEquals(1000, $player->getMoney());
        $this->assertEquals(0, $player->getCurrentBet());
    }

    public function testStand(): void
    {
        $player = new Player('Jinga');
        $player->stand();
        $this->assertTrue($player->isStanding());
    }

    public function testReset(): void
    {
        $player = new Player('Jinga');
        $player->placeBet(100);
        $player->stand();
        $player->reset();

        $this->assertFalse($player->isStanding());
        $this->assertEquals(0, $player->getCurrentBet());
    }

    public function testString(): void
    {
        $player = new Player('Jinga');
        $card1 = new CardGraphic('A', 'Hearts');
        $card2 = new CardGraphic('10', 'Clubs');
        $player->getHand()->addCard($card1);
        $player->getHand()->addCard($card2);

        $expectedString = "Jinga: [A ♥️], [10 ♣️] (poäng: 21)";
        $this->assertEquals($expectedString, $player->__toString());
    }
}
