<?php

namespace Intranet\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TicketAssignment
 *
 * @ORM\Table(name="intranet_service_ticketassignment")
 * @ORM\Entity(repositoryClass="Intranet\ServiceBundle\Entity\TicketAssignmentRepository")
 */
class TicketAssignment
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
     * @ORM\ManyToOne(targetEntity="Ticket")
     */
    private $ticket;

    /**
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="\Intranet\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isRead", type="boolean")
     */
    private $isRead;

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
     * Set ticket
     *
     * @param \stdClass $ticket
     * @return TicketAssignment
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \stdClass 
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set isRead
     *
     * @param \stdClass $ticket
     * @return TicketAssignment
     */
    public function setisRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead
     *
     * @return \stdClass 
     */
    public function getisRead()
    {
        return $this->isRead;
    }
    
    /**
     * Set user
     *
     * @param \stdClass $user
     * @return TicketAssignment
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass 
     */
    public function getUser()
    {
        return $this->user;
    }
}
