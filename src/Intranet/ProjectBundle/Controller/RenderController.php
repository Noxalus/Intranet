<?php

namespace Intranet\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class RenderController extends Controller
{
    /**
     * @Template()
     */
    public function nextDeadlinesAction($max)
    {
        $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntranetProjectBundle:Project');
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $deadlines = $repository->findNextDeadlines($user->getId(), $max);
        
        return array(
            'deadlines' => $deadlines
        );
    }
}

