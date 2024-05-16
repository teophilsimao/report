<?php

namespace App\Card;

use App\Card\CardPoint;
use App\Card\DeckDraw;
use App\Card\Player;

// use App\Card\Dealer;

class Game21
{
    private Player $player;
    private Player $dealer;
    private DeckDraw $deck;

    public function __construct()
    {

        $this->deck = new DeckDraw();
        $this->deck->add(new CardPoint());
        $this->deck->createDeck();
        $this->deck->shuffle();

        $this->player = new Player();
        $this->dealer = new Player();
    }

    public function getDeck(): DeckDraw
    {
        return $this->deck;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getDealer(): Player
    {
        return $this->dealer;
    }
}
