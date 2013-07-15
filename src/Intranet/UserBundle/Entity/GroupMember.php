<?php

namespace Intranet\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupMember
 *
 * @ORM\Table(name="intranet_user_groupmember")
 * @ORM\Entity(repositoryClass="Intranet\UserBundle\Entity\GroupMemberRepository")
 */
class GroupMember
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
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="StudentGroup")
     */
    private $studentGroup;


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
     * Set user
     *
     * @param \stdClass $user
     * @return GroupMember
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set studentGroup
     *
     * @param \stdClass $studentGroup
     * @return GroupMember
     */
    public function setStudentGroup($studentGroup)
    {
        $this->studentGroup = $studentGroup;

        return $this;
    }

    /**
     * Get studentGroup
     *
     * @return \stdClass 
     */
    public function getStudentGroup()
    {
        return $this->studentGroup;
    }
}
