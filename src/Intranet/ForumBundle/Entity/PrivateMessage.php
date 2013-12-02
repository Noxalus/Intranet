<?php

namespace Intranet\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PrivateMessage
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PrivateMessage
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
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="user_to", type="object")
     */
    private $userTo;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="user_from", type="object")
     */
    private $userFrom;


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
     * @return PrivateMessage
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
     * Set userTo
     *
     * @param \stdClass $userTo
     * @return PrivateMessage
     */
    public function setUserTo($userTo)
    {
        $this->userTo = $userTo;

        return $this;
    }

    /**
     * Get userTo
     *
     * @return \stdClass 
     */
    public function getUserTo()
    {
        return $this->userTo;
    }

    /**
     * Set userFrom
     *
     * @param \stdClass $userFrom
     * @return PrivateMessage
     */
    public function setUserFrom($userFrom)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    /**
     * Get userFrom
     *
     * @return \stdClass 
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }
}
