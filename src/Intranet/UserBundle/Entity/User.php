<?php
// src/Intranet/UserBundle/Entity/User.php
 
namespace Intranet\UserBundle\Entity;
 
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
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
    * @ORM\ManyToMany(targetEntity="Intranet\UserBundle\Entity\Group")
    * @ORM\JoinTable(name="user_group")
    */
   //protected $groups;
   
    public function __construct()
    {
        //$this->groups = new ArrayCollection();
     
        parent::__construct();
    }
}