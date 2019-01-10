<?php

namespace OnlineFashionBundle\Controller;

use OnlineFashionBundle\Entity\Article;
use OnlineFashionBundle\Entity\OrderArticle;
use OnlineFashionBundle\Entity\Orderr;
use OnlineFashionBundle\Entity\User;
use OnlineFashionBundle\Form\OrderArticleType;
use OnlineFashionBundle\Form\OrderrType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderrController extends Controller
{
    /**
     *
     * @Route("/orderr/create", name="orderr_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {

        $orderr = new Orderr();
        $form = $this->createForm(OrderrType::class, $orderr);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $currentUser = $this->getUser()->getId();
            $orderr->setAuthorId($currentUser);

            $em = $this->getDoctrine()->getManager();
            $em->persist($orderr);
            $em->flush();

            return $this->redirectToRoute("blog_index");
        }

        return $this->render('orderr/create.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     *
     * @Route("/orderr/addToBasket/{id}", name="orderr_addToBasket")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addToBasket(Request $request, $id)
    {
        /** @var Article $article */
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        /** @var User $user */
        $currentUser = $this->getUser();

        $orderArticle = new OrderArticle();
        $form = $this->createForm(OrderArticleType::class, $orderArticle);
        $form->handleRequest($request);


        $basePrice = $article->getBasePrice();
        $orderArticle->setPrice($basePrice);

        $orderArticle->setAuthor($currentUser);
        $orderArticle->setArticle($article);


//        dump($orderArticle);exit;

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($orderArticle);
            $em->flush();

            return $this->redirectToRoute("myArticles");
        }

        return $this->render('orderr/addToBasket.html.twig',
            ['form' => $form->createView(), 'article' => $article, 'orderArticle' => $orderArticle, 'currentUser' => $currentUser]);
    }

    /**
     * @Route("/article/edit/{id}", name="article_edit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $orderArticle = $this
            ->getDoctrine()
            ->getRepository(OrderArticle::class)
            ->find($id);

        if ($orderArticle === null) {
            return $this->redirectToRoute("blog_index");
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if (!$currentUser->isAuthorOA($orderArticle) && !$currentUser->isAdmin()) {
            return $this->redirectToRoute("blog_index");
        }

        $form = $this->createForm(OrderArticleType::class, $orderArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            $fs = new Filesystem();
//
//                $fs->remove( $this->getDoctrine()->getRepository($article)->find($id)->getImage());

            /** @var UploadedFile $file */
            $file = $form->getData()->getImage();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            try {
                $file->move($this->getParameter('articles_directory'), $fileName);
            } catch (FileException $exception) {

            }

            $orderArticle->setImage($fileName);

            $currentUser = $this->getUser();
            $orderArticle->setAuthor($currentUser);
            $em = $this->getDoctrine()->getManager();
            $em->merge($orderArticle);
            $em->flush();

            return $this->redirectToRoute("blog_index");
        }

        return $this->render('article/edit.html.twig',
            ['form' => $form->createView(), 'orderArticle' => $orderArticle]);
    }

    /**
     * @Route("/article/delete/{id}", name="article_delete")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, $id)
    {
        $orderArticle = $this
            ->getDoctrine()
            ->getRepository(OrderArticle::class)
            ->find($id);

        if ($orderArticle === null) {
            return $this->redirectToRoute("blog_index");
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if (!$currentUser->isAuthorOA($orderArticle) && !$currentUser->isAdmin()) {
            return $this->redirectToRoute("blog_index");
        }

        $form = $this->createForm(OrderArticleType::class, $orderArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->getUser();
            $orderArticle->setAuthor($currentUser);
            $em = $this->getDoctrine()->getManager();
            $em->remove($orderArticle);
            $em->flush();

            return $this->redirectToRoute("blog_index");
        }

        return $this->render('article/delete.html.twig',
            ['form' => $form->createView(), 'orderArticle' => $orderArticle]);
    }

    /**
     * @Route("/myArticles", name="myArticles")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function myArticles()
    {
        $currentUser = $this->getUser()->getId();
        $articles = $this
            ->getDoctrine()
            ->getRepository(OrderArticle::class)
            ->findBy(['authorId' => $currentUser]);

        return $this->render("article/myArticles.html.twig", ['orderArticles' => $articles]);
    }

}
