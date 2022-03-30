<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    #[Route('/wish', name: 'wish_list')]
    public function list(
        WishRepository $wishRepository
    ): Response
    {
        $wishes = $wishRepository->findAllWishes();
        return $this->render('wish/list.html.twig',
            compact("wishes")
        );
    }

    #[Route('/wish/detail/{id}', name: 'wish_detail')]
    public function details(

        WishRepository $wishRepository,
        Wish $wish
    ): Response
    {
        return $this->render('wish/detail.html.twig',
            compact("wish")
        );
    }
}
