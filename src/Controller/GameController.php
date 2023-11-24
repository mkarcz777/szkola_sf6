<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $game = new Game();
        $game->setName('Assasin\'s Craddle')
            ->setDescription('Opis gry Assasin Craddle')
            ->setScore(8)
            ->setReleaseDate(new \DateTime('2017-03-03'));

        $entityManager->getRepository(Game::class)->save($game, true);

        return new Response('Saved new game with id '.$game->getId());
    }

    #[Route('/game/{id}', name: 'app_game_show')]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', ['game' => $game]);
    }

    #[Route('/games', name: 'app_game_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $games = $entityManager->getRepository(Game::class)->findAll();

        return $this->render('game/list.html.twig', ['games'=> $games]);
    }

    #[Route('/games/top', name: 'app_game_top_list')]
    public function toplist(EntityManagerInterface $entityManager): Response
    {
        $games = $entityManager->getRepository(Game::class)->findAllWithScore();

        return $this->render('game/toplist.html.twig', ['games'=> $games]);
    }

    #[Route('/game/edit/{id}', name: 'app_game_edit')]
    public function edit(EntityManagerInterface $entityManager, int $id): Response
    {
        $game = $entityManager->getRepository(Game::class)->find($id);

        if (!$game) {
            throw $this->createNotFoundException(
                'No game found for id '.$id
            );
        }
        $entityManager->getRepository(Game::class)->setScore($game, 10, true);

        return $this->redirectToRoute('app_game_show', ['id' => $game->getId()]);
    }

    #[Route('/game/delete/{id}', 'app_game_delete')]
    function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $game = $entityManager->getRepository(Game::class)->find($id);

        if (!$game) {
            throw $this->createNotFoundException(
                'No game found for id '.$id
            );
        }

        $entityManager->getRepository(Game::class)->remove($game, true);


        return $this->redirectToRoute('app_game_list');

    }
}
