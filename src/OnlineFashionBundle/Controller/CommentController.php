<?php

namespace OnlineFashionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use OnlineFashionBundle\Entity\Article;
use OnlineFashionBundle\Entity\Comment;
use OnlineFashionBundle\Entity\User;
use OnlineFashionBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends Controller
{
    /**
     * @Route("/article/{id}/comment", name="add_comment")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addComment(Request $request, Article $article)
    {

        $user = $this->getUser();
        $author = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($user->getId());

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $comment->setAuthor($author);
        $comment->setArticle($article);

        $em = $this
            ->getDoctrine()
            ->getManager();

        $em->persist($comment);
        $em->flush();


        return $this->redirectToRoute('article_view',
            ['id' => $article->getId()]);
    }
}
