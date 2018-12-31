<?php

namespace OnlineFashionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use OnlineFashionBundle\Entity\Message;
use OnlineFashionBundle\Entity\User;
use OnlineFashionBundle\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends Controller
{  /**
 * @Route("/user/{id}/message/{articleId}", name="user_message")
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 * @param Request $request
 * @param $articleId
 * @param $id
 * @return \Symfony\Component\HttpFoundation\Response
 */
    public function addMessageAction(Request $request, $articleId, $id)
    {
        $currentUser = $this->getUser();

        $recipient = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $message
                ->setSender($currentUser)
                ->setRecipient($recipient)
                ->setIsRead(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash("message", "Message sent successfully!");

            return $this->redirectToRoute("article_view", ['id' => $articleId]);
        }

        return $this->render('user/send_message.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/user/mailbox", name="user_mailbox")
     */
    public function mailboxAction(Request $request){

        $currentUser = $this->getUser()->getId();

        $user = $this->getDoctrine()->getRepository(User::class)->find($currentUser);

       $messages =  $user->getRecipients();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $messages, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('user/mailbox.html.twig', ['pagination' => $pagination]);
    }


    /**
     * @Route("/mailbox/message/{id}", name="user_current_message")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function messageAction($id, Request $request){

        $message = $this->getDoctrine()
            ->getRepository(Message::class)
            ->find($id);
        $message->setIsRead(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        $sentMessage = new Message();
        $form = $this->createForm(MessageType::class, $sentMessage);
        $form->handleRequest($request);

        $currentUser = $this->getUser();

        if($form->isSubmitted()) {
            $sentMessage->setSender($currentUser)
                ->setRecipient($message->getSender())
                ->setIsRead(true);


            $em->persist($sentMessage);
            $em->flush();

            $this->addFlash('message', 'Message sent successfully');
            return $this->redirectToRoute('user_current_message', ['id'=>$id]);
        }

        return $this->render('user/message.html.twig',
            ['message'=>$message, 'form'=>$form->createView()]);
    }
}
