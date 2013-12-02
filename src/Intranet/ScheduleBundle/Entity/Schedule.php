<?php

namespace Intranet\ScheduleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedule
 *
 * @ORM\Table(name="intranet_course_schedule")
 * @ORM\Entity(repositoryClass="Intranet\ScheduleBundle\Entity\ScheduleRepository")
 */
class Schedule
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
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="CourseType")
     */
    private $type;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isGhost", type="boolean")
     */
    private $isGhost;
    
    /**
     * @var ScheduleAttachment
     * 
     * @ORM\OneToMany(targetEntity="ScheduleAttachment", orphanRemoval=true, mappedBy="schedule", cascade={"persist", "remove"})
     */
    private $attachments;

    public function __construct()
    {
        $this->date = new \Datetime;
        $this->comment = null;
        $this->attachments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     * @return Schedule
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
     * Set duration
     *
     * @param integer $duration
     * @return Schedule
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Schedule
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set type
     *
     * @param \stdClass $type
     * @return Schedule
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \stdClass 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set isGhost
     *
     * @param boolean $isGhost
     * @return Schedule
     */
    public function setIsGhost($isGhost)
    {
        $this->isGhost = $isGhost;

        return $this;
    }

    /**
     * Get isGhost
     *
     * @return boolean 
     */
    public function getIsGhost()
    {
        return $this->isGhost;
    }

    /**
     * Add attachments
     *
     * @param \Intranet\ScheduleBundle\Entity\ScheduleAttachment $attachments
     * @return Schedule
     */
    public function addAttachment(\Intranet\ScheduleBundle\Entity\ScheduleAttachment $attachments)
    {
        $this->attachments[] = $attachments;

        return $this;
    }

    /**
     * Remove attachments
     *
     * @param \Intranet\ScheduleBundle\Entity\ScheduleAttachment $attachments
     */
    public function removeAttachment(\Intranet\ScheduleBundle\Entity\ScheduleAttachment $attachments)
    {
        $this->attachments->removeElement($attachments);
    }

    /**
     * Get attachments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttachments()
    {
        return $this->attachments;
    }
}
