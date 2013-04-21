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
}