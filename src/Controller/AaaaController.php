<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AaaaController extends AbstractController
{
    #[Route('/aaaa', name: 'app_aaaa')]
    public function index(): Response
    {
        return $this->render('aaaa/index.html.twig', [
            'controller_name' => 'AaaaController',
        ]);
    }
}
