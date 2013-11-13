<?php

namespace Intranet\ScheduleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

