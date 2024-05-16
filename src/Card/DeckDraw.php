<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\CardPoint;
use App\Card\DeckOfCard;

class DeckDraw extends DeckOfCard
{
    public function __construct()
    {
        parent::__construct();
    }

    public function drawCard(): ?CardPoint
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

    public function drawCards(CardHand $hand): ?string
    {
        if (empty($this->deck)) {
            return null;
        }

        $index = array_rand($this->deck);
        $drawnCard = $this->deck[$index];

        if ($this->isCardInDeck($drawnCard->getAsString())) {
            $hand->add($drawnCard);
            unset($this->deck[$index]);
            $this->deck = array_values($this->deck);
            return $drawnCard->getAsString();
        }

        return null;
    }

    public function isCardInDeck(string $cardStr): bool
    {
        foreach ($this->deck as $card) {
            if ($card->getAsString() === $cardStr) {
                return true;
            }
        }
        return false;
    }
}
