<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PanierController extends AbstractController
{

    /**
     * @Route("/panier", name="panier_index")
     * @param SessionInterface $session
     * @param ArticleRepository $repo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SessionInterface $session, ArticleRepository $repo): Response
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantite) {
            $panierWithData[] = [
                'id'=>$id,
                'article' => $repo->find($id),
                'quantite' => $quantite
            ];
        }
        //dd($panierWithData);
        return $this->render('panier/index.html.twig', [
            'items' => $panierWithData
        ]);
    }


    /**
     * @Route("/panier/add/{id}", name="panier_add")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function add($id, SessionInterface $session): RedirectResponse // SessionInterface permet de récupérer la session

    {
        $panier = $session->get('panier', []); // si pas encore de panier dans la session on affecte un panier vide

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier); // on injecte dans la session le panier modifié
        //dd($session->get('panier'));
        return $this->redirectToRoute("article_index");
    }

    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function remove($id, SessionInterface $session): RedirectResponse
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute("panier_index");
    }
}