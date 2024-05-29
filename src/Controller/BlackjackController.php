<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Blackjack\BlackjackGame;

class BlackjackController extends AbstractController
{
    #[Route("/proj", name: "proj_home")]
    public function projHome(): Response
    {

    }

    #[Route("/proj/blackjack", name: "blackjack_home")]
    public function blackjackStart(SessionInterface $session, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $playerNames = $request->request->all('playerNames');
            $playerBets = $request->request->all('playerBets');
            $game = new BlackjackGame($playerNames);

            foreach ($game->getPlayers() as $index => $player) {
                $bet = intval($playerBets[$index]);
                $player->placeBet($bet);
            }

            $game->init();
            $session->set('game', $game);

            return $this->redirectToRoute('blackjack_game');
        }

        return $this->render('blackjack/input_players.html.twig');
    }

    #[Route("/proj/blackjack/game", name: "blackjack_game")]
    public function game(Request $request, SessionInterface $session): Response
    {
        $game = $session->get('game');

        if (!$game) {
            return $this->redirectToRoute('blackjack_home');
        }

        if ($request->isMethod('POST')) {
            $formGet = $request->request->all();

            $this->forAction($game, $formGet);

            foreach ($game->getPlayers() as $index => $player) {
                if ($player->getMoney() <= 0) {
                    $game->removePlayer($index);
                }
            }

            if ($game->playerStatus()) {
                $game->dealerPlay();
                $session->set('game', $game);
                return $this->redirectToRoute('blackjack_game_result');
            }

            $session->set('game', $game);
        }

        return $this->render('blackjack/game.html.twig', [
            'gameStatus' => (string)$game,
            'players' => $game->getPlayers(),
        ]);
    }

    #[Route("/proj/blackjack/game/result", name: "blackjack_game_result")]
    public function result(SessionInterface $session): Response
    {
        $game = $session->get('game');
        if (!$game) {
            return $this->redirectToRoute('blackjack_home');
        }

        $results = $game->getResults();

        return $this->render('blackjack/result.html.twig', [
            'gameStatus' => (string)$game,
            'results' => $results,
            'players' => $game->getPlayers(),
        ]);
    }

    #[Route("/proj/blackjack/new_round", name: "blackjack_new_round")]
    public function newRound(SessionInterface $session, Request $request): Response
    {
        $game = $session->get('game');

        if (!$game) {
            return $this->redirectToRoute('blackjack_home');
        }

        if ($request->isMethod('POST')) {

            $game->reset();

            $playerBets = $request->request->all('playerBets');

            foreach ($game->getPlayers() as $index => $player) {
                $bet = intval($playerBets[$index]);
                $player->placeBet($bet);
            }

            $game->init();
            $session->set('game', $game);

        }

        return $this->redirectToRoute('blackjack_game');
    }

    // @phpstan-ignore-next-line
    private function forAction($game, array $formGet): void
    {
        foreach ($game->getPlayers() as $index => $player) {
            if (isset($formGet['action'][$index]) && $formGet['action'][$index] == 'h') {
                $game->hit($player);
            } elseif (isset($formGet['action'][$index]) && $formGet['action'][$index] == 's') {
                $game->stand($player);
            }
        }
    }
}
