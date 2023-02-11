<?php

namespace App\Controller;

use App\Entity\CookingTime;
use App\Form\CookingTimeType;
use App\Repository\CookingTimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cooking/time")
 */
class CookingTimeController extends AbstractController
{
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
}
