<?php

namespace App\Blackjack;

use PHPUnit\Framework\TestCase;

class BlackjackGameTest extends TestCase
{
    public function testGameInitialization(): void
    {
        $playerNames = ['OMG', 'Bob'];
        $game = new BlackjackGame($playerNames);
        
        $this->assertCount(2, $game->getPlayers());
        $this->assertEquals('OMG', $game->getPlayers()[0]->getName());
        $this->assertEquals('Bob', $game->getPlayers()[1]->getName());
        $this->assertEquals('Dealer', $game->getDealer()->getName());
    }

    public function testIsBust(): void
    {
        $playerNames = ['OMG'];
        $game = new BlackjackGame($playerNames);
        
        $player = $game->getPlayers()[0];
        $player->getHand()->addCard(new CardGraphic('10', 'Hearts'));
        $player->getHand()->addCard(new CardGraphic('K', 'Spades'));
        $player->getHand()->addCard(new CardGraphic('5', 'Diamonds'));

        $this->assertTrue($game->isBust($player));
    }

    public function testDealerPlay(): void
    {
        $playerNames = ['OMG'];
        $game = new BlackjackGame($playerNames);
        $game->init();
        
        $game->dealerPlay();
        
        $this->assertGreaterThanOrEqual(17, $game->getDealer()->getHand()->getValue());
    }

    public function testStand(): void
    {
        $playerNames = ['OMG'];
        $game = new BlackjackGame($playerNames);

        $player = $game->getPlayers()[0];
        $game->stand($player);

        $this->assertTrue($player->isStanding());
    }

    public function testPlayerStatus(): void
    {
        $playerNames = ['OMG'];
        $game = new BlackjackGame($playerNames);
        $game->init();

        $player = $game->getPlayers()[0];
        $player->getHand()->addCard(new CardGraphic('10', 'Hearts'));
        $player->getHand()->addCard(new CardGraphic('K', 'Spades'));
        $player->getHand()->addCard(new CardGraphic('5', 'Diamonds'));
        
        $this->assertTrue($game->playerStatus());
    }

    public function testPlayerStatusf(): void
    {
        $playerNames = ['OMG', 'damn'];
        $game = new BlackjackGame($playerNames);
        $game->init();

        $player = $game->getPlayers()[0];
        $player1 = $game->getPlayers()[1];
        $player->getHand()->addCard(new CardGraphic('10', 'Hearts'));
        $player->getHand()->addCard(new CardGraphic('K', 'Spades'));
        
        $player1->stand();
        
        $this->assertFalse($game->playerStatus());
    }

    public function testReset(): void
    {
        $playerNames = ['OMG'];
        $game = new BlackjackGame($playerNames);
        $game->init();
        
        $game->reset();
        
        foreach ($game->getPlayers() as $player) {
            $this->assertCount(0, $player->getHand()->getCards());
            $this->assertFalse($player->isStanding());
            $this->assertEquals(0, $player->getCurrentBet());
        }
        $this->assertCount(0, $game->getDealer()->getHand()->getCards());
        $this->assertFalse($game->getDealer()->isStanding());
    }

    public function testRemovePlayer(): void
    {
        $playerNames = ['OMG', 'Bob'];
        $game = new BlackjackGame($playerNames);

        $game->removePlayer(1);
        
        $this->assertCount(1, $game->getPlayers());
        $this->assertEquals('OMG', $game->getPlayers()[0]->getName());
    }

    public function testplayerbust(): void
    {
        $playerNames = ['Limbo'];
        $game = new BlackjackGame($playerNames);

        $player = $game->getPlayers()[0];
        $dealer = $game->getDealer();

        $player->getHand()->addCard(new CardGraphic('10', 'Hearts'));
        $player->getHand()->addCard(new CardGraphic('10', 'Diamonds'));
        $player->getHand()->addCard(new CardGraphic('2', 'Clubs'));
        $player->placeBet(100);

        $dealer->getHand()->addCard(new CardGraphic('5', 'Hearts'));
        $dealer->getHand()->addCard(new CardGraphic('7', 'Diamonds'));

        $results = $game->getResults();
        $this->assertEquals('Limbo fick 22 och förlorade', $results[0]);
    }

