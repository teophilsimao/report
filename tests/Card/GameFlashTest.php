<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class GameFlashTest extends TestCase
{
    public function testSetFlashPlayerWins()
    {
        $gameFlash = new GameFlash();
        $result = $gameFlash->setFlash(20, 15);

        $this->assertTrue($result['showFlashMessage']);
        $this->assertEquals('notice', $result['flashMessage']['type']);
        $this->assertEquals('Du vann!', $result['flashMessage']['message']);
    }

    public function testSetFlashDealerWins()
    {
        $gameFlash = new GameFlash();
        $result = $gameFlash->setFlash(15, 20);

        $this->assertTrue($result['showFlashMessage']);
        $this->assertEquals('warning', $result['flashMessage']['type']);
        $this->assertEquals('Du förlorade!', $result['flashMessage']['message']);
    }

    public function testSetFlashPlayerLoses()
    {
        $gameFlash = new GameFlash();
        $result = $gameFlash->setFlash(18, 19);

        $this->assertTrue($result['showFlashMessage']);
        $this->assertEquals('warning', $result['flashMessage']['type']);
        $this->assertEquals('Du förlorade!', $result['flashMessage']['message']);
    }
}
