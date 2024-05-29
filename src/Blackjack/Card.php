<?php

namespace App\Blackjack;

class Card 
{
    private string $rank;
    private string $suit;

    public function __construct($rank, $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    public function getValue(): int
    {
        if (in_array($this->rank, ['J', 'Q', 'K'])) {
            return 10;
        } elseif ($this->rank == 'A') {
            return 11;
        } else {
            return intval($this->rank);
        }
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getRank(): string
    {
        return $this->rank;
    }
}