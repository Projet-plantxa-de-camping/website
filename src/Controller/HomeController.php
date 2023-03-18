<?php

namespace App\Controller;

use App\Entity\Plantxa;
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
        // Récupération de l'objet de session
        $session = $this->get('session');

        // Récupération du compteur de visite dans la session
        $visitCount = $session->get('visit_count', 0);

        // Incrémentation du compteur de visite
        $visitCount++;

        // Stockage de la nouvelle valeur du compteur dans la session
        $session->set('visit_count', $visitCount);

        // Récupération du nombre d'utilisateurs enregistrés
        $entityManager = $this->getDoctrine()->getManager();
        $userCount = $entityManager->getRepository(User::class)->count([]);

        // Récupération du nombre de plantxa enregistrés
        $PlantxaCount = $entityManager->getRepository(Plantxa::class)->count([]);

        return $this->render('home/home.html.twig', [
            'userCount' => $userCount,
            'visitCount' => $visitCount,
            'PlantxaCount' => $PlantxaCount,
        ]);
    }


}