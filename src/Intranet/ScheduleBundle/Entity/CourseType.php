<?php

namespace Intranet\ScheduleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseType
 *
 * @ORM\Table(name="intranet_course_type")
 * @ORM\Entity(repositoryClass="Intranet\ScheduleBundle\Entity\CourseTypeRepository")
 */
class CourseType
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Intranet\UserBundle\Entity\User")
     */
    private $teacher;

    /**
    * @ORM\ManyToMany(targetEntity="Intranet\UserBundle\Entity\User")
    * @ORM\JoinTable(name="intranet_course_student_relationship")
    */
    private $students;

    public function __construct()
    {
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
     * Set name
     *
     * @param string $name
     * @return CourseType
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
     * @return CourseType
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
     * Set teacher
     *
     * @param \stdClass $teacher
     * @return CourseType
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
    
        return $this;
    }

    /**
     * Get teacher
     *
     * @return \stdClass 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set students
     *
     * @param \stdClass $students
     * @return CourseType
     */
    public function setStudents($students)
    {
        $this->students = $students;
    
        return $this;
    }

    /**
     * Get students
     *
     * @return \stdClass 
     */
    public function getStudents()
    {
        return $this->students;
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
