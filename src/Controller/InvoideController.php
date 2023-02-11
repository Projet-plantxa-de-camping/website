<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoideController extends AbstractController
{
    /**
     * @Route("/invoide", name="invoide")
     * @return Response
     */

    public function index(): Response
    {
        return $this->render('invoide/invoide.html.twig', ['current_menu' => 'invoide',]);
    }
}