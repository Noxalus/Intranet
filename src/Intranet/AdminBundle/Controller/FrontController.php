<?php

namespace Intranet\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class FrontController extends Controller
{
    /**
     * @Route("/", name="intranet_admin")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function indexAction()
    {
        return array();
    }
}
