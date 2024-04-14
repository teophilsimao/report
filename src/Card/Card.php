<?php

namespace App\Card;

class Card
{
    protected $suits;
    protected $ranks;
    protected $suit;
    protected $rank;

    public function __construct()
    {
        $this->suits = ['Heart', 'Diamond', 'Club', 'Spade'];
        $this->ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
        $this->suit = null;
        $this->rank = null;
    }

    public function drawCard(): void
    {
        $this->suit = $this->suits[array_rand($this->suits)];
        $this->rank = $this->ranks[array_rand($this->ranks)];
    }

    public function getSuits(): array
    {
        return $this->suits;
    }

    public function getRanks(): array
    {
        return $this->ranks;
    }

    public function setSuit($suit): void
    {
        $this->suit = $suit;
    }

    public function setRank($rank): void
    {
        $this->rank = $rank;
    }

    public function getCard(): array
    {
        return [$this->rank, $this->suit];
    }

    public function getAsString(): string
    {
        return "[{$this->rank} {$this->suit}]";
    }
}