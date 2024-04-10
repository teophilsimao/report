<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;

class DeckOfCard
{
    private $deck = [];


    public function add(CardGraphic $card): void
    {
        $this->deck[] = $card;
    }

    public function createDeck(): void
    {
        $card = new CardGraphic();
        $suits = $card->getSuits();
        $ranks = $card->getRanks();

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $newCard = new CardGraphic();
                $newCard->setSuit($suit);
                $newCard->setRank($rank);
                $this->add($newCard);
            }
        }
    }

    public function getNumberOfCards(): int
    {
        return count($this->deck);
    }

    public function getCards(): array
    {
        $cards = [];
        foreach ($this->deck as $card) {
            $cards[] = $card->getCard();
        }
        return $cards;
    }

    public function getShuffled(): array
    {
        $cards = [];
        foreach ($this->deck as $card) {
            $cards[] = $card->getCard();
        }
        shuffle($cards);
        return $cards;
    }

    public function drawnCard(): array
    {
        if (empty($this->deck)) {
            return null;
        }

        $index = array_rand($this->deck);
        $drawnCard = $this->deck[$index];
        unset($this->deck[$index]);
        $this->deck = array_values($this->deck);

        return $drawnCard;
    }

    public function drawCard(): ?string
    {
        if (empty($this->deck)) {
            return null;
        }

        $index = array_rand($this->deck);
        $drawnCard = $this->deck[$index];
        unset($this->deck[$index]);
        $this->deck = array_values($this->deck);

        return $drawnCard->getAsString();
    }

    public function getString(): array
    {
        $cards = [];
        foreach ($this->deck as $card) {
            $cards[] = $card->getAsString();
        }
        return $cards;
    }

    public function getStringShuffled(): array
    {
        $cards = [];
        foreach ($this->deck as $card) {
            $cards[] = $card->getAsString();
        }
        shuffle($cards);
        return $cards;
    }
}
