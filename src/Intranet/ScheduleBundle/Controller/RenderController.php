<?php

namespace Intranet\ScheduleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Intranet\ScheduleBundle\Entity\Schedule;
use Intranet\ScheduleBundle\Entity\CourseType;

class RenderController extends Controller
{
    /**
     * @Template()
     */
    public function nextCoursesAction($max)
    {
        $repository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntranetScheduleBundle:Schedule');
        
        $schedules = $repository->findNextCourses(new \DateTime(), $max);
        
        return array(
            'schedules' => $schedules
        );
    }
    
    /**
     * @Template()
     */
    public function ghostManagerAction($ghostcourse)
    {
        $formBuilder = $this->createFormBuilder();

        $courses = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:Schedule')
                ->findBy(array('type' => $ghostcourse->getType()->getId(), 'isGhost' => 0), array('date' => 'ASC'));
        
        $coursesArray = array();
        $coursesArray[0] = 'Supprimer les informations';
        foreach ($courses as $cours) {
            $coursesArray[$cours->getId()] = 'Fusionner avec le cours du '.$cours->getDate()->format('d/m/Y à H').'h'.$cours->getDate()->format('i');
        }
        
        $formBuilder
                ->add('newshed', 'choice', array(
                    'label' => 'Action :',
                    'choices' => $coursesArray))
                ->add('content', 'hidden', array('data' => $ghostcourse->getId()));

        $form = $formBuilder->getForm();
        
        return array(
            'form' => $form->createView()
        );
    }
}

