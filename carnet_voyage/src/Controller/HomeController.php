<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function main(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository(Article::class)->findAll();
        return $this->render('home/main.html.twig',[
            "articles" => $articles
        ]);
    }
}
