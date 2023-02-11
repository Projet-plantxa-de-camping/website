<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController

{
    /**
     * @Route("/shopt", name="shop")
     * @return Response
     */

    public function index(): Response
    {
        return $this->render('shop/shop.html.twig', ['current_menu' => 'shop',]);
    }

}
