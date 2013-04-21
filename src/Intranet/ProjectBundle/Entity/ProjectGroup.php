<?php

namespace Intranet\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * ProjectGroup
 *
 * @ORM\Table(name="project_group")
 * @ORM\Entity(repositoryClass="Intranet\ProjectBundle\Entity\ProjectGroupRepository")
 */
class ProjectGroup
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
     * @var integer
     *
     * @ORM\Column(name="group_number", type="integer")
     */
    private $groupNumber;

    /**
    * @ORM\ManyToMany(targetEntity="Intranet\UserBundle\Entity\User")
    * @ORM\JoinTable(name="project_group_relationship")
    */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="Project")
     */
    private $project;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * Set groupNumber
     *
     * @param integer $groupNumber
     * @return ProjectGroup
     */
    public function setGroupNumber($groupNumber)
    {
        $this->groupNumber = $groupNumber;
    
        return $this;
    }

    /**
     * Get groupNumber
     *
     * @return integer 
     */
    public function getGroupNumber()
    {
        return $this->groupNumber;
    }

    /**
     * Set project
     *
     * @param \stdClass $project
     * @return ProjectGroup
     */
    public function setProject($project)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return \stdClass 
     */
    public function getProject()
    {
        return $this->project;
    }
    
    /**
     * Add users
     *
     * @param \Intranet\UserBundle\Entity\User $users
     * @return ProjectGroup
     */
    public function addUser(\Intranet\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Intranet\UserBundle\Entity\User $users
     */
    public function removeUser(\Intranet\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}