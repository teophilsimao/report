<?php

namespace App\Card;

use App\Card\DeckDraw;
use App\Card\CardPoint;

/**
 * Class Player that repersents both the player and the bank
 */
class Player
{
    /**
     * @var array<CardPoint|null>
     */
    private array $playerCards;


    /**
     * Player constructor.
     * Initializes the player's card array.
     */
    public function __construct()
    {
        $this->playerCards = [];
    }

    /**
     * Adds a card drawn from the deck to the player's hand.
     *
     * @param DeckDraw $deck The deck from which the card is drawn.
     * @return void
     */
    public function hit(DeckDraw $deck): void
    {

        $this->playerCards[] = $deck->drawCard();

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
     * @return array<string|null>, string> The string representation of the cards held by the player.
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
