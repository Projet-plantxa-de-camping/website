<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleSearch;
use App\Entity\PriceSearch;
use App\Form\ArticleType;
use App\Form\ArticleSearchType;
use App\Form\PriceSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article_index")
     * @return Response
     */

    public function index(Request $request): Response
    {
        $propertySearch = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class, $propertySearch);
        $form->handleRequest($request);

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $name = $propertySearch->getName();

            if ($name !== "")  //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
            {
                $articles = $this->getDoctrine()->getRepository(Article::class)->findBy(['name' => $name]);
            } else //si si aucun nom n'est fourni on affiche tous les articles
            {
                $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
            }
        }

        return $this->render('article/index.html.twig', [
            'current_menu' => 'articles',
            'form' => $form->createView(),
            'articles' => $articles]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/article/new", name="article_new", methods="GET|POST")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public
    function new(EntityManagerInterface $entityManager,Request $request)
    {
        $article = new Article();
        /*        $form = $this->createFormBuilder($article)
                    ->add('name', TextType::class)
                    ->add('price', TextType::class)
                    ->add('save', SubmitType::class, array('label' => 'Ajouter un article')
                    )->getForm();*/

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

//            $entityManager = $this->getDoctrine()->getManager(); // on peut supprimer cette ligne si on utilise l'injection de dépendance EntityManagerInterface $entityManager
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', "L'article <strong>{$article->getName()}</strong> a bien été enregistré");

            return $this->redirectToRoute('article_index');
        }
        return $this->render('article/new.html.twig', [
            'current_menu' => 'articles',
            'form' => $form->createView()]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     * @param $id
     * @return Response
     */
    public function show($id): Response
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        return $this->render('article/show.html.twig', [
            'current_menu' => 'articles',
            'article' => $article]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/article/edit/{id}", name="article_edit", methods={"GET|POST"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function edit(EntityManagerInterface $entityManager, Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        /*        $form = $this->createFormBuilder($article)
                    ->add('name', TextType::class)
                    ->add('price', TextType::class)
                    ->add('save', SubmitType::class, array( 'label' => 'Modifier' ))
                    ->getForm();*/

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', "L'article <strong>{$article->getName()}</strong> a bien été modifié");
            return $this->redirectToRoute('article_index');
        }
        return $this->render('article/edit.html.twig', [
            'current_menu' => 'articles',
            'form' => $form->createView()]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/article/delete/{id}",name="article_delete", methods={"DELETE"})
     * @param $id
     * @return RedirectResponse
     */
    public function delete(EntityManagerInterface $entityManager, $id): RedirectResponse
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

//        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
        $this->addFlash('success', "L'article <strong>{$article->getName()}</strong> a bien été supprimé");

        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/art_price", name="article_by_price"), methods={"GET"})
     */
    public function articleByPrice(Request $request)
    {
        $priceSearch = new PriceSearch();
        $form = $this->createForm(PriceSearchType::class, $priceSearch);
        $form->handleRequest($request);
        $articles = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $minPrice = $priceSearch->getMinPrice();
            $maxPrice = $priceSearch->getMaxPrice();
            $articles = $this->getDoctrine()->getRepository(Article::class)->findByPriceRange($minPrice, $maxPrice);
        }
        return $this->render('article/articleByPrice.html.twig', [
            'current_menu' => 'articles',
            'form' => $form->createView(),
            'articles' => $articles]);
    }

}