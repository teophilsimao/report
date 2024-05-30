<?php

namespace App\Blackjack;

class BlackjackGame
{
    private Deck $deck;
    // @phpstan-ignore-next-line
    private array $players = [];
    private Player $dealer;
    // @phpstan-ignore-next-line
    private array $playersStanding = [];

    // @phpstan-ignore-next-line
    public function __construct(array $playerNames)
    {
        $this->deck = new Deck();
        foreach ($playerNames as $name) {
            $this->players[] = new Player($name);
        }
        $this->dealer = new Player("Dealer");
    }

    public function init(): void
    {
        for ($i = 0; $i < 2; $i++) {
            foreach ($this->players as $player) {
                $player->getHand()->addCard($this->deck->draw());
            }
            $this->dealer->getHand()->addCard($this->deck->draw());
        }
    }

    // @phpstan-ignore-next-line
    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getDealer(): Player
    {
        return $this->dealer;
    }

    public function hit(Player $player): void
    {
        $player->getHand()->addCard($this->deck->draw());
    }

    public function isBust(Player $player): bool
    {
        return $player->getHand()->getValue() > 21;
    }

    public function dealerPlay(): void
    {
        while ($this->dealer->getHand()->getValue() < 17) {
            $this->hit($this->dealer);
        }
    }

    public function stand(Player $player): void
    {
        $player->stand();
        $this->playersStanding[] = $player->getName();
    }

    public function playerStatus(): bool
    {
        foreach ($this->players as $player) {
            if (!$this->isBust($player) && !in_array($player->getName(), $this->playersStanding)) {
                return false;
            }
        }
        return true;
    }

    public function reset(): void
    {
        $this->deck = new Deck();
        foreach ($this->players as $player) {
            $player->reset();
        }
        $this->dealer->reset();
        $this->playersStanding = [];
    }

    public function removePlayer(int $index): void
    {
        if (isset($this->players[$index])) {
            unset($this->players[$index]);
            $this->players = array_values($this->players);
        }
    }

    /**
     * Warning about not needing else expression,
     * but i would much rather have it writen like this.
     *
     * @SuppressWarnings(PHPMD)
     */
    // @phpstan-ignore-next-line
    public function getResults(): array
    {
        $dealerValue = $this->dealer->getHand()->getValue();
        $results = [];

        foreach ($this->players as $player) {
            $playerValue = $player->getHand()->getValue();
            if ($playerValue > 21) {
                $player->loseBet();
                $results[] = "{$player->getName()} fick {$playerValue} och förlorade";
            } elseif ($dealerValue > 21 || $playerValue > $dealerValue) {
                $player->winBet();
                $results[] = "{$player->getName()} fick {$playerValue} och vann";
            } elseif (($playerValue <= 21 && $playerValue < $dealerValue) || ($playerValue < 20 && $playerValue === $dealerValue)) {
                $player->loseBet();
                $results[] = "{$player->getName()} fick {$playerValue} och förlorade";
            } elseif (($playerValue === 20 || $playerValue === 21) && $playerValue === $dealerValue) {
                $player->drawBet();
                $results[] = "{$player->getName()} fick {$playerValue} och gick lika";
            }
        }

        return $results;
    }

    public function __toString(): string
    {
        $status = array_map(function ($player) {
            return (string)$player;
        }, $this->players);
        $status[] = (string)$this->dealer;
        return implode("\n", $status);
    }
}
