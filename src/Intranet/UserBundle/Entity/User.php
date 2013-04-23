<?php

// src/Intranet/UserBundle/Entity/User.php

namespace Intranet\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="intranet_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $firstName
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
     */
    protected $firstName;

    /**
     * @var string $lastName
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
     */
    protected $lastName;
    
    /**
     * @var Yoopies\CoreBundle\Entity\Photo
     *
     * @ORM\ManyToMany(targetEntity="Photo", cascade={"persist","remove"})
     * @ORM\JoinTable(name="intranet_users_photos_relationship",
     *    joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *    inverseJoinColumns={@ORM\JoinColumn(name="photo_id", referencedColumnName="id", unique=true)}
     *    )
     */
    protected $photos;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="promo", type="integer")
     */
    private $promo;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        
        parent::__construct();
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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName (prénom)
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName (nom)
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Add photos
     *
     * @param \Yoopies\CoreBundle\Entity\Photo $photos
     * @return User
     */
    public function addPhoto(\Yoopies\CoreBundle\Entity\Photo $photos)
    {
        $this->photos[] = $photos;
    
        return $this;
    }

    /**
     * Remove photos
     *
     * @param \Yoopies\CoreBundle\Entity\Photo $photos
     */
    public function removePhoto(\Yoopies\CoreBundle\Entity\Photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set promo
     *
     * @param integer $promo
     * @return User
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;
    
        return $this;
    }

    /**
     * Get promo
     *
     * @return integer 
     */
    public function getPromo()
    {
        return $this->promo;
    }
}