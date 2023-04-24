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
     * @Route("/admin/statistics/products", name="statistics_products")
     */
    public function statisticsProducts(): Response
    {
        // Récupère le référentiel de l'entité "UserCookingTime"
        $repository = $this->getDoctrine()->getRepository(UserCookingTime::class);

        // Récupère tous les enregistrements de l'entité "UserCookingTime"
        $userCookingTimes = $repository->findAll();

        // Initialise un tableau vide pour stocker le nombre de produits de cuisine
        $productCounts = [];

        // Parcourt tous les enregistrements de l'entité "UserCookingTime"
        foreach ($userCookingTimes as $userCookingTime) {

            // Récupère l'identifiant du temps de cuisson pour chaque enregistrement
            $productId = $userCookingTime->getCookingTime()->getId();

            // Si le nombre de produits de cuisine n'a pas encore été initialisé pour cet identifiant de temps de cuisson, l'initialise à 0
            if (!isset($productCounts[$productId])) {
                $productCounts[$productId] = 0;
            }

            // Incrémente le nombre de produits de cuisine pour cet identifiant de temps de cuisson
            $productCounts[$productId]++;
        }

        // Trie le tableau "$productCounts" par ordre décroissant de valeurs
        arsort($productCounts);

        // Initialise un tableau vide pour stocker les données qui seront renvoyées
        $data = [];

        // Parcourt le tableau "$productCounts"
        foreach ($productCounts as $productId => $count) {

            // Récupère l'entité "CookingTime" correspondante pour chaque identifiant de temps de cuisson
            $cookingTime = $this->getDoctrine()->getRepository(CookingTime::class)->find($productId);

            // Si l'entité "CookingTime" existe, ajoute un tableau contenant le nom du temps de cuisson et le nombre de produits de cuisine dans le tableau "$data"
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

    /**
     * @Route("admin/statistics/", name="statistics")
     */
    public function index(): Response
    {

        return $this->render('statistics/statisticsIndex.html.twig', [

        ]);
    }
}