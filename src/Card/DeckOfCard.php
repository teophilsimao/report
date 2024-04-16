<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardHand;

class DeckOfCard 
{
    protected $deck = [];
    protected $cards = [];

    public function add(Card $card):void
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

    public function setDeck(array $deck): void
    {
        $this->deck = $deck;
    }

    public function getAmount(): int
    {
        return count($this->deck);
    }

    public function getDeck(): array
    {
        return $this->deck;
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function getString(): array
    {
        $deckString = [];
        foreach ($this->deck as $card) {
            $deckString[] = $card->getAsString();
        }
        return $deckString;
    }
}