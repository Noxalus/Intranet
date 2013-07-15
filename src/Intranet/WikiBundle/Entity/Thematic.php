<?php

namespace Intranet\WikiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Thematic
 *
 * @ORM\Table(name="intranet_wiki_thematic")
 * @ORM\Entity(repositoryClass="Intranet\WikiBundle\Entity\ThematicRepository")
 */
class Thematic
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Article", orphanRemoval=true, mappedBy="thematic",cascade={"persist","remove"})
     */
    private $articles;


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
     * @return Thematic
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
     * @return Thematic
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add articles
     *
     * @param \Intranet\WikiBundle\Entity\Article $articles
     * @return Thematic
     */
    public function addArticle(\Intranet\WikiBundle\Entity\Article $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \Intranet\WikiBundle\Entity\Article $articles
     */
    public function removeArticle(\Intranet\WikiBundle\Entity\Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }
    
    public function __toString(){
        return $this->name;
    }
}
