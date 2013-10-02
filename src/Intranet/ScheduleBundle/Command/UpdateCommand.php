<?php

namespace Intranet\ScheduleBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Intranet\ScheduleBundle\Entity\Schedule;
use Intranet\ScheduleBundle\Entity\CourseType;

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
        $em = $this->getContainer()
                ->get('doctrine')
                ->getEntityManager();
        $typerepo = $em->getRepository('IntranetScheduleBundle:CourseType');
        $schedulerepo = $em->getRepository('IntranetScheduleBundle:Schedule');
        
        // All schedules are now ghosts and coursesTypes don't contains any course
        $schedulerepo->makeAllGhost();
        $typerepo->makeAllGhost();
        
        date_default_timezone_set('Europe/Paris');
        $week = 0;
        
        while ($week < 52)
        {
            $output->writeln('Semaine '.$week);
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
                        $output->writeln('Matiere cree : '.$name);
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
                        $output->writeln('Cours de '.$name.' ajoute');
                    }
                    else // If it exist : it's not a ghost
                    {
                        $sch->setisGhost(false);
                        $em->flush();
                        $output->writeln('Cours de '.$name.' confirme');
                    }
                }
            }
            
            $output->writeln('recuperation Semaine '.$week.' OK');
            $week++;
        }
    }
}
