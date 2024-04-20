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

class CardGame extends AbstractController
{
    //Home, starts session
    #[Route("/card", name:"card_home")]
    public function home(SessionInterface $session): Response
    {
        if (!$session->has('deck')) {
            $deck = new DeckOfCard();
            $deck->add(new CardGraphic());
            $deck->createDeck();
            $session->set('deck', $deck);
        }

        return $this->render('card/home.html.twig');
    }



    //Deck
    #[Route("/card/deck", name: "deck", methods: ['GET'])]
    public function cardDeck(
        SessionInterface $session
    ): Response 
    {
         /** 
          * @var DeckOfCard $deck 
          */
        $deck = $session->get('deck');
        $deck = $deck->getString();

        $data = [
            "deck" => $deck
        ];

        return $this->render('card/deck.html.twig', $data);

    }



    //Shuffle Deck
    #[Route("/card/deck/shuffle", name: "deck_shuffle", methods: ['GET'])]
    public function shuffledDeck(
        SessionInterface $session
    ): Response 
    {
        /** 
         * @var DeckOfCard $deck 
         */
        $deck = new DeckOfCard();
        $deck->add(new CardGraphic());
        $deck->createDeck();
        $deck->shuffle();
        $session->set('deck', $deck);

        $data = [
            "deck" => $deck->getString()
        ];

        return $this->render('card/deckshuffle.html.twig', $data);

    }



    //Deck Draw one card
    #[Route("/card/deck/draw", name: "deck_draw", methods: ['GET'])]
    public function cardDraw(
        SessionInterface $session
    ): Response 
    {
        /** 
         * @var DeckOfCard $deck 
         */
        $deck = $session->get('deck');

        $drawnCard = $deck->drawnCard();

        $cardString = '';
        if ($drawnCard !== null) {
            $cardString = $drawnCard->getAsString();
        }

        $session->set('deck', $deck);

        $data = [
            "card" => $cardString,
            "deck" => $deck->getString()
        ];

        return $this->render('card/draw.html.twig', $data);

    }



    //Card Form
    #[Route("/card/cardform", name: "cardform", methods: ['GET'])]
    public function cardForm(
        SessionInterface $session
    ): Response {
        $deck = $session->get('deck');

        if ($deck instanceof DeckOfCard) {
            $deckString = $deck->getString();
        } 
        $deckString = '';

        $data = [
            "deck" => $deckString
        ];

        return $this->render('card/cardform.html.twig', $data);
    }



    //Cardform Post
    #[Route("/card/cardform", name: "cardform_post", methods: ['POST'])]
    public function cardFormPost(
        Request $request,
        SessionInterface $session
    ): Response {
        $number = $request->request->get('cards');
        $session->set("number", $number);

        return $this->redirectToRoute('deck_drawHand', ['number' => $number]);
    }

    //Deck Draw a hand
    #[Route("/card/deck/draw/{number<\d+>}", name: "deck_drawHand", methods: ['GET'])]
    public function cardDrawHand(
        SessionInterface $session
    ): Response {
        $deck = $session->get('deck');
        $number = $session->get('number');

        if (!$deck instanceof DeckOfCard) {
            return $this->redirectToRoute('deck');
        }

        $handStr = [];


        for ($i = 0; $i < $number; $i++) {
            $drawnCardStr = $deck->drawnCards(new CardHand());

            if ($drawnCardStr !== null) {
                $handStr[] = $drawnCardStr;
            }
        }

        $session->set('deck', $deck);

        $data = [
            "hand" => $handStr,
            "deck" => $deck->getString()
        ];

        return $this->render('card/drawhand.html.twig', $data);
    }

    //Delete, clears and starts session
    #[Route("/session/delete", name:"session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash(
            'notice',
            'nu är sessionen raderad'
        );

        return $this->redirectToRoute('home');
    }

    #[Route("/session", name:"session")]
    public function dumpSession(SessionInterface $session): Response
    {
        $sessionData = $session->all();

        return $this->render('session.html.twig', [
            'sessionData' => $sessionData
        ]);
    }
}
