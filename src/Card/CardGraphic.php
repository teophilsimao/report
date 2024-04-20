<?php

namespace App\Card;

class CardGraphic extends Card
{
    /**
     * @var array<string, array<int|string, string>>
     */
    private $representation = [
        'Heart' => [
            'Ace' => 'A ♥️',
            '2' => '2 ♥️',
            '3' => '3 ♥️',
            '4' => '4 ♥️',
            '5' => '5 ♥️',
            '6' => '6 ♥️',
            '7' => '7 ♥️',
            '8' => '8 ♥️',
            '9' => '9 ♥️',
            '10' => '10 ♥️',
            'Jack' => 'J ♥️',
            'Queen' => 'Q ♥️',
            'King' => 'K ♥️',
        ],
        'Diamond' => [
            'Ace' => 'A ♦️',
            '2' => '2 ♦️',
            '3' => '3 ♦️',
            '4' => '4 ♦️',
            '5' => '5 ♦️',
            '6' => '6 ♦️',
            '7' => '7 ♦️',
            '8' => '8 ♦️',
            '9' => '9 ♦️',
            '10' => '10 ♦️',
            'Jack' => 'J ♦️',
            'Queen' => 'Q ♦️',
            'King' => 'K ♦️',
        ],
        'Club' => [
            'Ace' => 'A ♣️',
            '2' => '2 ♣️',
            '3' => '3 ♣️',
            '4' => '4 ♣️',
            '5' => '5 ♣️',
            '6' => '6 ♣️',
            '7' => '7 ♣️',
            '8' => '8 ♣️',
            '9' => '9 ♣️',
            '10' => '10 ♣️',
            'Jack' => 'J ♣️',
            'Queen' => 'Q ♣️',
            'King' => 'K ♣️',
        ],
        'Spade' => [
            'Ace' => 'A ♠️',
            '2' => '2 ♠️',
            '3' => '3 ♠️',
            '4' => '4 ♠️',
            '5' => '5 ♠️',
            '6' => '6 ♠️',
            '7' => '7 ♠️',
            '8' => '8 ♠️',
            '9' => '9 ♠️',
            '10' => '10 ♠️',
            'Jack' => 'J ♠️',
            'Queen' => 'Q ♠️',
            'King' => 'K ♠️',
        ],
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsString(): string
    {
        return "[{$this->representation[$this->suit][$this->rank]}]";
    }
}
