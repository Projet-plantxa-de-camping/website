<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{


    /**
     * @Route("/", name="home")
     * @return Response
     */

    public function index(): Response

    {
        // Récupération du gestionnaire d'entité (EntityManager)
        $entityManager = $this->getDoctrine()->getManager();

        // Récupération du nombre d'utilisateurs enregistrés
        $userCount = $entityManager->getRepository(User::class)->count([]);

        return $this->render('home/home.html.twig', [
            'userCount' => $userCount,
        ]);
    }
}