<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class DealerTest extends TestCase
{
    public function testCreateObject()
    {
        $dealer = new Dealer();
        $this->assertInstanceOf(Dealer::class, $dealer);
    }
}
