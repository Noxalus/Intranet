<?php

namespace Intranet\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Post
 *
 * @ORM\Table(name="intranet_forum_post")
 * @ORM\Entity(repositoryClass="Intranet\ForumBundle\Entity\PostRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Post
{
    use ORMBehaviors\Timestampable\Timestampable;
    
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\UserBundle\Entity\User")
     */
    private $author;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Topic", inversedBy="posts")
     */
    private $topic;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\UserBundle\Entity\User")
     */
    private $editBy;

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
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set topic
     *
     * @param \stdClass $topic
     * @return Post
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return \stdClass 
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set author
     *
     * @param \Intranet\UserBundle\Entity\User $author
     * @return Post
     */
    public function setAuthor(\Intranet\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Intranet\UserBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }
    
    /**
     * Set editBy
     *
     * @param \Intranet\UserBundle\Entity\User $editBy
     * @return Post
     */
    public function setEditBy(\Intranet\UserBundle\Entity\User $editBy = null)
    {
        $this->editBy = $editBy;

        return $this;
    }

    /**
     * Get editBy
     *
     * @return \Intranet\UserBundle\Entity\User 
     */
    public function getEditBy()
    {
        return $this->editBy;
    }
}
