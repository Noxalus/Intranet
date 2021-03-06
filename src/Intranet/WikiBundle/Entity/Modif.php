<?php

namespace Intranet\WikiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modif
 *
 * @ORM\Table(name="intranet_wiki_modif")
 * @ORM\Entity(repositoryClass="Intranet\WikiBundle\Entity\ModifRepository")
 */
class Modif
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
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\WikiBundle\Entity\Article")
     */
    private $article;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;
    
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
     * @return Modif
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
     * Set content
     *
     * @param string $content
     * @return Modif
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
     * Set content
     *
     * @param string $type
     * @return Modif
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get create
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set article
     *
     * @param \Intranet\WikiBundle\Entity\Article $article
     * @return Modif
     */
    public function setArticle(\Intranet\WikiBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Intranet\WikiBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set user
     *
     * @param \Intranet\UserBundle\Entity\User $user
     * @return Modif
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
