<<<<<<< HEAD
<?php

namespace OnlineFashionBundle\Controller;

use OnlineFashionBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin")
 * Class AdminController
 * @package OnlineFashionBundle\Controller
 *
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="all_users")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        $allUsers = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('admin/index.html.twig',
            ['allUsers' => $allUsers]);
    }

    /**
     * @Route("/user_profile/{id}", name="admin_user_profile")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userProfile($id)
    {
        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        return $this->render('admin/user_profile.html.twig',
            ['user'=>$user]);
    }
}
=======
<?php

namespace OnlineFashionBundle\Controller;

use OnlineFashionBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin")
 * Class AdminController
 * @package OnlineFashionBundle\Controller
 *
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="all_users")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        $allUsers = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('admin/index.html.twig',
            ['allUsers' => $allUsers]);
    }

    /**
     * @Route("/user_profile/{id}", name="admin_user_profile")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userProfile($id)
    {
        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        return $this->render('admin/user_profile.html.twig',
            ['user'=>$user]);
    }
}
>>>>>>> fda21f45e5f6597f4f892dacfe0669d34d72f089
