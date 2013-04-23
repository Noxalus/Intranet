<?php

namespace Intranet\UserBundle\Util;

use FOS\UserBundle\Model\UserManagerInterface;

class UserManipulator
{
    /**
     * User manager
     *
     * @var UserManagerInterface
     */
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Creates a user and returns it.
     *
     * @param string  $username
     * @param string  $password
     * @param string  $email
     * @param string  $firstName
     * @param string  $lastName
     * @param string  $promo
     * @param Boolean $active
     * @param Boolean $superadmin
     *
     * @return \FOS\UserBundle\Model\UserInterface
     */
    public function create($username, $firstName, $lastName, $password, $email, $promo, $active, $superadmin)
    {
        $user = $this->userManager->createUser();
        $user->setUsername($username);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setPromo($promo);
        $user->setEnabled((Boolean) $active);
        $user->setSuperAdmin((Boolean) $superadmin);
        $this->userManager->updateUser($user);

        return $user;
    }
}
