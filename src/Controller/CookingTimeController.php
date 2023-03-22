<?php

namespace App\Controller;

use App\Entity\CookingTime;
use App\Entity\UserCookingTime;
use App\Form\CookingTimeType;
use App\Repository\CookingTimeRepository;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @Route("/cooking/time")
 */
class CookingTimeController extends AbstractController
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="cooking_time_index", methods={"GET"})
     */
    public function index(CookingTimeRepository $cookingTimeRepository): Response
    {
        return $this->render('cooking_time/index.html.twig', [
            'cooking_times' => $cookingTimeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cooking_time_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cookingTime = new CookingTime();
        $form = $this->createForm(CookingTimeType::class, $cookingTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cookingTime);
            $entityManager->flush();

            return $this->redirectToRoute('cooking_time_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cooking_time/new.html.twig', [
            'cooking_time' => $cookingTime,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cooking_time_show", methods={"GET"})
     */
    public function show(CookingTime $cookingTime): Response
    {
        return $this->render('cooking_time/show.html.twig', [
            'cooking_time' => $cookingTime,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cooking_time_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CookingTime $cookingTime): Response
    {
        $form = $this->createForm(CookingTimeType::class, $cookingTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cooking_time_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cooking_time/edit.html.twig', [
            'cooking_time' => $cookingTime,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cooking_time_delete", methods={"POST"})
     */
    public function delete(Request $request, CookingTime $cookingTime): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cookingTime->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cookingTime);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cooking_time_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/add/{id}", name="add_cooking_time", methods={"POST"})
     */
    public function addCookingTime(Request $request, CookingTime $cookingTime): Response
    {
        $cookingTimeId = $request->get('cookingTimeId');

        // Get the value of the CookingTime entity
        $cookingTimeValue = $cookingTime->getValue();

        // Get the current user
        $user = $this->getUser();

        // Update the remaining_time value of the User entity
        $user->setRemainingTime($user->getRemainingTime() + $cookingTimeValue);

        // Create a new UserCookingTime entity
        $userCookingTime = new UserCookingTime();
        $userCookingTime->setUser($user);
        $userCookingTime->setCookingTime($cookingTime);

        // Set the date with Paris timezone
        $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $userCookingTime->setDate($date);

        // Persist the new UserCookingTime entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($userCookingTime);
        $entityManager->flush();
        $this->addFlash('success', 'Merci pour votre achat !');

        // Rediriger l'utilisateur vers la page d'accueil
        return $this->redirectToRoute('home');
    }
}
