<?php

namespace App\Card;

class CardPoint extends CardGraphic
{
    /**
     * @var array<int|string, int>
     */
    private $points = [
        'Ace' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'Jack' => 11,
        'Queen' => 12,
        'King' => 13,
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points[$this->rank];
    }
}