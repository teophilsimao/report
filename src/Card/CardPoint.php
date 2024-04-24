<?php

namespace App\Card;

class CardPoint extends CardGraphic
{
    // /**
    //  * @var int|null
    //  */
    // private ?int $aceValue = null; // Define aceValue property

    /**
     * @var array<int|string, array<int, int>|int>
     */
    private $points = [
        'Ace' => [1, 14],
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
     * Set the value for Ace (1 or 14).
     *
     * @param int $value
     */
    public function setAceValue(int $value): void
    {
        $this->aceValue = $value;
    }

    /**
     * Get the points for the card.
     *
     * @return int|null
     */
    public function getPoints(): int|null
    {
        if ($this->rank === 'Ace') {
            return isset($this->aceValue) ? $this->aceValue : 1;
        }

        if (is_array($this->points[$this->rank])) {
            return $this->points[$this->rank][$this->aceValue === 1 ? 0 : 1];
        }

        return $this->points[$this->rank];

    }
}
