<?php

namespace App\Controller;


use App\Message\SendKey;
use App\Service\ArrayRandomizer;
use App\Service\CodeGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index.home')]
    public function home(): Response
    {
        return $this->render(view: 'index/home.html.twig');
    }
    #[Route('/about', name: 'index.about')]
    public function about(): Response
    {
        return $this->render(view: 'index/about.html.twig');
    }

    #[Route('/code', name: 'index.code')]
    public function code(CodeGenerator $codeGenerator): Response
    {
        $code = $codeGenerator->generate();

        return $this->render(view: 'index/code.html.twig', parameters: ['code' => $code]);
    }

    #[Route('/sendcode', name: 'index.sendcode')]
    public function sendCode(MessageBusInterface $bus): JsonResponse
    {
        $bus->dispatch(new SendKey('player@asphp.pl'));

        return new JsonResponse(['status' => 'Email sent']);
    }

    #[Route('/hello/{firstName}', name: 'index.hello', methods: ['GET'])]
    public function hello(string $firstName = 'anonymous'): Response
    {
        $favGames = [
            'CS:GO',
            'WoW',
            'HoMM3'
        ];
        return $this->render(view: 'index/hello.html.twig',
            parameters: [
                'firstname' => $firstName,
                'favGames' => $favGames
            ]);
    }

    #[Route('/top', name: 'index.top')]
    public function top(): Response
    {
        $topGames = [
            'CS:GO',
            'WoW'
        ];
        return new JsonResponse(data: $topGames);
    }

    #[Route('/topgame', name: 'index.topgame')]
    public function topGame(): Response
    {
        $topGames = [
            'CS:GO',
            'WoW',
            'WoW2',
            'GTA'
        ];
        return $this->render(view: 'index/topgame.html.twig',parameters: ['topGames' => $topGames]);
    }

    #[Route('/randomgames', name: 'index.randomgames')]
    public function randomGames(ArrayRandomizer $arrayRandomizer): Response
    {
        $topGames = [
            'CS:GO',
            'WoW',
            'WoW2',
            'GTA',
            'HoMM3',
            'Minecraft',
            'FIFA 23',
            'Unreal Tournament',
            'The Witcher',
            'Baldurs Gate',
        ];

        $randomGames = $arrayRandomizer->getRandomElements($topGames, 5);

        return $this->render(view: 'index/randomgames.html.twig',parameters: ['randomGames' => $randomGames]);
    }

}