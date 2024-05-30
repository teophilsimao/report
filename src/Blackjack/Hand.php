<?php

namespace App\Blackjack;

class Hand
{
    /**
     * @var array<CardGraphic>
     */
    private array $cards = [];

    public function addCard(CardGraphic $card): void
    {
        $this->cards[] = $card;
    }

    public function clear(): void
    {
        $this->cards = [];
    }

    /**
     * @return array<CardGraphic>
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    public function getValue(): int
    {
        $value = 0;
        $numAces = 0;

        foreach ($this->cards as $card) {
            $value += $card->getValue();
            if ($card->getRank() == 'A') {
                $numAces++;
            }
        }

        while ($value > 21 && $numAces) {
            $value -= 10;
            $numAces--;
        }

        return $value;
    }

    public function __toString(): string
    {
        $cardString = array_map(function ($card) {
            return (string)$card;
        }, $this->cards);
        return implode(', ', $cardString);
    }
}
