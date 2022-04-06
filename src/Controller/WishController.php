<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use App\services\Censurator;
use App\services\Courriel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
        Wish           $wish
    ): Response
    {
        return $this->render('wish/detail.html.twig',
            compact("wish")
        );
    }

    #[Route('/wish/ajouter', name: 'wish_ajouter')]
    public function ajouter(

        EntityManagerInterface $em,
        Request                $request,
        Courriel               $courriel,
        Censurator $censurator
    ): Response
    {
        $wish = new Wish();
        $wish->setAuthor($this->getUser()->getUserIdentifier());
        $wish->setDateCreated(new \DateTime('now'));
        $wish->setIsPublished(true);
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $titrePurifie = $censurator->purify($wish->getTitle());
            $wish->setTitle($titrePurifie);
            $em->persist($wish);
            $em->flush();

            $courriel->envoie();

            $this->addFlash('info', "Idea successfully added!");
            return $this->redirectToRoute('wish_list');
        }

        return $this->render(
            'wish/ajout.html.twig',
            ['monFormulaire' => $wishForm->createView()]
        );
    }
}
