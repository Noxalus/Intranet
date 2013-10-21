<?php

namespace Intranet\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TopicView
 *
 * @ORM\Table(name="intranet_forum_topic_view")
 * @ORM\Entity(repositoryClass="Intranet\ForumBundle\Entity\TopicViewRepository")
 */
class TopicView
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\UserBundle\Entity\User")
     *
     */
    private $user;

    /**
     * @var Topic
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\ForumBundle\Entity\Topic")
     */
    private $topic;

    /**
     * @var Topic
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\ForumBundle\Entity\Post")
     */
    private $post;

    /**
     * @var boolean
     *
     * @ORM\Column(name="participated", type="boolean")
     */
    private $participated;


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
     * Set participated
     *
     * @param boolean $participated
     * @return TopicView
     */
    public function setParticipated($participated)
    {
        $this->participated = $participated;

        return $this;
    }

    /**
     * Get participated
     *
     * @return boolean 
     */
    public function getParticipated()
    {
        return $this->participated;
    }

    /**
     * Set user
     *
     * @param \Intranet\UserBundle\Entity\User $user
     * @return TopicView
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

    /**
     * Set topic
     *
     * @param \Intranet\ForumBundle\Entity\Topic $topic
     * @return TopicView
     */
    public function setTopic(\Intranet\ForumBundle\Entity\Topic $topic = null)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return \Intranet\ForumBundle\Entity\Topic 
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set post
     *
     * @param \Intranet\ForumBundle\Entity\Post $post
     * @return TopicView
     */
    public function setPost(\Intranet\ForumBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Intranet\ForumBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
}
