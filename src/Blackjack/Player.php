<?php

namespace App\Blackjack;

class Player
{
    private string $name;
    private Hand $hand;
    private int $money;
    private int $currentBet;
    private bool $standing;


    public function __construct(string $name)
    {
        $this->name = $name;
        $this->hand = new Hand();
        $this->money = 1000;
        $this->currentBet = 0;
        $this->standing = false;
    }

    public function getHand(): Hand
    {
        return $this->hand;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMoney(): int
    {
        return $this->money;
    }

    public function getCurrentBet(): int
    {
        return $this->currentBet;
    }

    public function placeBet(int $bet): void
    {
        $this->currentBet = $bet;
        $this->money -= $bet;
    }

    public function winBet(): void
    {
        $this->money += 2 * $this->currentBet;
        $this->currentBet = 0;
    }

    public function loseBet(): void
    {
        $this->currentBet = 0;
    }

    public function drawBet(): void
    {
        $this->money += $this->currentBet;
        $this->currentBet = 0;
    }

    public function stand(): void
    {
        $this->standing = true;
    }

    public function isStanding(): bool
    {
        return $this->standing;
    }

    public function reset(): void
    {
        $this->hand = new Hand();
        $this->standing = false;
        $this->currentBet = 0;
    }

    public function __toString(): string
    {
        return "{$this->name}: {$this->hand} (value: {$this->hand->getValue()})";
    }
}
