<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\AddCourseType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{


    /**
     * @Route("/", name="accueil")
     */
    public function accueil(Request $req, EntityManagerInterface $em, ArticleRepository $cr): Response
    {
        $article = new Article();
        $form = $this->createForm(AddCourseType::class,$article);
        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $article->setIsBought(false);
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute("accueil");
        } else {
            $courses = $cr->findAll();

            return $this->render('shop/accueil.html.twig', [
                "courses" => $courses,
                "form" => $form->createView()
            ]);
        }
    }
}