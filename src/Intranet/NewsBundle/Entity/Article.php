<?php

namespace Intranet\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eko\FeedBundle\Item\Writer\RoutedItemInterface;

/**
 * Article
 *
 * @ORM\Table(name="intranet_news_article")
 * @ORM\Entity(repositoryClass="Intranet\NewsBundle\Entity\ArticleRepository")
 */
class Article implements RoutedItemInterface
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

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
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=true)
     */
    private $author;

    /**
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="PictoNews")
     */
    private $picto;
    
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
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Article
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
     * Set date
     *
     * @param \DateTime $date
     * @return Article
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
     * Set author
     *
     * @param \stdClass $author
     * @return Article
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return \stdClass 
     */
    public function getAuthor()
    {
        return $this->author;
    }
    
    /**
     * Set picto
     *
     * @param \stdClass $picto
     * @return Article
     */
    public function setPicto($picto)
    {
        $this->picto = $picto;
    
        return $this;
    }

    /**
     * Get picto
     *
     * @return \stdClass 
     */
    public function getPicto()
    {
        return $this->picto;
    }

    public function getFeedItemDescription() {
        return $this->content;
    }

    public function getFeedItemPubDate() {
        return $this->date;
    }

    public function getFeedItemRouteName() {
        return 'display_news';
    }

    public function getFeedItemRouteParameters() {
        return array('article_id' => $this->id);
    }

    public function getFeedItemTitle() {
        return $this->title;
    }

    public function getFeedItemUrlAnchor() {
        
    }
    
    /**
     * Returns a custom media field
     *
     * @return string
     */
    public function getFeedMediaItem()
    {
        return array(
            'type' => 'image/jpeg',
            'length' => 500,
            'value' => $this->picto->getAbsolutePath()
        );
    }
}