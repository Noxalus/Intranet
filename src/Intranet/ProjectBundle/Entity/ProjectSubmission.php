<?php

namespace Intranet\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectSubmission
 *
 * @ORM\Table(name="intranet_project_submission")
 * @ORM\Entity(repositoryClass="Intranet\ProjectBundle\Entity\ProjectSubmissionRepository")
 */
class ProjectSubmission
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     *
     * @ORM\OneToOne(targetEntity="ProjectDeadline")
     */
    private $deadline;

    /**
     *
     * @ORM\OneToOne(targetEntity="ProjectGroup")
     */
    private $group;

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
     * Set date
     *
     * @param \DateTime $date
     * @return ProjectSubmission
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
     * Set name
     *
     * @param string $name
     * @return ProjectSubmission
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
     * Set deadline
     *
     * @param \Intranet\ProjectBundle\Entity\ProjectDeadline $deadline
     * @return ProjectSubmission
     */
    public function setDeadline(\Intranet\ProjectBundle\Entity\ProjectDeadline $deadline = null)
    {
        $this->deadline = $deadline;
    
        return $this;
    }

    /**
     * Get deadline
     *
     * @return \Intranet\ProjectBundle\Entity\ProjectDeadline 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set group
     *
     * @param \Intranet\ProjectBundle\Entity\ProjectGroup $group
     * @return ProjectSubmission
     */
    public function setGroup(\Intranet\ProjectBundle\Entity\ProjectGroup $group = null)
    {
        $this->group = $group;
    
        return $this;
    }

    /**
     * Get group
     *
     * @return \Intranet\ProjectBundle\Entity\ProjectGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }
}