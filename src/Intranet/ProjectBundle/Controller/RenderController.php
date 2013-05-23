<?php

namespace Intranet\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Intranet\ProjectBundle\Entity\ProjectSubmission;

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
    
    /**
     * @Template()
     */
    public function addSubmissionAction($deadline_id)
    {
        $submission = new ProjectSubmission();
        
        $formBuilder = $this->createFormBuilder($submission);

        $formBuilder->add('file', 'file')
                    ->add('md5', 'text');

        $form = $formBuilder->getForm();

        $request = $this->get('request');
        
        /*
        echo '<pre>';
        print_r($request);
        echo '</pre>';
        */  
        
        if ($request->getMethod() == 'POST')
        {
            echo 'COUCOU';
            exit;
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($submission);
                $em->flush();

                return $this->redirect($this->generateUrl('projects'));
            }
        }
        
        return array(
            'form' => $form->createView()
        );
    }
}

