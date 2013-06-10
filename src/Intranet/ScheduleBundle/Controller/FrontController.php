<?php

namespace Intranet\ScheduleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Intranet\ScheduleBundle\Entity\Schedule;
use Intranet\ScheduleBundle\Entity\CourseType;

class FrontController extends Controller
{

    /**
     * @Route("", name="planning")
     */
    public function indexAction()
    {
        $currentDate = explode('-', (new \DateTime())->format('d-m-Y'));

        return $this->redirect($this->generateUrl('planning_date', [
                            'day' => $currentDate[0],
                            'month' => $currentDate[1],
                            'year' => $currentDate[2]
        ]));
    }

    /**
     * @Route("/liste", name="list_course")
     * @Template()
     */
    public function listCourseAction()
    {
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetScheduleBundle:CourseType');
             
        $types = $repository->findBy(array(), array('name' => 'ASC'));
        return array(
            'types' => $types
        );
    }
    
    /**
     * @Route("/{id}/voir", name="coursetype_display")
     * @Template()
     */
    public function displayCourseAction($id)
    {
 
        $type = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:CourseType')
                ->find($id);
        
        return array(
            'type' => $type,
            'user' => $this->get('security.context')->getToken()->getUser(),
        );
    }
    
    /**
     * @Route("{day}-{month}-{year}", name="planning_date")
     * @Template()
     */
    public function scheduleAction($day, $month, $year)
    {
        $currentDate = new \DateTime($year . "-" . $month . "-" . $day);
        $monday = clone $currentDate->modify(('Sunday' == $currentDate->format('l')) ? 'Monday last week' : 'Monday this week');

        $nextWeek = clone $monday;
        $previousWeek = clone $monday;

        $nextWeek->modify('Monday next week');
        $previousWeek->modify('Monday last week');

        $datesOfWeek = array();

        $interval = new \DateInterval('P1D');
        $schedule = array();
        $dayNames = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

        $rowspans = array();
        for ($i = 1; $i <= 7; $i++)
        {
            $courses = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('IntranetScheduleBundle:Schedule')
                    ->findCoursesFromDate($monday);

            foreach ($courses as $course)
            {
                $date_from = clone $course->getDate();
                $date_to = (clone $date_from);
                $date_to->add(new \DateInterval('PT' . $course->getDuration() . 'M'));

                $schedule[$dayNames[$i - 1]][$date_from->format('H\hi')][] = array(
                    'name' => $course->getType()->getName(),
                    'duration' => $course->getDuration() / 30,
                    'end' => $date_to->format('H\hi')
                );

                while ($date_from != $date_to)
                {
                    $rowspans[$dayNames[$i - 1]][$date_from->format('H\hi')] = true;
                    $date_from->add(new \DateInterval('PT30M'));
                }
            }
            
            $datesOfWeek[] = $monday->format("d/m/Y");
            $monday->add($interval);
        }
         
        return array(
            'schedule' => $schedule,
            'datesOfWeek' => $datesOfWeek,
            'nextWeek' => $nextWeek->format("d-m-Y"),
            'previousWeek' => $previousWeek->format("d-m-Y"),
            'rowspans' => $rowspans
        );
    }

    /**
     * @Route("ajouter/cours", name="planning_ajouter_cours")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function addCourseAction()
    {
        $schedule = new Schedule();

        $formBuilder = $this->createFormBuilder($schedule);

        $formBuilder
                ->add('date', 'datetime')
                ->add('duration', 'integer')
                ->add('comment', 'textarea', array('required' => false))
                ->add('type', 'entity', array(
                    'class' => 'IntranetScheduleBundle:CourseType',
                        )
        );

        $form = $formBuilder->getForm();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($schedule);
                $em->flush();

                return $this->redirect($this->generateUrl('planning'));
            }
        }
        
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("ajouter/cours/type", name="planning_ajouter_type_cours")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function addCourseTypeAction()
    {
        $courseType = new CourseType();

        $formBuilder = $this->createFormBuilder($courseType);

        $formBuilder
                ->add('name', 'text')
                ->add('description', 'textarea')
                ->add('teacher', 'entity', array(
                    'class' => 'IntranetUserBundle:User',
                        )
                )
                ->add('students', 'entity', array(
                    'class' => 'IntranetUserBundle:User',
                    'multiple' => true
                        )
        );

        $form = $formBuilder->getForm();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($courseType);
                $em->flush();

                return $this->redirect($this->generateUrl('planning'));
            }
        }
        return array(
            'form' => $form->createView(),
        );
    }

}

