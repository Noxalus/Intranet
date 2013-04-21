<?php

namespace Intranet\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class HomeController extends Controller {

    /**
     * @Route("/accueil")
     */
    public function indexAction() 
    {
        //return $this->render('IntranetCoreBundle:Home:index.html.twig');
        return $this->redirect($this->generateUrl('home'));
    }
    
    /**
     * @Route("/deco")
     */
    public function decoAction() 
    {
        return $this->render('IntranetCoreBundle:Home:index.html.twig');
    }
    
    /**
     * @Route("/prof")
     * @Secure(roles="ROLE_TEACHER")
     */
    public function teacherAction() 
    {
        return $this->render('IntranetCoreBundle:Home:teacher.html.twig');
    }
    
    /**
     * @Route("/eleve")
     * @Secure(roles="ROLE_STUDENT")
     */
    public function studentAction() 
    {
        return $this->render('IntranetCoreBundle:Home:student.html.twig');
    }

}
