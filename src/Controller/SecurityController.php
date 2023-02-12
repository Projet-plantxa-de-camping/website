<?php

namespace App\Controller;

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
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $userRepository->createUserWithRoleUser($user, $encoder);
                return $this->redirectToRoute('security_login');
            }catch (Exception $e){
                var_dump($e);
            }
        }
        return $this->render('security/registration.html.twig',
            ['form' => $form->createView()]);
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
