<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/article", name="api_liste", methods={"GET"})
     */
    public function liste(ArticleRepository $repo): Response
    {
        return $this->json($repo->findAll());
    }

    /**
     * @Route("/api/article", name="api_ajouter", methods={"POST"})
     */
    public function AjouterArticle(Request $req, EntityManagerInterface $em): Response
    {
        $body = json_decode($req->getContent());
        $article = new Article();

        $article->setName($body->name);
        $article->setIsBought(false);
        
        $em->persist($article);
        $em->flush();

        return $this->json($article);
    }

    /**
     * @Route("/api/article/{id}", name="api_delete", methods={"DELETE"})
     */
    public function supprimerArticle(Article $article, EntityManagerInterface $em): Response
    {
            $em->remove($article);
            $em->flush();

            return $this->json($article);
    }

    /**
     * @Route("/api/article/{id}", name="api_acheter", methods={"PUT"})
     */
    public function acheterArticle(Article $article, EntityManagerInterface $em): Response
    {
            $nouvel_etat = ! $article->getIsBought();
            $article->setIsBought($nouvel_etat);
            $em->flush();

            return $this->json($article);
    }
}
