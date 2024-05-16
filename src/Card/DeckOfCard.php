<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\CardPoint;

class DeckOfCard
{
    /**
     * @var array<CardPoint>
     */
    protected $deck = [];

    /**
     * @var array<CardPoint>
     */
    protected $cards = [];

    public function __construct()
    {
        $this->deck = [];
        $this->cards = [];
    }

    public function add(CardPoint $card): void
    {
        $this->cards[] = $card;
    }

    public function createDeck(): void
    {
        foreach ($this->cards as $card) {
            foreach ($card->getSuits() as $suit) {
                foreach ($card->getRanks() as $rank) {
                    $card = clone $card;
                    $card->setSuit($suit);
                    $card->setRank($rank);
                    $this->deck[] = $card;
                }
            }
        }
    }

    /**
     * @param array<CardPoint> $deck
     */
    public function setDeck(array $deck): void
    {
        $this->deck = $deck;
    }

    public function getAmount(): int
    {
        return count($this->deck);
    }

    /**
     * @return array<CardPoint>
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    /**
     * @return array<string>
     */
    public function getString(): array
    {
        $deckString = [];
        foreach ($this->deck as $card) {
            $deckString[] = $card->getAsString();
        }
        return $deckString;
    }
}
