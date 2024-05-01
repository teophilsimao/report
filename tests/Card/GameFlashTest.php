<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

class GameFlashTest extends TestCase
{   
    public function testSetFlashPlayerWins():void
    {
        $gameFlash = new GameFlash();
        $result = $gameFlash->setFlash(20, 15);

        
        $this->assertTrue($result['showFlashMessage']);
        // @phpstan-ignore-next-line
        $this->assertEquals('notice', $result['flashMessage']['type']);
        // @phpstan-ignore-next-line
        $this->assertEquals('Du vann!', $result['flashMessage']['message']);
    }

    public function testSetFlashDealerWins():void
    {
        $gameFlash = new GameFlash();
        $result = $gameFlash->setFlash(15, 20);

        $this->assertTrue($result['showFlashMessage']);
        // @phpstan-ignore-next-line
        $this->assertEquals('warning', $result['flashMessage']['type']);
        // @phpstan-ignore-next-line
        $this->assertEquals('Du förlorade!', $result['flashMessage']['message']);
    }

    public function testSetFlashPlayerLoses():void
    {
        $gameFlash = new GameFlash();
        $result = $gameFlash->setFlash(18, 19);

        $this->assertTrue($result['showFlashMessage']);
        // @phpstan-ignore-next-line
        $this->assertEquals('warning', $result['flashMessage']['type']);
        // @phpstan-ignore-next-line
        $this->assertEquals('Du förlorade!', $result['flashMessage']['message']);
    }
}
