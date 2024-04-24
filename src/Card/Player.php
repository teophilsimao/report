<?php

namespace App\Card;

use App\Card\DeckOfCard;
use App\Card\CardPoint;

class Player
{
    /**
     * @var array<CardPoint|null>
     */
    private array $playerCards;

    public function __construct()
    {
        $this->playerCards = [];
    }

    public function hit(DeckOfCard $deck): void
    {

        $this->playerCards[] = $deck->drawnCard();

    }

    /**
     * Get the total score of the player.
     *
     * @return int|null The total score of the player.
     */
    public function getScore(): int|null
    {
        $playerScore = 0;
        $cards = $this->playerCards;

        foreach ($cards as $card) {
            if ($card !== null) {
                $playerScore += $card->getPoints();
            }
        }
        return $playerScore;
    }

    /**
     * Get the cards held by the player.
     *
     * @return array<CardPoint|null> The cards held by the player.
     */
    public function getCards(): array
    {
        return $this->playerCards;
    }

    /**
     * @return array<string|null>, string>
     */
    public function getString(): array
    {
        $pCards = [];
        foreach ($this->playerCards as $card) {
            if ($card !== null) {
                $pCards[] = $card->getAsString();
            }
        }
        return $pCards;
    }
}
