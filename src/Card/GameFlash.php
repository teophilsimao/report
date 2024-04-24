<?php

namespace App\Card;



class GameFlash
{
    /**
     * @return array<string, array<string, string>|true>
     */
    public function setFlash(mixed $pPoint, mixed $dPoint): array
    {
        $showFlashMessage = true;
        $flashMessage = [
            'type' => 'warning',
            'message' => 'Tyvärr, du har förlorat.'
        ];

        if ($pPoint > $dPoint && $pPoint < 21 || $dPoint > 21) {
            $flashMessage = [
                'type' => 'notice',
                'message' => 'Grattis, du har vunnit!'
            ];
        }

        return [
            'showFlashMessage' => $showFlashMessage,
            'flashMessage' => $flashMessage
        ];
    }
}