<?php

namespace Intranet\ScheduleBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Intranet\ScheduleBundle\Entity\Schedule;
use Intranet\ScheduleBundle\Entity\CourseType;
use Intranet\NewsBundle\Entity\Article;

class UpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('schedule:update')
            ->setDescription('Update the database using Chronos informations');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('chronos_logger');
        $logger->info('Beggining update');
        
        $em = $this->getContainer()
                ->get('doctrine')
                ->getEntityManager();
        $typerepo = $em->getRepository('IntranetScheduleBundle:CourseType');
        $schedulerepo = $em->getRepository('IntranetScheduleBundle:Schedule');
        
        
        // Memorize old ghosts
        $typeGhosts = array();
        $ghostsT = $typerepo->findBy(array('number' => 0));
        foreach ($ghostsT as $ghost)
        {
            $typeGhosts[] = $ghost->getId();
        }
        $schedGhosts = array();
        $ghostsS = $schedulerepo->findBy(array('isGhost' => true));
        foreach ($ghostsS as $ghost)
        {
            $schedGhosts[] = $ghost->getId();
        }
        
        // All schedules are now ghosts and coursesTypes don't contains any course
        $schedulerepo->makeAllGhost();
        $typerepo->makeAllGhost();
        
        // Initialize variables
        date_default_timezone_set('Europe/Paris');
        $week = 0;
        $newSched = array();
        $deletedSched = array();
        $newType = array();
        $deletedType = array();
        
        $logger->info('Datas initialized');
        
        while ($week < 52)
        {
            $logger->info('Processing week n°'.$week);
            $xml = simplexml_load_file('http://webservices.chronos.epita.net/GetWeeks.aspx?num=1&week='.$week.'&group=MTI&auth=a5834TiL');
            
            for ($i = 0; $i < count($xml->week->day); $i++)
            {
                for ($j = 0; $j < count($xml->week->day[$i]->course); $j++)
                {
                    // For each course
                    $name = str_replace('/', '', (string)$xml->week->day[$i]->course[$j]->title);
                    $course = $typerepo->findOneByName($name);
        
                    if (!$course) // If coursetype doesn't exist : it's created
                    {
                        $course = new CourseType();
                        $course->setName($name);
                        $course->setDescription('');
                        $course->setNumber(1);
                        $em->persist($course);
                        $em->flush();
                        $logger->info('CourseType created : '.$name);
                        
                        $newType[] = $course;
                    }
                    else
                    {
                         $course->setNumber($course->getNumber() + 1);
                         $em->flush();
                    }
                    
                    $d = date_create_from_format('j/m/Y H:i:s', $xml->week->day[$i]->date);
                    $d->modify('+'.($xml->week->day[$i]->course[$j]->hour * 15 * 60 ).' seconds');
                    $sch = $schedulerepo->findOneBy(array('date' => $d,
                                                        'duration' => $xml->week->day[$i]->course[$j]->duration,
                                                        'type' => $course));
                    
                    if (!$sch) // If course doesn't exist : it's created
                    {
                        $sch = new Schedule();
                        $sch->setDate($d);
                        $sch->setDuration($xml->week->day[$i]->course[$j]->duration);
                        $sch->setType($course);
                        $sch->setisGhost(false);
                        $em->persist($sch);
                        $em->flush();
                        $logger->info('Schedule created : '.$name);
                        $newSched[] = $sch;
                    }
                    else // If it exist : it's not a ghost
                    {
                        $sch->setisGhost(false);
                        $em->flush();
                        $logger->info('Schedule confirmed : '.$name);
                    }
                }
            }
            
            $week++;
        }
        
        // Lists the deleted types and schedules
        $newGhostsT = $typerepo->findBy(array('number' => 0));
        foreach ($newGhostsT as $ghost)
        {
            if (!in_array($ghost->getId(), $typeGhosts))
                $deletedType[] =  $ghost;
        }
        $newGhostsS = $schedulerepo->findBy(array('isGhost' => true));
        foreach ($newGhostsS as $ghost)
        {
            if (!in_array($ghost->getId(), $schedGhosts))
                $deletedSched[] =  $ghost;
        }
        
        // Make an article, id needed
        if (!empty($newSched) || !empty($deletedSched) || !empty($newType) || !empty($deletedType))
        {
            // Make a news Article : Prepare the content
            $content = '';
            
            if(!empty($newSched))
            {
                $content = $content.'<p>Les cours suivants ont été ajoutés :</p><ul>';
                foreach ($newSched as $sch)
                {
                    $content = $content.'<li>Cours de '.$sch->getType()->getName().' du '.$sch->getDate()->format('d/m/Y').' à '.$sch->getDate()->format('H:i').'</li>';
                }
                $content = $content.'</ul>';
            }
            if(!empty($deletedSched))
            {
                if ($content != '')
                    $content = $content.'<br/>';
                $content = $content.'<p>Les cours suivants ont été supprimés :</p><ul>';
                foreach ($deletedSched as $sch)
                {
                    $content = $content.'<li>Cours de '.$sch->getType()->getName().' du '.$sch->getDate()->format('d/m/Y').' à '.$sch->getDate()->format('H:i').'</li>';
                }
                $content = $content.'</ul>';
            }
            
            
            // Posts the article
            $em->getRepository('IntranetNewsBundle:Article')->postNotification(
                 'Mise à jour de l\'emploi du temps', 
                 $content);
            $logger->info('News article has been posted');
        }
        $logger->info('End of update');

    }
}
