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
}

