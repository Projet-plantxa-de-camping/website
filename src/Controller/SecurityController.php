<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegistrationType;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, UserRepository $userRepository): Response
    {
        // Créer une nouvelle instance de l'utilisateur
        $user = new User();

        // Créer un formulaire à partir de la classe RegistrationType et associer l'utilisateur créé précédemment
        $form = $this->createForm(RegistrationType::class, $user);

        // Gérer la soumission du formulaire et la validation des données entrées
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            // Tenter de créer l'utilisateur avec le rôle "ROLE_USER" dans la base de données
            try {
                $userRepository->createUserWithRoleUser($user, $encoder);
                // Rediriger vers la page de connexion si la création d'utilisateur est réussie
                return $this->redirectToRoute('security_login');
            } catch (Exception $e) {
                // Afficher les erreurs éventuelles
                var_dump($e);
            }
        }

        // Afficher la page d'inscription avec le formulaire créé
        return $this->render('security/registration.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/login",name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // récupère les évantuelles erreur de connexion
        $error = $authenticationUtils->getLastAuthenticationError();
        // dernier nom entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['lastUsername'=>$lastUsername,'error' => $error]);
    }

    /**
     * @Route("/logout",name="security_logout")
     */
    public function logout(): void
    { }


}
