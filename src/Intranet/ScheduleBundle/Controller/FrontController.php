<?php

namespace Intranet\ScheduleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Intranet\ScheduleBundle\Entity\Schedule;
use Intranet\ScheduleBundle\Entity\CourseType;
use Intranet\ScheduleBundle\Form\Type\ScheduleType;
use Symfony\Component\HttpFoundation\Response;

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

        $em = $this->getDoctrine()->getManager();
        
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
            $sch->setDate($d);
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
        
        $formArray = array();
        $formArray[0] = 'Supprimer les informations';
        foreach ($courses as $cours) {
            $formArray[$cours->getId()] = 'Fusionner avec le cours du '.$cours->getDate()->format('d/m/Y à H').'h'.$cours->getDate()->format('i');
        }
                    
        $ghosts = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:Schedule')
                ->findBy(array('type' => $id, 'isGhost' => 1), array('date' => 'ASC'));
                    
        $g = array();
        foreach ($ghosts as $ghost) {
            $pair = array();
            $pair['ghost'] = $ghost;
            
            $formBuilder = $this->createFormBuilder()
                                ->add('newshed', 'choice', array(
                                    'label' => 'Action :',
                                    'choices' => $formArray))
                ->add('value', 'hidden', array('data' => $ghost->getId()));
                    
            $pair['form'] = $formBuilder->getForm()->createView();
            $g[] = $pair;
        }
        
        
        $request = $this->get('request');
        $session = $request->getSession();

            if ($request->getMethod() == 'POST')
            {
                $form = $this->createFormBuilder()
                             ->add('newshed', 'choice', array(
                                    'label' => 'Action :',
                                    'choices' => $formArray))
                             ->add('value', 'hidden', array('data' => 0))
                             ->getForm();
                $form->bind($request);

                if ($form->isValid())
                {
                    $coursesrepo = $this->getDoctrine()
                                ->getRepository('IntranetScheduleBundle:Schedule');
                            
                    
                    $old = $coursesrepo->find($form->get('value')->getData());
                    $new = $coursesrepo->find($form->get('newshed')->getData());
                    
                    if ($new->getComment() != null || $new->getComment() != '')
                        $new->setComment($new->getComment().'<br/>'.$old->getComment());
                    else
                        $new->setComment($old->getComment());
                    
                    // TODO : Gestion des PJ quand elles seront faites.
                    
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($new);
                    $em->remove($old);
                    $em->flush();

                    $this->getDoctrine()
                     ->getRepository('IntranetNewsBundle:Article')
                     ->postNotification('Modification d\'un cours', '<p>Les informations du cours de '.$new->getType()->getName().' du '.$new->getDate()->format('d/m/Y').' ont été modifiées.</p>');
                
                    
                    $error = 'Modifications effectuées';
                    $session->getFlashBag()->add('success', $error);

                    return $this->redirect($this->generateUrl('coursetype_display', array('id'=> $id)));
                }
            }
        
        
        return array(
            'type' => $type,
            'courses' => $courses,
            'ghosts' => $g,
            'user' => $this->get('security.context')->getToken()->getUser(),
        );
    }
    
    /**
     * @Route("/fantomes", name="ghost_display")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function displayGhostAction()
    {
        $types = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:CourseType')
                ->findAll();
        
        $typeR = array();
        foreach ($types as $type)
        {
            $info = array();
            $info['type'] = $type;
            $info['ghosts'] = array();
                
            $courses = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:Schedule')
                ->findBy(array('type' => $type->getId(), 'isGhost' => 0), array('date' => 'ASC'));
                    
            $formArray = array();
            $formArray[0] = 'Supprimer les informations';
            foreach ($courses as $cours) {
                $formArray[$cours->getId()] = 'Fusionner avec le cours du '.$cours->getDate()->format('d/m/Y à H').'h'.$cours->getDate()->format('i');
            }

            $ghosts = $this->getDoctrine()
                    ->getRepository('IntranetScheduleBundle:Schedule')
                    ->findBy(array('type' => $type->getId(), 'isGhost' => 1), array('date' => 'ASC'));

            
            foreach ($ghosts as $ghost) {
                $pair = array();
                $pair['ghost'] = $ghost;

                $formBuilder = $this->createFormBuilder()
                                    ->add('newshed', 'choice', array(
                                        'label' => 'Action :',
                                        'choices' => $formArray))
                    ->add('value', 'hidden', array('data' => $ghost->getId()));

                $pair['form'] = $formBuilder->getForm()->createView();
                $info['ghosts'][] = $pair;
            }
            $typeR[] = $info;
        }
        
        $request = $this->get('request');
        $session = $request->getSession();

        if ($request->getMethod() == 'POST')
        {
            $form = $this->createFormBuilder()
                         ->add('newshed', 'choice', array(
                               'label' => 'Action :',
                               'choices' => $formArray))
                         ->add('value', 'hidden', array('data' => 0))
                         ->getForm();
            $form->bind($request);

            if ($form->isValid())
            {
                $coursesrepo = $this->getDoctrine()
                                    ->getRepository('IntranetScheduleBundle:Schedule');
                                
                $old = $coursesrepo->find($form->get('value')->getData());
                $new = $coursesrepo->find($form->get('newshed')->getData());
                    
                if ($new->getComment() != null || $new->getComment() != '')
                    $new->setComment($new->getComment().'<br/>'.$old->getComment());
                else
                    $new->setComment($old->getComment());
                    
                // TODO : Gestion des PJ quand elles seront faites.
                    
                $em = $this->getDoctrine()->getManager();
                $em->persist($new);
                $em->remove($old);
                $em->flush();

                $this->getDoctrine()
                     ->getRepository('IntranetNewsBundle:Article')
                     ->postNotification('Modification d\'un cours', '<p>Les informations du cours de '.$new->getType()->getName().' du '.$new->getDate()->format('d/m/Y').' ont été modifiées.</p>');
                
                    
                $error = 'Modifications effectuées';
                $session->getFlashBag()->add('success', $error);

                return $this->redirect($this->generateUrl('ghost_display', array('id'=> $id)));
            }
        }
        
        
        return array(
            'typeR' => $typeR,
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
            $form = $this->createForm(new ScheduleType(), $sch);
            
            $request = $this->get('request');

            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);

                if ($form->isValid())
                {                      
                    foreach($sch->getAttachments() as $attachment)
                    {
                        $attachment->setSchedule($sch);
                    }
                    
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
    
    /**
     * Serves an uploaded file.
     *
     * @Route("/cours/fichier/{id}/{title}", name="course_file")
     * @Template()
     */
    public function fileAction($id, $title) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IntranetScheduleBundle:ScheduleAttachment')->find($id);

        $realExtension = pathinfo($entity->getPath(), PATHINFO_EXTENSION);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ScheduleAttachment entity.');
        }        
        
        $headers = array(
            'Content-Type' => mime_content_type($entity->getAbsolutePath()),
            'Content-Disposition' => 'attachment; filename="' . $entity->getTitle() . '.' + $realExtension . '"'
        );

        $filename = $entity->getAbsolutePath();
        
        return new Response(file_get_contents($filename), 200, $headers);
    }
}

