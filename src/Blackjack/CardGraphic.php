<?php

namespace App\Blackjack;

class CardGraphic extends Card
{
    /**
     * @var array<string, array<int|string, string>>
     */
    private $representation = [
        'Hearts' => [
            'A' => 'A ♥️',
            '2' => '2 ♥️',
            '3' => '3 ♥️',
            '4' => '4 ♥️',
            '5' => '5 ♥️',
            '6' => '6 ♥️',
            '7' => '7 ♥️',
            '8' => '8 ♥️',
            '9' => '9 ♥️',
            '10' => '10 ♥️',
            'J' => 'J ♥️',
            'Q' => 'Q ♥️',
            'K' => 'K ♥️',
        ],
        'Diamonds' => [
            'A' => 'A ♦️',
            '2' => '2 ♦️',
            '3' => '3 ♦️',
            '4' => '4 ♦️',
            '5' => '5 ♦️',
            '6' => '6 ♦️',
            '7' => '7 ♦️',
            '8' => '8 ♦️',
            '9' => '9 ♦️',
            '10' => '10 ♦️',
            'J' => 'J ♦️',
            'Q' => 'Q ♦️',
            'K' => 'K ♦️',
        ],
        'Clubs' => [
            'A' => 'A ♣️',
            '2' => '2 ♣️',
            '3' => '3 ♣️',
            '4' => '4 ♣️',
            '5' => '5 ♣️',
            '6' => '6 ♣️',
            '7' => '7 ♣️',
            '8' => '8 ♣️',
            '9' => '9 ♣️',
            '10' => '10 ♣️',
            'J' => 'J ♣️',
            'Q' => 'Q ♣️',
            'K' => 'K ♣️',
        ],
        'Spades' => [
            'A' => 'A ♠️',
            '2' => '2 ♠️',
            '3' => '3 ♠️',
            '4' => '4 ♠️',
            '5' => '5 ♠️',
            '6' => '6 ♠️',
            '7' => '7 ♠️',
            '8' => '8 ♠️',
            '9' => '9 ♠️',
            '10' => '10 ♠️',
            'J' => 'J ♠️',
            'Q' => 'Q ♠️',
            'K' => 'K ♠️',
        ],
    ];

    public function __construct(string $rank, string $suit)
    {
        parent::__construct($rank, $suit);
    }

    public function __toString(): string
    {
        return "[{$this->representation[$this->getSuit()][$this->getRank()]}]";
    }
}
