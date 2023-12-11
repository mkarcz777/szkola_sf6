<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game/new', name: 'app_game_new')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADD'); //wazna funkcja, pozwala zaoszczedzic czas zamiast pisania
        // bezusytecznego kodu typu if (!user->hasAccess then ...)

        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        // tylko dla admina; drugi sposob to konfiguracja
        // tego w security.yaml, sekcja access_control

//        $game = new Game();
//        $form = $this->createForm(GameType::class, $game);
        $form = $this->createForm(GameType::class); // p. GameType::configureOptions - domyslna klasa formularza

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();

            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash('success', 'Your changes saved successfully!');

            return $this->redirectToRoute('app_game_show', ['id' => $game->getId()]);
        }



        return $this->render('game/new.html.twig', ['form' => $form]);
    }

    #[Route('/game/edit/{id}', name: 'app_game_edit')]
    public function edit(Game $game, EntityManagerInterface $entityManager, Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_EDIT');
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();

            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash('success', 'Your changes saved successfully!');

            return $this->redirectToRoute('app_game_show', ['id' => $game->getId()]);
        }



        return $this->render('game/edit.html.twig', ['form' => $form, 'game' => $game]);
    }

    #[Route('/game/{id}', name: 'app_game_show')]
    public function show(Game $game): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('game/show.html.twig', ['game' => $game]);
    }

    #[Route('/games', name: 'app_game_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');


        $games = $entityManager->getRepository(Game::class)->findAll();

        return $this->render('game/list.html.twig', ['games'=> $games]);
    }

    #[Route('/games/top', name: 'app_game_top_list')]
    public function toplist(EntityManagerInterface $entityManager): Response
    {
        $games = $entityManager->getRepository(Game::class)->findAllWithScore();

        return $this->render('game/toplist.html.twig', ['games'=> $games]);
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
