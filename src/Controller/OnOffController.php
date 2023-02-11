<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OnOffController extends AbstractController
{
    /**
     * @Route("/onoff", name="onoff")
     * @return Response
     */

    public function index(): Response
    {
        return $this->render('on-off/on-off.html.twig', ['current_menu' => 'onoff',]);
    }
}