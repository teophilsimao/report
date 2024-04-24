<?php

namespace App\Card;



class GameFlash
{
    public function setFlash(mixed $pPoint, mixed $dPoint): array
    {
        $showFlashMessage = true;
        $flashMessage = '';

        if ($pPoint > $dPoint && $pPoint < 21 || $dPoint > 21) {
            $flashMessage = [
                'type' => 'notice',
                'message' => 'Grattis, du har vunnit!'
            ];
        } else {
            $flashMessage = [
                'type' => 'warning',
                'message' => 'Tyvärr, du har förlorat.'
            ];
        }

        return [
            'showFlashMessage' => $showFlashMessage,
            'flashMessage' => $flashMessage
        ];
    }
}