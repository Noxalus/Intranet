<?php

namespace Intranet\ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Intranet\ServiceBundle\Entity\Ticket;
use Intranet\ServiceBundle\Entity\Message;
use Intranet\ServiceBundle\Entity\TicketAssignment;

class FrontController extends Controller {
    /**
     * @Route("/tickets", name="list_ticket")
     * @Template()
     */
    public function indexAction()
    {
        $assigns = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetServiceBundle:TicketAssignment')
                   ->findBy(array('user' => $this->get('security.context')->getToken()->getUser()));
        $repo = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetServiceBundle:Ticket');
        
        $tickets = array();
                    
        foreach ($assigns as $assign)
        {
            $tickets[\count($tickets)] = $repo->find($assign->getTicket()->getId());
        }
        
        return array(
            'tickets' => $tickets
        );
    }
    
    /**
     * @Route("/new", name="new_ticket")
     * @Template()
     */
    public function newAction()
    {
        $userArray = array();
        $query = $this->getDoctrine()->getManager()
            ->createQuery(
                'SELECT u FROM IntranetUserBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_TEACHER"%');

        $teachers = $query->getResult();

        foreach ($teachers as $teacher) {
            $userArray[$teacher->getId()] = '[Professeur] '.$teacher->getFirstName().' '.$teacher->getLastName();
        }
        
        $groups = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetUserBundle:StudentGroup')
                   ->findAll();
        foreach ($groups as $group)
        {
            $students = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetUserBundle:GroupMember')
                   ->findBy(array('studentGroup' => $group));
            foreach ($students as $student)
            {
                $us = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetUserBundle:User')
                   ->find($student->getUser()->getId());
                $userArray[$us->getId()] = '['.$group->getName().'] '.$us->getFirstName().' '.$us->getLastName();
            }
        }
        
        $formBuilder = $this->createFormBuilder();
        $formBuilder
                ->add('titre', 'text')
                ->add('destinataire', 'choice', array(
                    'choices'   => $userArray,
                    'expanded' => false,
                    'multiple' => false,
                    'empty_value' => 'Choisissez le destinataire'))
                ->add('message', 'ckeditor');

        $form = $formBuilder->getForm();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if ($form->isValid())
            {
                $ticket = new Ticket();
                $msg = new Message();
                $assSender = new TicketAssignment();
                $assReceiv = new TicketAssignment();
                
                $user = $this->get('security.context')->getToken()->getUser();
                $dest = $us = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetUserBundle:User')
                   ->find($request->request->get('form')['destinataire']);
                
                $ticket->setTitle($request->request->get('form')['titre']);
                $ticket->setState('En Cours');
                $msg->setTicket($ticket);
                $msg->setContent($request->request->get('form')['message']);
                $msg->setDate(new \DateTime());
                $msg->setUser($user);
                $assSender->setTicket($ticket);
                $assSender->setUser($user);
                $assReceiv->setTicket($ticket);
                $assReceiv->setUser($dest);
                
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($ticket);
                $em->persist($msg);
                $em->persist($assSender);
                $em->persist($assReceiv);
                $em->flush();

                $session = $request->getSession();
                $error = 'Ticket créé avec succès.';
                $session->getFlashBag()->add('success', $error);
                
                return $this->redirect($this->generateUrl('list_ticket'));
            }
        }
        return array(
            'form' => $form->createView(),
        );
    }
}

?>
