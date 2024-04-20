<?php

namespace App\Card;

class Card
{
    /**
     * @var string[]
     */
    protected $suits;

    /**
     * @var string[]
     */
    protected $ranks;

    /**
     * @var string
     */
    protected $suit;

    /**
     * @var string
     */
    protected $rank;

    public function __construct()
    {
        $this->suits = ['Spade', 'Heart', 'Diamond', 'Club'];
        $this->ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
        // $this->suit = null;
        // $this->rank = null;
    }

    public function drawCard(): void
    {
        $this->suit = $this->suits[array_rand($this->suits)];
        $this->rank = $this->ranks[array_rand($this->ranks)];
    }
    
    /**
     * @return string[]
     */
    public function getSuits(): array
    {
        return $this->suits;
    }

    /**
     * @return string[]
     */
    public function getRanks(): array
    {
        return $this->ranks;
    }

    /**
     * @param string $suit
     */
    public function setSuit($suit): void
    {
        $this->suit = $suit;
    }

    /**
     * @param string $rank
     */
    public function setRank($rank): void
    {
        $this->rank = $rank;
    }

    /**
     * @return array{string, string}
     */
    public function getCard(): array
    {
        return [$this->rank, $this->suit];
    }

    public function getAsString(): string
    {
        return "[{$this->rank} {$this->suit}]";
    }
}
