<?php

namespace App\Controller;

use App\Entity\CookingTime;
use App\Entity\UserCookingTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SatisticsController extends AbstractController
{
    /**
     * @Route("/statistics/products", name="statistics_products")
     */
    public function statisticsProducts(): Response
    {
        $repository = $this->getDoctrine()->getRepository(UserCookingTime::class);
        $userCookingTimes = $repository->findAll();

        $productCounts = [];

        foreach ($userCookingTimes as $userCookingTime) {
            $productId = $userCookingTime->getCookingTime()->getId();

            if (!isset($productCounts[$productId])) {
                $productCounts[$productId] = 0;
            }

            $productCounts[$productId]++;
        }

        arsort($productCounts);

        $data = [];

        foreach ($productCounts as $productId => $count) {
            $cookingTime = $this->getDoctrine()->getRepository(CookingTime::class)->find($productId);

            if ($cookingTime) {
                $data[] = [
                    'name' => $cookingTime->getName(),
                    'count' => $count,
                ];
            }
        }

        return $this->render('statistics/statisticsProducts.html.twig', [
            'data' => $data,
        ]);
    }
}