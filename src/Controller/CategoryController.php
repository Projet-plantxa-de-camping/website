<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CategorySearch;
use App\Form\CategorySearchType;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category_index")
     * @return Response
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('category/index.html.twig', [
            'current_menu' => 'categories',
            'categories' => $categories]);
    }

    /**
     * @Route("/category/new", name="category_new")
     * Method({"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }
        return $this->render('category/new.html.twig', [
            'current_menu' => 'categories',
            'form' => $form->createView()]);
    }

    /**
     * @Route("/category/edit/{id}", name="category_edit", methods={"GET|POST"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('category_index');
        }
        return $this->render('category/edit.html.twig', [
            'current_menu' => 'categories',
            'form' => $form->createView()]);
    }

    /**
     * @Route("/category/delete/{id}",name="category_delete", methods={"DELETE"})
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('category_index');
    }

    /**
     * @Route("/art_cat/", name="article_in_cat", methods={"GET", "POST"})
     */
    public function articleInCategory(Request $request): Response
    {
        $categorySearch = new CategorySearch();
        $form = $this->createForm(CategorySearchType::class, $categorySearch);
        $form->handleRequest($request);
        $articles = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $categorySearch->getCategory();
            if ($category !== "") {
                $articles = $category->getArticles();
            } else {
                $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
            }
        }
        return $this->render('article/articleInCategory.html.twig', [
            'current_menu' => 'categories',
            'form' => $form->createView(),
            'articles' => $articles]);
    }
}