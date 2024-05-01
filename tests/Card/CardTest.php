<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;


class CardTest extends TestCase
{
    public function testCreateObject()
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);
    }
}