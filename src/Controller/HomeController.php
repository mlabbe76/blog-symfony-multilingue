<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo = $repo->findAll();


        return $this->render("home/index.html.twig",[
        // Methode render premettant de retourner la vue disponible grace à l'héritage d'Abstractcontroller
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $article = $repo = $repo->find($id);

        if(!$article){
           return $this->redirectToRoute('home');
        }


        return $this->render("show/index.html.twig",[
        // Methode render premettant de retourner la vue disponible grace à l'héritage d'Abstractcontroller
            'article' => $article,
        ]);
    }

    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     */
    public function changeLocale($locale, Request $request)
    {
        //On stocke la langue demandée dans la session
        $request->getSession()->set('_locale', $locale);

        //On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }
}