    public function testdealerbust(): void
    {
        $playerNames = ['Limbo'];
        $game = new BlackjackGame($playerNames);

        $player = $game->getPlayers()[0];
        $dealer = $game->getDealer();

        $player->getHand()->addCard(new CardGraphic('10', 'Hearts'));
        $player->getHand()->addCard(new CardGraphic('7', 'Diamonds'));
        $player->placeBet(100);

        $dealer->getHand()->addCard(new CardGraphic('10', 'Clubs'));
        $dealer->getHand()->addCard(new CardGraphic('8', 'Spades'));
        $dealer->getHand()->addCard(new CardGraphic('6', 'Diamonds'));

        $results = $game->getResults();
        $this->assertEquals('Limbo fick 17 och vann', $results[0]);
    }

    public function testplayerwin(): void
    {
        $playerNames = ['Limbo'];
        $game = new BlackjackGame($playerNames);

        $player = $game->getPlayers()[0];
        $dealer = $game->getDealer();

        $player->getHand()->addCard(new CardGraphic('10', 'Hearts'));
        $player->getHand()->addCard(new CardGraphic('9', 'Diamonds'));
        $player->placeBet(100);

        $dealer->getHand()->addCard(new CardGraphic('10', 'Clubs'));
        $dealer->getHand()->addCard(new CardGraphic('8', 'Spades'));

        $results = $game->getResults();
        $this->assertEquals('Limbo fick 19 och vann', $results[0]);
    }

    public function testplayerlose(): void
    {
        $playerNames = ['Limbo'];
        $game = new BlackjackGame($playerNames);

        $player = $game->getPlayers()[0];
        $dealer = $game->getDealer();

        $player->getHand()->addCard(new CardGraphic('10', 'Hearts'));
        $player->getHand()->addCard(new CardGraphic('7', 'Diamonds'));
        $player->placeBet(100);

        $dealer->getHand()->addCard(new CardGraphic('10', 'Clubs'));
        $dealer->getHand()->addCard(new CardGraphic('9', 'Spades'));

        $results = $game->getResults();
        $this->assertEquals('Limbo fick 17 och förlorade', $results[0]);
    }

    public function testGetResults_PlayerDraws(): void
    {
        $playerNames = ['Limbo'];
        $game = new BlackjackGame($playerNames);

        $player = $game->getPlayers()[0];
        $dealer = $game->getDealer();

        $player->getHand()->addCard(new CardGraphic('10', 'Hearts'));
        $player->getHand()->addCard(new CardGraphic('K', 'Diamonds'));
        $player->placeBet(100);

        $dealer->getHand()->addCard(new CardGraphic('10', 'Clubs'));
        $dealer->getHand()->addCard(new CardGraphic('K', 'Spades'));

        $results = $game->getResults();
        $this->assertEquals('Limbo fick 20 och gick lika', $results[0]);
    }

    public function testToString(): void
    {
        $playerNames = ['OMG', 'Bob'];
        $game = new BlackjackGame($playerNames);

        $omg = $game->getPlayers()[0];
        $bob = $game->getPlayers()[1];
        $dealer = $game->getDealer();

        $omg->getHand()->addCard(new CardGraphic('10', 'Hearts'));
        $omg->getHand()->addCard(new CardGraphic('A', 'Diamonds'));

        $bob->getHand()->addCard(new CardGraphic('9', 'Clubs'));
        $bob->getHand()->addCard(new CardGraphic('9', 'Spades'));

        $dealer->getHand()->addCard(new CardGraphic('Q', 'Diamonds'));
        $dealer->getHand()->addCard(new CardGraphic('7', 'Hearts'));

        $expectedString = "OMG: [10 ♥️], [A ♦️] (poäng: 21)\nBob: [9 ♣️], [9 ♠️] (poäng: 18)\nDealer: [Q ♦️], [7 ♥️] (poäng: 17)";
        $this->assertEquals($expectedString, $game->__toString());
    }
}
