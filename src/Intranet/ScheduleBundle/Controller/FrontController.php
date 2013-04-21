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

        $dateOfWeek = array($currentDate->format("d/m/Y"));

        $interval = new \DateInterval('P1D');
        for ($i = 1; $i < 7; $i++)
        {
            $monday->add($interval);
            $dateOfWeek[] = $monday->format("d/m/Y");
        }

        $schedule = array(
            'Lundi' => array(
                '10h00' => array(
                    'Cours de Math'
                )
            ),
            'Jeudi' => array(
                '14h00' => array(
                    'Cours d\'Algebre'
                )
            )
        );

        return array(
            'schedule' => $schedule,
            'dateOfWeek' => $dateOfWeek,
            'nextWeek' => $nextWeek->format("d-m-Y"),
            'previousWeek' => $previousWeek->format("d-m-Y"),
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
                ->add('comment', 'textarea')
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

