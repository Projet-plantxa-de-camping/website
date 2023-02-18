<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/show", name="show")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', ['current_menu' => 'index']);
    }

    /**
     * @Route("/user", name="user_index")
     */
    public function userIndex(UserRepository $user)
    {
        return $this->render("admin/userIndex.html.twig", [
            'users' => $user->findAll()
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="user_edit")
     */
    public function userEdit(Request $request, User $user, EntityManagerInterface $em)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_user_index');
        }
        return $this->render('admin/userEdit.html.twig', ['formUser' => $form->createView()]);
    }



    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function adminAction()
    {
        // code pour l'administrateur seulement
    }

}