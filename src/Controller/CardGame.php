<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
// use App\Card\CardHand;
// use App\Card\DeckOfCard;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGame extends AbstractController
{
    // test part
    #[Route("/card/test/acard", name: "one_card")]
    public function oneCard(): Response
    {
        $card = new Card();
        $card->drawCard();

        $data = [
            "card" => $card->getAsString()
        ];

        return $this->render('card/test/card.html.twig', $data);
    }

    #[Route("/card/test/hand", name: "card_hand")]
    public function cardHand(): Response
    {
        $card = new Card();
        $card->drawCard();

        $data = [
            "card" => $card->getAsString()
        ];

        return $this->render('card/test/card.html.twig', $data);
    }
}