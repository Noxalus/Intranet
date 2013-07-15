<?php

namespace Intranet\ScheduleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;

/**
 * CourseType
 *
 * @ORM\Table(name="intranet_course_type")
 * @ORM\Entity(repositoryClass="Intranet\ScheduleBundle\Entity\CourseTypeRepository")
 */
class CourseType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @ORM\OneToMany(targetEntity="Intranet\NoteBundle\Entity\Exam", orphanRemoval=true, mappedBy="courseType",cascade={"persist","remove"})
     */
    private $exams;
    
    public function __construct()
    {
        $this->exams = new Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CourseType
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return CourseType
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add exams
     *
     * @param \Intranet\NoteBundle\Entity\Exam $exams
     * @return CourseType
     */
    public function addExam(\Intranet\NoteBundle\Entity\Exam $exams)
    {
        $this->exams[] = $exams;
    
        return $this;
    }

    /**
     * Remove exams
     *
     * @param \Intranet\NoteBundle\Entity\Exam $exams
     */
    public function removeExam(\Intranet\NoteBundle\Entity\Exam $exams)
    {
        $this->exams->removeElement($exams);
    }

    /**
     * Get exams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExams()
    {
        return $this->exams;
    }
}
