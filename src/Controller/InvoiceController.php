<?php

namespace App\Controller;

use App\Entity\UserCookingTime;
use App\Entity\CookingTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoiceController extends AbstractController
{
    public function invoice(Request $request): Response
    {
// Récupérer l'utilisateur connecté
        $user = $this->getUser();

// Récupérer les informations de l'achat
        $achatId = $request->query->get('user_cooking_time_id');
        $achat = $this->getDoctrine()->getRepository(UserCookingTime::class)->find($achatId);

// Récupérer les informations du produit associé à l'achat
        $produit = $this->getDoctrine()->getRepository(CookingTime::class)->find($achat->getCookingTimeId());

// Générer la facture
        $facture = 'Facture pour l\'achat effectué le ' . $achat->getDate()->format('d/m/Y') . ':';
        $facture .= "\n\n";
        $facture .= 'Client : ' . $user->getUsername() . "\n";
        $facture .= 'Email : ' . $user->getEmail() . "\n";
        $facture .= "\n";
        $facture .= 'Détails de la commande :' . "\n";
        $facture .= 'Produit : ' . $produit->getName() . "\n";
        $facture .= 'Prix : ' . $produit->getPrice() . ' EUR' . "\n";
        $facture .= 'Total : ' . $produit->getPrice() . ' EUR' . "\n";

// Envoyer la facture par e-mail
        $email = (new \Swift_Message('Facture'))
            ->setFrom('noreply@example.com')
            ->setTo($user->getEmail())
            ->setBody($facture);
        $this->get('mailer')->send($email);

// Rediriger l'utilisateur vers la page d'accueil
        return $this->redirectToRoute('home');
    }
}
