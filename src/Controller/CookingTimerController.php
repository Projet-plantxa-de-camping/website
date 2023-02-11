<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CookingTimerController extends AbstractController
{
    /**
     * @Route("/timer", name="timer")
     * @return Response
     */

    public function index(): Response
    {
        return $this->render('timer/timer.html.twig', ['current_menu' => 'timer',]);
    }
}