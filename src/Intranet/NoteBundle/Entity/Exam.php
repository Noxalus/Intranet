<?php

namespace Intranet\NoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exam
 *
 * @ORM\Table(name="intranet_note_exam")
 * @ORM\Entity(repositoryClass="Intranet\NoteBundle\Entity\ExamRepository")
 */
class Exam
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\ScheduleBundle\Entity\CourseType")
     */
    private $courseType;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_mark", type="integer")
     */
    private $maxMark;
    
    
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
     * @return Exam
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
     * Set date
     *
     * @param \DateTime $date
     * @return Exam
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Exam
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

    /**
     * Set courseType
     *
     * @param \stdClass $courseType
     * @return Exam
     */
    public function setCourseType($courseType)
    {
        $this->courseType = $courseType;

        return $this;
    }

    /**
     * Get courseType
     *
     * @return \stdClass 
     */
    public function getCourseType()
    {
        return $this->courseType;
    }

    /**
     * Set maxMark
     *
     * @param integer $maxMark
     * @return Exam
     */
    public function setMaxnote($maxMark)
    {
        $this->maxMark = $maxMark;

        return $this;
    }

    /**
     * Get maxMark
     *
     * @return integer 
     */
    public function getMaxnote()
    {
        return $this->maxMark;
    }

    /**
     * Set maxMark
     *
     * @param integer $maxMark
     * @return Exam
     */
    public function setMaxMark($maxMark)
    {
        $this->maxMark = $maxMark;
    
        return $this;
    }

    /**
     * Get maxMark
     *
     * @return integer 
     */
    public function getMaxMark()
    {
        return $this->maxMark;
    }
}
