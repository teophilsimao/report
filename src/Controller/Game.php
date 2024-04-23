<?php

namespace App\Controller;

use App\Card\CardPoint;
use App\Card\CardHand;
use App\Card\DeckOfCard;
use App\Card\Player;
use App\Card\Game21;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Game extends AbstractController
{

    #[Route("/game", name: "game21_home")]
    public function game21(SessionInterface $session): Response
    {
        if (!$session->has('deck')) {
            $game21 = new Game21();

            $deck = $game21->getDeck();
            $session->set('deck', $deck);

            $session->set('playerPoint', 0);
            $session->set('dealerPoint', 0);
            $session->set('latestCardRank', '');


            $player = $game21->getPlayer();
            $session->set('player', $player);

            $dealer = $game21->getDealer();
            $session->set('dealer', $dealer);
        }

        return $this->render('game/home.html.twig');
    }

    #[Route("/game/play", name: "game21_play", methods: ['GET'])]
    public function game21Play(SessionInterface $session): Response
    {
        $player = $session->get('player');
        $dealer = $session->get('dealer');
        $pPoint = $session->get('playerPoint');
        $dPoint = $session->get('dealerPoint');

        if ($pPoint > 21) {
            $session->set('showFlashMessage', true);
            $this->addFlash(
                'warning',
                'Tyvärr, du har förlorat.'
            );
        }
        
        $data = [
            "pCards" => $player->getString(),
            "pPoints" => $pPoint,
            "latestCardRank" => $session->get('latestCardRank'),
            "dCards" => $dealer->getString(),
            "dPoints" => $dPoint,
            "showFlashMessage" => $session->get('showFlashMessage')
        ];

        return $this->render('game/play.html.twig', $data);
    }

    #[Route("/game/hit", name: "game21_hit", methods: ['POST'])]
    public function game21Hit(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $player = $session->get('player');
        $pPoint = $session->get('playerPoint');

        $player->hit($deck);

        $cards = $player->getCards();
        $latestCard = end($cards);

        if ($cards) {
            $latestCardRank = $latestCard->getRank();
            $session->set('latestCardRank', $latestCardRank);

            if ($latestCardRank === 'Ace') {
                return $this->redirectToRoute('game21_play');
            }
        }

        $session->set('player', $player);
        $pPoint = $player->getScore();
        $session->set('playerPoint', $pPoint);

        return $this->redirectToRoute('game21_play');
    }

    #[Route("/game/aceform", name: "game21_aceform", methods: ['POST'])]
    public function game21AceForm(SessionInterface $session, Request $request): Response
    {
        $aceValue = $request->request->get('aceValue');
        $player = $session->get('player');
        $pPoint = $session->get('playerPoint');

        $cards = $player->getCards();
        $latestCard = end($cards);

        $latestCardRank = $latestCard->getRank();
        $session->set('latestCardRank', $latestCardRank);

        if ($latestCardRank === 'Ace') {
            $latestCard->setAceValue((int)$aceValue);
        }

        $session->set('player', $player);
        $pPoint = $player->getScore();
        $session->set('playerPoint', $pPoint);

        return $this->redirectToRoute('game21_play');
    }

    #[Route("/game/stand", name: "game21_stand", methods: ['POST'])]
    public function game21Stand(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $dealer = $session->get('dealer');
        $dPoint = $session->get('dealerPoint');
        $pPoint = $session->get('playerPoint');

        while ($dPoint < $pPoint) {
            $dealer->hit($deck);
            $cards = $dealer->getCards();
            $latestCard = end($cards);
            $latestCardRank = $latestCard->getRank();

            if ($latestCardRank === 'Ace') {
                $aceValue = ($dPoint < 7) ? 14 : 1;
                $latestCard->setAceValue($aceValue);
            }
            
            $dPoint = $dealer->getScore();
        }

        $session->set('dealer', $dealer);
        $session->set('dealerPoint', $dPoint);

        if ($pPoint > $dPoint && $pPoint < 21 || $dPoint > 21) {
            $session->set('showFlashMessage', true);
            $this->addFlash(
                'notice',
                'Grattis, du har vunnit!'
            );
        } else {
            $session->set('showFlashMessage', true);
            $this->addFlash(
                'warning',
                'Tyvärr, du har förlorat.'
            );
        }

        return $this->redirectToRoute('game21_play');
    }

    #[Route("game/restart", name: "game21_restart", methods: ['POST'])]
    public function car21Restart(SessionInterface $session): Response
    {   
        $session->clear();

        if (!$session->has('deck')) {
            $game21 = new Game21();

            $deck = $game21->getDeck();
            $session->set('deck', $deck);

            $session->set('playerPoint', 0);
            $session->set('dealerPoint', 0);
            $session->set('latestCardRank', '');


            $player = $game21->getPlayer();
            $session->set('player', $player);

            $dealer = $game21->getDealer();
            $session->set('dealer', $dealer);
        }

        return $this->redirectToRoute('game21_play');
    }

}