<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {
        //$new = $entityManager->getRepository(News::class)->createNew();
        $form = $this->createForm(NewsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $new = $form->getData();
            $new->setDateAdd(new \DateTime());
            $entityManager->persist($new);
            $entityManager->flush();
            $this->addFlash('success', 'New has been saved successfully!');

            return $this->redirectToRoute('app_news_show', ['id' => $new->getId()]);
        }

        return $this->render('news/add.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/news/{id}', 'app_news_show')]
    public function show(News $new): Response
    {
        return $this->render('news/show.html.twig', ['new' => $new]);
    }

    #[Route('/news/modify/{id}', 'app_news_modify')]
    public function modify(News $new, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(NewsType::class, $new);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $new = $form->getData();
            $new->setDateModified(new \DateTime());
            $entityManager->persist($new);
            $entityManager->flush();
            $this->addFlash('success', 'New has been modified successfully!');

            return $this->redirectToRoute('app_news_show', ['id' => $new->getId()]);
        }

        return $this->render('news/modify.html.twig', [
            'form' => $form,
            'new' => $new
        ]);


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
