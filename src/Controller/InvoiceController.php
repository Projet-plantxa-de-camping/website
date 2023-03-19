<?php

namespace App\Controller;

use App\Entity\UserCookingTime;
use App\Entity\CookingTime;
use App\Repository\CookingTimeRepository;
use App\Repository\UserCookingTimeRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/invoice")
 */
class InvoiceController extends AbstractController
{
    /**
     * @Route("/invoice/{user_cooking_time_id}", name="invoice")
     */
    public function invoice(Request $request, int $user_cooking_time_id): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        $isAdmin = in_array("ROLE_ADMIN", $user->getRoles());

        // Récupérer les informations de l'achat
        $achat = $this->getDoctrine()->getRepository(UserCookingTime::class)->find($user_cooking_time_id);

        // Vérifier si l'achat appartient à l'utilisateur connecté
        if (!$isAdmin && (!$achat || $achat->getUser() !== $user)) {
            throw $this->createNotFoundException('Achat non trouvé');
        }

        // Récupérer les informations du produit associé à l'achat
        $produit = $achat->getCookingTime();

        // Récupérer l'utilisateur qui a effectué l'achat
        $user_achat = $achat->getUser();

        return $this->render('invoice/invoice.html.twig', [
            'achat' => $achat,
            'user_achat' => $user_achat,
            'produit' => $produit,
        ]);

    }

    /**
     * @Route("/", name="user_cooking_time_index", methods={"GET"})
     */
    public function index(UserCookingTimeRepository $userCookingTimeRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les factures de l'utilisateur connecté
        $cookingTimes = $userCookingTimeRepository->findBy(['user' => $user]);

        return $this->render('invoice/index.html.twig', [
            'user_cooking_times' => $cookingTimes,
        ]);

    }

    /**
     * @Route("/admin", name="user_cooking_time_index_admin", methods={"GET"})
     */
    public function indexAdmin(Request $request, UserCookingTimeRepository $userCookingTimeRepository, UserRepository $userRepository): Response
    {
        // Vérifier si l'email a été soumis dans le formulaire
        $email = $request->query->get('email');

        if ($email) {
            // Récupérer l'utilisateur correspondant à l'email
            $user = $userRepository->findOneBy(['email' => $email]);

            // Récupérer les factures de l'utilisateur
            $cookingTimes = $userCookingTimeRepository->findBy(['user' => $user]);
        } else {
            // Récupérer toutes les factures
            $cookingTimes = $userCookingTimeRepository->findAll();
        }

        return $this->render('invoice/admin_index.html.twig', [
            'user_cooking_times' => $cookingTimes,
            'email' => $email,
        ]);
    }





}
