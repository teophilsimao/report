<?php

namespace App\Card;

use App\Card\DeckOfCard;

class Dealer extends Player
{
    public function hit(DeckOfCard $deck): void 
    {
            parent::hit($deck);
    }
}