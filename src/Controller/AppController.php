<?php

namespace App\Controller;


use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/search", name="app.search", methods={"GET"})
     * @param Request $request
     */
    public function search(Request $request) {
        // On récupère l'input de recherche du formulaire
        $searchName = $request->query->get('mot_cle');

        // On recherche un article par son nom
        $articles = $this->getDoctrine()->getRepository(Article::class)->findArticleByName($searchName);

        // Si un article est trouvé
        if ($articles) {

            return $this->render('article/search.html.twig', [
                'articles' => $articles,
            ]);
        }

        // Sinon, on redirige vers l'index
        return $this->redirectToRoute('article_index');
    }

}