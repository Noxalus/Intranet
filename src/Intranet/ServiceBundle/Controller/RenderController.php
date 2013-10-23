<?php

namespace Intranet\ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RenderController extends Controller
{
    /**
     * @Template()
     */
    public function newMessageAction()
    {
        $assignsNR = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetServiceBundle:TicketAssignment')
                   ->findBy(array('user' => $this->get('security.context')->getToken()->getUser(), 'isRead' => 0));
        $repo = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetServiceBundle:Ticket');
        $messages = array();
        
        foreach ($assignsNR as $assign)
        {
            $messages[\count($messages)] = $repo->find($assign->getTicket()->getId());
        }
        
        return array(
            'messages' => $messages
        );
    }
}

