<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    /**
     * @var array<Card>
     */
    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function drawCard(): void
    {
        foreach ($this->hand as $card) {
            $card->drawCard();
        }
    }

    public function getNumberOfCards(): int
    {
        return count($this->hand);
    }

    /**
     * @return array<int, array<string|null>>
     */
    public function getCard(): array
    {
        $cards = [];
        foreach ($this->hand as $card) {
            $cards[] = $card->getCard();
        }
        return $cards;
    }

    /**
     * @return array<int, string>
     */
    public function getString(): array
    {
        $cards = [];
        foreach ($this->hand as $card) {
            $cards[] = $card->getAsString();
        }
        return $cards;
    }
}
