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
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="\Intranet\WikiBundle\Entity\Article")
     */
    private $articleId;

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
    private $userId;

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
     * Set articleId
     *
     * @param \stdClass $articleId
     * @return Modif
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;

        return $this;
    }

    /**
     * Get articleId
     *
     * @return \stdClass 
     */
    public function getArticleId()
    {
        return $this->articleId;
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
     * Set userId
     *
     * @param \stdClass $userId
     * @return Modif
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \stdClass 
     */
    public function getUserId()
    {
        return $this->userId;
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
}
