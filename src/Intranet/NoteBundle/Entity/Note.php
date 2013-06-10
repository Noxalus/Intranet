<?php

namespace Intranet\NoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="intranet_note_note")
 * @ORM\Entity(repositoryClass="Intranet\NoteBundle\Entity\NoteRepository")
 */
class Note
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
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\NoteBundle\Entity\Exam")
     */
    private $exam;
    
    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\UserBundle\Entity\User")
     */
    private $user;

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
     * Set value
     *
     * @param integer $value
     * @return Note
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Note
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
     * Set exam
     *
     * @param \Intranet\NoteBundle\Entity\Exam $exam
     * @return Note
     */
    public function setExam(\Intranet\NoteBundle\Entity\Exam $exam = null)
    {
        $this->exam = $exam;

        return $this;
    }

    /**
     * Get exam
     *
     * @return \Intranet\NoteBundle\Entity\Exam 
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * Set user
     *
     * @param \Intranet\UserBundle\Entity\User $user
     * @return Note
     */
    public function setUser(\Intranet\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Intranet\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
