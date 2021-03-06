<?php

namespace Intranet\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ProjectSubmission
 *
 * @ORM\Table(name="intranet_project_submission")
 * @ORM\Entity(repositoryClass="Intranet\ProjectBundle\Entity\ProjectSubmissionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ProjectSubmission
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="md5", type="string", length=32)
     */
    private $md5;

    /**
     *
     * @ORM\OneToOne(targetEntity="ProjectDeadline")
     */
    private $deadline;

    /**
     *
     * @ORM\OneToOne(targetEntity="ProjectGroup")
     */
    private $group;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/projets/rendu/';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        
        // s'il y a une erreur lors du déplacement du fichier, une exception
        // va automatiquement être lancée par la méthode move(). Cela va empêcher
        // proprement l'entité d'être persistée dans la base de données si
        // erreur il y a
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
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
     * @return ProjectSubmission
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
     * Set path
     *
     * @param string $path
     * @return ProjectSubmission
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set deadline
     *
     * @param \Intranet\ProjectBundle\Entity\ProjectDeadline $deadline
     * @return ProjectSubmission
     */
    public function setDeadline(\Intranet\ProjectBundle\Entity\ProjectDeadline $deadline = null)
    {
        $this->deadline = $deadline;
    
        return $this;
    }

    /**
     * Get deadline
     *
     * @return \Intranet\ProjectBundle\Entity\ProjectDeadline 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set group
     *
     * @param \Intranet\ProjectBundle\Entity\ProjectGroup $group
     * @return ProjectSubmission
     */
    public function setGroup(\Intranet\ProjectBundle\Entity\ProjectGroup $group = null)
    {
        $this->group = $group;
    
        return $this;
    }

    /**
     * Get group
     *
     * @return \Intranet\ProjectBundle\Entity\ProjectGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set md5
     *
     * @param string $md5
     * @return ProjectSubmission
     */
    public function setMd5($md5)
    {
        $this->md5 = $md5;
    
        return $this;
    }

    /**
     * Get md5
     *
     * @return string 
     */
    public function getMd5()
    {
        return $this->md5;
    }
}