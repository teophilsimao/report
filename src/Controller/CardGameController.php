<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCard;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    //Home
    #[Route("/card", name: "card_home")]
    public function home(SessionInterface $session): Response
    {
        if (!$session->isStarted()) {
            $session->start();
        }

        $deck = new DeckOfCard();
        $deck->createDeck();
        $session->set('deck', $deck);


        return $this->render('card/home.html.twig');
    }

    //Deck
    #[Route("/card/deck", name: "deck_start", methods: ['GET'])]
    public function cardDeck(
        Request $request,
        SessionInterface $session
    ): Response {
        $numCards = $request->request->get('cards');

        $deck = $session->get('deck');
        $deckStr = $deck->getString();

        $data = [
            "deckStr" => $deckStr
        ];

        return $this->render('card/deck.html.twig', $data);
    }


    #[Route("/card/deck/shuffle", name: "deck_shuffle", methods: ['GET'])]
    public function cardDeckShuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCard();
        $deck->createDeck();
        $session->set('deck', $deck);
        $deck = $session->get('deck');
        $shuffled = $deck->getStringShuffled();

        $data = [
            "shuffled" => $shuffled
        ];

        return $this->render('card/shuffle.html.twig', $data);
    }

    #[Route("/card/draw", name: "deck_draw", methods: ['GET'])]
    public function cardDraw(
        SessionInterface $session
    ): Response {
        $deck = $session->get('deck');

        $drawCard = $deck->drawCard();

        $session->set('deck', $deck);
        $deckStr = $deck->getString();

        $data = [
            "drawCard" => $drawCard,
            "deckStr" => $deckStr
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/card/deck", name: "deck_post", methods: ['POST'])]
    public function cardDeckPost(
        Request $request,
        SessionInterface $session
    ): Response {
        $number = $request->request->get('cards');
        $session->set("number", $number);


        return $this->redirectToRoute('deck_drawhand', ['number' => $number]);
    }

    #[Route("/card/deck/shuffle", name: "deckshuffle_post", methods: ['POST'])]
    public function cardDeckShufflePost(
        Request $request,
        SessionInterface $session
    ): Response {
        $number = $request->request->get('cards');
        $session->set("number", $number);


        return $this->redirectToRoute('deck_drawhand', ['number' => $number]);
    }

    #[Route("/card/draw/{number<\d+>}", name: "deck_drawhand", methods: ['GET'])]
    public function cardDrawHand(
        SessionInterface $session
    ): Response {
        $deck = $session->get('deck');

        $number = $session->get('number');

        $drawnCards = [];
        for ($i = 0; $i < $number; $i++) {
            $drawnCard = $deck->drawCard();
            if ($drawnCard !== null) {
                $drawnCards[] = $drawnCard;
            }
        }
        $session->set('deck', $deck);

        $deckStr = $deck->getString();

        $data = [
            "drawnCards" => $drawnCards,
            "deckStr" => $deckStr,
            "number" => $number
        ];

        return $this->render('card/drawmany.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function deleteSession(SessionInterface $session): Response
    {
        $session->clear();

        if (!$session->isStarted()) {
            $session->start();
        }

        $deck = new DeckOfCard();
        $deck->createDeck();
        $session->set('deck', $deck);

        $this->addFlash(
            'notice',
            'nu är sessionen raderad'
        );

        return $this->redirectToRoute('deck_start');
    }

}
