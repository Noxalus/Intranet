<?php

namespace Intranet\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Project
 *
 * @ORM\Table(name="intranet_project")
 * @ORM\Entity(repositoryClass="Intranet\ProjectBundle\Entity\ProjectRepository")
 */
class Project
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
    * @ORM\OneToMany(targetEntity="ProjectDeadline", orphanRemoval=true, mappedBy="project",cascade={"persist","remove"})
    */
    private $deadlines;    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->deadlines = new ArrayCollection();
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
     * @return Project
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
     * @return Project
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
     * Add deadlines
     *
     * @param \Intranet\ProjectBundle\Entity\ProjectDeadline $deadline
     * @return Project
     */
    public function addDeadline(\Intranet\ProjectBundle\Entity\ProjectDeadline $deadline)
    {
        $this->deadlines[] = $deadline;
        $deadline->setProject($this);
    
        return $this;
    }

    /**
     * Remove deadlines
     *
     * @param \Intranet\ProjectBundle\Entity\ProjectDeadline $deadlines
     */
    public function removeDeadline(\Intranet\ProjectBundle\Entity\ProjectDeadline $deadlines)
    {
        $this->deadlines->removeElement($deadlines);
    }

    /**
     * Get deadlines
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDeadlines()
    {
        return $this->deadlines;
    }
}