<?php

namespace Intranet\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
	/**
     * @Route("/test")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('IntranetCoreBundle:Home:index.html.twig');
    }
}
