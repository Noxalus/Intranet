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
     * @Template
     */
    public function indexAction()
    {
        $xml=simplexml_load_file("http://webservices.chronos.epita.net/GetWeeks.aspx?num=1&week=-1&group=MTI&auth=a5834TiL"); // Une semaine à partir d'aujourd'hui
        $events = array();
        date_default_timezone_set('Europe/Paris');
        
        for ($i = 0; $i < count($xml->week->day); $i++)
        {
            $d = date_create_from_format('j/m/Y H:i:s', $xml->week->day[$i]->date);
            $date = strtotime($d->format('Y-m-d')) * 1000;
            for ($j = 0; $j < count($xml->week->day[$i]->course); $j++)
            {
                $course['title'] = str_replace('/', '', (string)$xml->week->day[$i]->course[$j]->title);
                $course['start'] = $date + ($xml->week->day[$i]->course[$j]->hour * 15 * 60 * 1000);
                $course['duration'] = $xml->week->day[$i]->course[$j]->duration;
                $course['date'] = str_replace('/', '',(string)$xml->week->day[$i]->date);
                $course['hour'] = $xml->week->day[$i]->course[$j]->hour;
                $course['end'] = $date + (($xml->week->day[$i]->course[$j]->hour + $xml->week->day[$i]->course[$j]->duration) * 15 * 60 * 1000);
                $events[count($events)] = $course;
            }
        }
        
        return array(
            'id' => $xml->week->id,
            'events' => $events
        );
        
    }

    /**
     * @Route("semaine/{id}", name="planningWeek")
     * @Template
     */
    public function weekAction($id)
    {
        $xml = simplexml_load_file('http://webservices.chronos.epita.net/GetWeeks.aspx?num=1&week=' . $id . '&group=MTI&auth=a5834TiL');        
        $events = array();
        date_default_timezone_set('Europe/Paris');
        
        for ($i = 0; $i < count($xml->week->day); $i++)
        {
            $d = date_create_from_format('j/m/Y H:i:s', $xml->week->day[$i]->date);
            $date = strtotime($d->format('Y-m-d')) * 1000;
            for ($j = 0; $j < count($xml->week->day[$i]->course); $j++)
            {
                $course['title'] = str_replace('/', '', (string)$xml->week->day[$i]->course[$j]->title);
                $course['start'] = $date + ($xml->week->day[$i]->course[$j]->hour * 15 * 60 * 1000);
                $course['duration'] = $xml->week->day[$i]->course[$j]->duration;
                $course['date'] = str_replace('/', '',(string)$xml->week->day[$i]->date);
                $course['hour'] = $xml->week->day[$i]->course[$j]->hour;
                $course['end'] = $date + (($xml->week->day[$i]->course[$j]->hour + $xml->week->day[$i]->course[$j]->duration) * 15 * 60 * 1000);
                $events[count($events)] = $course;
            }
        }
        
        
        return array(
            'id' => $xml->week->id,
            'events' => $events,
            'date' => $d
        );
        
    }
    
    /**
     * @Route("/planning/cours/{name}/{date}/{hour}/{duration}", name="course_search")
     * @Template()
     */
    public function searchCourseAction($name, $date, $hour, $duration)
    {
        $d = date_create_from_format('jmY H:i:s', $date);
        $d->modify('+'.($hour * 15 * 60 ).' seconds');
        
        
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetScheduleBundle:CourseType');

        $course = $repository->findOneByName($name);

        if (!$course)
        {
            $course = new CourseType();
            $course->setName($name);
            $course->setDescription('');
            
            $em = $this->getDoctrine()->getManager();
                $em->persist($course);
                $em->flush();      
        }
        
        $sch = $this->getDoctrine()
                ->getManager()
                ->getRepository('IntranetScheduleBundle:Schedule')
                ->findOneBy(array('date' => $d,
                                  'duration' => $duration,
                                  'type' => $course));

        if (!$sch) { // If course doesn't exist : it's created
            $sch = new Schedule();
            $sch->setDate($date);
            $sch->setDuration($duration);
            $sch->setType($course);
            $sch->setisGhost(false);
            $em->persist($sch);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('course_display', array('id' => $sch->getId())));   
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

        $courses = $repository->findBy(array(), array('number' => 'DESC'));
        
        return array(
            'courses' => $courses
        );
    }
    
    /**
     * @Route("/{id}/voir", name="course_display")
     * @Template()
     */
    public function displayCourseAction($id)
    {
 
        $sch = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:Schedule')
                ->find($id);
       
        
        return array(
            'type' => $sch->getType(),
            'sch' => $sch,
            'user' => $this->get('security.context')->getToken()->getUser(),
        );
    }
    
    /**
     * @Route("/matiere/{id}/voir", name="coursetype_display")
     * @Template()
     */
    public function displayCourseTypeAction($id)
    {
 
        $type = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:CourseType')
                ->find($id);
        
        $courses = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:Schedule')
                ->findBy(array('type' => $id, 'isGhost' => 0), array('date' => 'ASC'));
        
        $ghosts = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:Schedule')
                ->findBy(array('type' => $id, 'isGhost' => 1), array('date' => 'ASC'));
        
        return array(
            'type' => $type,
            'courses' => $courses,
            'ghosts' => $ghosts,
            'user' => $this->get('security.context')->getToken()->getUser(),
        );
    }
    
    /**
     * @Route("/cours/{id}/editer", name="edit_course")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function editCourseAction($id)
    {
        $request = $this->get('request');
        $session = $request->getSession();
        
        $sch = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:Schedule')
                ->find($id);

        if ($sch)
        {
            $formBuilder = $this->createFormBuilder($sch);
            $formBuilder
                    ->add('comment', 'ckeditor', array('label' => 'Commentaire'));
            $form = $formBuilder->getForm();
            $request = $this->get('request');

            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);

                if ($form->isValid())
                {                      
                    // On l'enregistre notre objet $article dans la base de données
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($sch);
                    $em->flush();

                    $this->getDoctrine()
                     ->getRepository('IntranetNewsBundle:Article')
                     ->postNotification('Modification d\'un cours', '<p>Les informations du cours de '.$sch->getType()->getName().' du '.$sch->getDate()->format('d/m/Y').' ont été modifiées.</p>');
                
                    
                    $error = 'Commentaire du cours éditée avec succès.';
                    $session->getFlashBag()->add('success', $error);

                    return $this->redirect($this->generateUrl('course_display', array('id'=> $id)));
                }
            }
            return array(
                'form' => $form->createView(),
            );
        }
        else
        {
            $error = 'Il semblerait que cett cours n\'existe pas dans la base de données. L\'édition est donc impossible.';
            $session->getFlashBag()->add('error', $error);   
            return $this->redirect($this->generateUrl('list_course'));
        }
        
    }

    
        /**
     * @Route("/matiere/{id}/editer", name="edit_coursetype")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function editTypeAction($id)
    {
        $request = $this->get('request');
        $session = $request->getSession();
        
        $coursetype = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:CourseType')
                ->find($id);

        if ($coursetype)
        {
            $formBuilder = $this->createFormBuilder($coursetype);
            $formBuilder
                    ->add('description', 'ckeditor');
            $form = $formBuilder->getForm();
            $request = $this->get('request');

            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);

                if ($form->isValid())
                {                      
                    // On l'enregistre notre objet $article dans la base de données
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($coursetype);
                    $em->flush();

                    $error = 'Description de la matière éditée avec succès.';
                    $session->getFlashBag()->add('success', $error);
                    
                                        $this->getDoctrine()
                     ->getRepository('IntranetNewsBundle:Article')
                     ->postNotification('Modification d\'un cours', '<p>Les informations concernant '.$coursetype->getName().' ont été modifiées.</p>');

                    return $this->redirect($this->generateUrl('coursetype_display', array('id'=> $id)));
                }
            }
            return array(
                'form' => $form->createView(),
            );
        }
        else
        {
            $error = 'Il semblerait que cette matière n\'existe pas dans la base de données. L\'édition est donc impossible.';
            $session->getFlashBag()->add('error', $error);   
            return $this->redirect($this->generateUrl('list_course'));
        }
        
    }
}

