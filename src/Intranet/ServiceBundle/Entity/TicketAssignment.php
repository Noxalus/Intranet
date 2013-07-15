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
