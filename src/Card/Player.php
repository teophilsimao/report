<?php

namespace App\Card;

use App\Card\DeckOfCard;

class Player
{
    private array $cards = [];
    private bool $lost = false;

    public function hit(DeckOfCard $deck): void 
    {
        
        $this->cards[] = $deck->drawnCard();

        if($this->getScore()>21){
            $this->lost=true;
        }
    }

    public function getLost(): bool 
    {
        return $this->lost;
    }

    /**
     * Get the total score of the player.
     *
     * @return int The total score of the player.
     */
    public function getScore(): int 
    {
        $playerScore = 0;
        $cards = $this->cards;

        foreach ($cards as $card){
            $playerScore += $card->getPoints();
        }
        return $playerScore;
    }

    /**
     * Get the cards held by the player.
     *
     * @return array<Card> The cards held by the player.
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * @return array<int<0, max>, string>
     */
    public function getString(): array
    {
        $pCards = [];
        foreach ($this->cards as $card) {
            $pCards[] = $card->getAsString();
        }
        return $pCards;
    }
}