<?php

namespace App\Controller;

use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/bucket', name: "main_accueil")]
    public function accueil(){
        return $this->render('main/home.html.twig');
    }

    #[Route('/bucket/about_us', name: "bucket_about")]
    public function about(){
        return $this->render('main/about_us.html.twig');
    }
}