<?php

namespace Intranet\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontController extends Controller
{
    /**
     * @Route("/liste", name="user_list")
     * @Template()
     */
    public function listAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return array(
            'users' => $users
        );
    }

    /**
     * @Route("/trombi", name="user_trombi")
     */
    public function trombiDefaultAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $promo = $user->getPromo();

        return $this->redirect($this->generateUrl('user_trombi_promo', [
                            'promo' => $promo
        ]));
    }

    /**
     * @Route("/trombi/{promo}", name="user_trombi_promo")
     * @Template()
     */
    public function trombiAction($promo)
    {
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('IntranetUserBundle:User');

        $users = $repository->findByPromo($promo);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $promo = $request->request->get('promo');
            return $this->redirect($this->generateUrl('user_trombi_promo', [
                'promo' => $promo
                    ]));
        }

        return array(
            'users' => $users,
            'promo' => $promo
        );
    }

}