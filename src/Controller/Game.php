<?php

namespace App\Controller;

use App\Card\CardPoint;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Game extends AbstractController
{
    #[Route("/game/test/point", name: "card_point")]
    public function cardPoint(): Response 
    {
        $card = new CardPoint();
        $card->drawCard();
        $cardStr = $card->getAsString();
        $cardPoint = $card->getPoints();

        $data = [
            "card" => $cardStr,
            "point" => $cardPoint
        ];

        return $this->render('game/test/cardpoint.html.twig', $data);

    }
}