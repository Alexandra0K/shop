<?php

namespace OnlineFashionBundle\Controller;

use OnlineFashionBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use OnlineFashionBundle\Entity\Article;
use OnlineFashionBundle\Entity\Comment;
use OnlineFashionBundle\Entity\User;
use OnlineFashionBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/article/create", name="article_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $file */
            $file = $form->getData()->getImage();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            try {
                $file->move($this->getParameter('articles_directory'), $fileName);
            } catch (FileException $exception) {

            }

            $article->setImage($fileName);
            $currentUser = $this->getUser();

            $article->setAuthor($currentUser);
            $article->setViewCount(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute("blog_index");
        }

        return $this->render('article/create.html.twig',
            ['form' => $form->createView(), 'categories' => $categories]);
    }

    /**
     * @Route("/article/{id}", name="article_view")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewArticle($id)
    {
        /** @var Article $article */
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findAllComments($article);

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($article->getId());

        $article->setViewCount($article->getViewCount() + 1);
        $em = $this->getDoctrine()->getManager();

        $em->persist($article);
        $em->flush();

        return $this->render("article/article.html.twig",
            ['article' => $article, 'comments' => $comments, 'categories' => $categories]);
    }

//    /**
//     * @Route("/article/edit/{id}", name="article_edit")
//     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
//     * @param Request $request
//     * @param $id
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function editAction(Request $request, $id)
//    {
//        $article = $this
//            ->getDoctrine()
//            ->getRepository(Article::class)
//            ->find($id);
//
//        if ($article === null) {
//            return $this->redirectToRoute("blog_index");
//        }
//
//        /** @var User $currentUser */
//        $currentUser = $this->getUser();
//
//        if (!$currentUser->isAuthor($article) && !$currentUser->isAdmin()) {
//            return $this->redirectToRoute("blog_index");
//        }
//
//        $form = $this->createForm(ArticleType::class, $article);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
////            $fs = new Filesystem();
////
////                $fs->remove( $this->getDoctrine()->getRepository($article)->find($id)->getImage());
//
//            /** @var UploadedFile $file */
//            $file = $form->getData()->getImage();
//
//            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
//
//            try {
//                $file->move($this->getParameter('articles_directory'), $fileName);
//            } catch (FileException $exception) {
//
//            }
//
//            $article->setImage($fileName);
//
//            $currentUser = $this->getUser();
//            $article->setAuthor($currentUser);
//            $em = $this->getDoctrine()->getManager();
//            $em->merge($article);
//            $em->flush();
//
//            return $this->redirectToRoute("blog_index");
//        }
//
//        return $this->render('article/edit.html.twig',
//            ['form' => $form->createView(), 'article' => $article]);
//    }
//
//    /**
//     * @Route("/article/delete/{id}", name="article_delete")
//     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
//     * @param Request $request
//     * @param $id
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function deleteAction(Request $request, $id)
//    {
//        $article = $this
//            ->getDoctrine()
//            ->getRepository(Article::class)
//            ->find($id);
//
//        if ($article === null) {
//            return $this->redirectToRoute("blog_index");
//        }
//
//        /** @var User $currentUser */
//        $currentUser = $this->getUser();
//
//        if (!$currentUser->isAuthor($article) && !$currentUser->isAdmin()) {
//            return $this->redirectToRoute("blog_index");
//        }
//
//        $form = $this->createForm(ArticleType::class, $article);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $currentUser = $this->getUser();
//            $article->setAuthor($currentUser);
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($article);
//            $em->flush();
//
//            return $this->redirectToRoute("blog_index");
//        }
//
//        return $this->render('article/delete.html.twig',
//            ['form' => $form->createView(), 'article' => $article]);
//    }

//    /**
//     * @Route("/myArticles", name="myArticles")
//     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
//     */
//    public function myArticles()
//    {
//        $currentUser = $this->getUser()->getId();
//
//        $articles = $this
//            ->getDoctrine()
//            ->getRepository(Article::class)
//            ->findBy(['authorId' => $currentUser]);
//
//        return $this->render("article/myArticles.html.twig", ['articles' => $articles]);
//    }

    /**
     * @Route("/articles/likes/{id}", name="article_likes")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     */
    public function likes()
    {

        return $this->redirectToRoute("blog_index");
    }
}
