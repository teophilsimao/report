<?php

namespace App\Card;

use App\Card\CardPoint;
use App\Card\DeckOfCard;
use App\Card\Player;
// use App\Card\Dealer;

class Game21
{
    private Player $player;
    private Player $dealer;
    private DeckOfCard $deck;

    public function __construct()
    {

        $this->deck = new DeckOfCard();
        $this->deck->add(new CardPoint());
        $this->deck->createDeck();
        $this->deck->shuffle();

        $this->player = new Player();
        $this->dealer = new Player();
    }

    public function getDeck(): DeckOfCard
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
