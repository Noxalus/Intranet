<?php

namespace Intranet\ScheduleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class FrontController extends Controller {
    
    /**
     * @Route("", name="planning")
     */
    public function indexAction() 
    {
        // Pour récupérer le service UserManager du bundle
        $userManager = $this->get('fos_user.user_manager');

        // Pour charger un utilisateur
        $user = $userManager->findUserBy(array('username' => 'Prof'));

        // Pour modifier un utilisateur
        /*
        var_dump($user->getRoles());
        $user->setRoles(array('ROLE_TEACHER'));
        $userManager->refreshUser($user);
        var_dump($user->getRoles());
        exit;
        */
        
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
        $monday = clone $currentDate->modify('Monday this week');

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

        return array(
            'dateOfWeek' => $dateOfWeek,
            'nextWeek' => $nextWeek->format("d-m-Y"),
            'previousWeek' => $previousWeek->format("d-m-Y"),
        );
    }
    
    /**
     * @Route("ajouter", name="planning_ajouter")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function addAction()
    {
        return array();
    }
}
