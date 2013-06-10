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
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text")
     */
    private $details;


    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\ScheduleBundle\Entity\CourseType")
     */
    private $cours;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxnote", type="integer")
     */
    private $maxnote;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="coef", type="decimal")
     */
    private $coef;
    
    /**
     * @Assert\File
     */
    private $file;
    
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
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
     * Set nom
     *
     * @param string $nom
     * @return Exam
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
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
     * Set details
     *
     * @param string $details
     * @return Exam
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set cours
     *
     * @param \stdClass $cours
     * @return Exam
     */
    public function setCours($cours)
    {
        $this->cours = $cours;

        return $this;
    }

    /**
     * Get cours
     *
     * @return \stdClass 
     */
    public function getCours()
    {
        return $this->cours;
    }

    /**
     * Set maxnote
     *
     * @param integer $maxnote
     * @return Exam
     */
    public function setMaxnote($maxnote)
    {
        $this->maxnote = $maxnote;

        return $this;
    }

    /**
     * Get maxnote
     *
     * @return integer 
     */
    public function getMaxnote()
    {
        return $this->maxnote;
    }

    /**
     * Set coef
     *
     * @param decimal $coef
     * @return Exam
     */
    public function setCoef($coef)
    {
        $this->coef = $coef;

        return $this;
    }

    /**
     * Get coef
     *
     * @return integer 
     */
    public function getCoef()
    {
        return $this->coef;
    }
}
