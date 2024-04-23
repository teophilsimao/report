<?php

namespace App\Card;

use App\Card\DeckOfCard;

class Player
{
    private array $cards = [];
    private bool $lost = false;

    public function hit(DeckOfCard $deck) {
        
        $this->cards[] = $deck->drawnCard();

        if($this->getScore()>21){
            $this->lost=true;
        }
    }

    public function getLost() {
        return $this->lost;
    }

    public function getScore(){
        $playerScore = 0;
        $cards = $this->cards;

        foreach ($cards as $card){
            $playerScore += $card->getPoints();
        }
        return $playerScore;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function getString(): array
    {
        $pCards = [];
        foreach ($this->cards as $card) {
            $pCards[] = $card->getAsString();
        }
        return $pCards;
    }
}