<?php

namespace App\Controller;

use App\Entity\UserCookingTime;
use App\Entity\CookingTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/invoice/{user_cooking_time_id}", name="invoice")
 */
class InvoiceController extends AbstractController
{
    public function invoice(Request $request, int $user_cooking_time_id): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer les informations de l'achat
        $achat = $this->getDoctrine()->getRepository(UserCookingTime::class)->find($user_cooking_time_id);

        // Vérifier si l'achat appartient à l'utilisateur connecté
        if (!$achat || $achat->getUser() !== $user) {
            throw $this->createNotFoundException('Achat non trouvé');
        }

        // Récupérer les informations du produit associé à l'achat
        $produit = $achat->getCookingTime();

        return $this->render('invoice/invoice.html.twig', [

            'achat' => $achat,
            'user' => $user,
            'produit' => $produit,
        ]);
    }

}
