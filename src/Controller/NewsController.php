<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'app_news')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $news = $entityManager->getRepository(News::class)->findAll();

        return $this->render('news/index.html.twig', [
            'news' => $news,
        ]);
    }

    #[Route('/news/add', 'app_news_add')]
    public function add(EntityManagerInterface $entityManager): Response
    {
        $new = $entityManager->getRepository(News::class)->createNew();

        return $this->redirectToRoute('app_news_show', ['id' => $new->getId()]);
    }

    #[Route('/news/{id}', 'app_news_show')]
    public function show(News $new): Response
    {
        return $this->render('news/show.html.twig', ['new' => $new]);
    }

    #[Route('/news/modify/{id}', 'app_news_modify')]
    public function modify(EntityManagerInterface $entityManager, int $id): Response
    {
        $newToModify = $entityManager->getRepository(News::class)->find($id);

        if (!$newToModify) {
            throw $this->createNotFoundException(
                'No news found for id '.$id
            );
        }

        $entityManager->getRepository(News::class)->attachSomeContent($newToModify, 'Dodana treść.', true);


        return $this->redirectToRoute('app_news');

    }

    #[Route('/news/delete/{id}', 'app_news_delete')]
    function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $news = $entityManager->getRepository(News::class)->find($id);

        if (!$news) {
            throw $this->createNotFoundException(
                'No news found for id '.$id
            );
        }

        $entityManager->getRepository(News::class)->remove($news, true);


        return $this->redirectToRoute('app_news');

    }


}
