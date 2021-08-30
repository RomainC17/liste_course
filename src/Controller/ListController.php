<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route("/", name="liste")
     */
    public function liste(ArticleRepository $repo): Response
    {
        $listeArticles = $repo->findAll();

        return $this->render('shop/liste.html.twig', [
            'listeArticles' => $listeArticles,
        ]);
    }

    /**
     * @Route("/AjouterArticle", name="AjouterArticle")
     */
    public function AjouterArticle(Request $request, EntityManagerInterface $em): Response
    {
        $name = $request->get('name');

        $article = new Article();

        $article->setName($name);
        $article->setIsChecked(false);

        $em->persist($article);
        $em->flush();

        return $this->redirectToRoute('liste');
    }

    /**
     * @Route("/supprimer/{id}", name="supprimerArticle")
     */
    public function supprimerArticle(Article $article, EntityManagerInterface $em): Response
    {
            $em->remove($article);
            $em->flush();

            return $this->redirectToRoute('liste');
    }
}
