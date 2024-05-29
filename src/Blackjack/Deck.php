<?php

namespace App\Blackjack;

class Deck
{
    private array $cards = [];
    private array $suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
    private array $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

    public function __construct()
    {
        foreach ($this->suits as $suit) {
            foreach ($this->ranks as $rank) {
                $this->cards[] = new CardGraphic($rank, $suit);
            }
        }
        shuffle($this->cards);
    }

    public function draw(): CardGraphic
    {
        return array_pop($this->cards);
    }
}
