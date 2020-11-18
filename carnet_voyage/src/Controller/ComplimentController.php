<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComplimentController extends AbstractController
{
    /**
     * @Route("/compliment", name="compliment")
     */
    public function index(): Response
    {
        return $this->render('compliment/index.html.twig', [
            'controller_name' => 'ComplimentController',
        ]);
    }
}
