<?php

namespace OnlineFashionBundle\Controller;

use OnlineFashionBundle\Entity\Category;
use OnlineFashionBundle\Entity\Promotion;
use OnlineFashionBundle\Form\PromotionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PromotionController extends Controller
{
    /**
     *
     * @Route("/promo/create", name="promo_create")
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

        $promo = new Promotion();
        $form = $this->createForm(PromotionType::class, $promo);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            if (($promo->getValidFrom() <= new \DateTime('now'))
                && ($promo->getValidTo() >= new \DateTime('now'))
                && ($promo->getArticle()->getCategory() === $promo->getCategory())
            ) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($promo);
                $em->flush();


                return $this->redirectToRoute("blog_index");
            }
        }

        return $this->render('promo/create.html.twig',
            ['form' => $form->createView(), 'categories' => $categories]);
    }

}
