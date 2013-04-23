<?php

namespace Intranet\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\UserBundle\Model\User;

/**
 * @author Matthieu Bontemps <matthieu@knplabs.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Luis Cordova <cordoval@gmail.com>
 */
class CreateUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('intranet:user:create')
            ->setDescription('Create a user.')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputArgument('firstName', InputArgument::REQUIRED, 'The first name'),
                new InputArgument('lastName', InputArgument::REQUIRED, 'The last name'),
                new InputArgument('promo', InputArgument::REQUIRED, 'The promotion'),
                new InputOption('super-admin', null, InputOption::VALUE_NONE, 'Set the user as super admin'),
                new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
            ))
            ->setHelp(<<<EOT
The <info>fos:user:create</info> command creates a user:

  <info>php app/console fos:user:create matthieu</info>

This interactive shell will ask you for an email and then a password.

You can alternatively specify the email and password as the second and third arguments:

  <info>php app/console fos:user:create matthieu matthieu@example.com mypassword</info>

You can create a super admin via the super-admin flag:

  <info>php app/console fos:user:create admin --super-admin</info>

You can create an inactive user (will not be able to log in):

  <info>php app/console fos:user:create thibault --inactive</info>

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username   = $input->getArgument('username');
        $email      = $input->getArgument('email');
        $password   = $input->getArgument('password');
        $firstName   = $input->getArgument('firstName');
        $lastName   = $input->getArgument('lastName');
        $promo   = $input->getArgument('promo');
        $inactive   = $input->getOption('inactive');
        $superadmin = $input->getOption('super-admin');

        $manipulator = $this->getContainer()->get('intranet.util.user_manipulator');
        $manipulator->create($username, $firstName, $lastName, $password, $email, $promo, !$inactive, $superadmin);

        $output->writeln(sprintf('Created user <comment>%s</comment>', $username));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('username')) {
            $username = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a username:',
                function($username) {
                    if (empty($username)) {
                        throw new \Exception('Username can not be empty');
                    }

                    return $username;
                }
            );
            $input->setArgument('username', $username);
        }
        
        if (!$input->getArgument('firstName')) {
            $firstName = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a first name:',
                function($firstName) {
                    if (empty($firstName)) {
                        throw new \Exception('First name can not be empty');
                    }

                    return $firstName;
                }
            );
            $input->setArgument('firstName', $firstName);
        }
        
        if (!$input->getArgument('lastName')) {
            $lastName = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a last name:',
                function($lastName) {
                    if (empty($lastName)) {
                        throw new \Exception('Last name can not be empty');
                    }

                    return $lastName;
                }
            );
            $input->setArgument('lastName', $lastName);
        }

        if (!$input->getArgument('email')) {
            $email = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose an email:',
                function($email) {
                    if (empty($email)) {
                        throw new \Exception('Email can not be empty');
                    }

                    return $email;
                }
            );
            $input->setArgument('email', $email);
        }

        if (!$input->getArgument('password')) {
            $password = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a password:',
                function($password) {
                    if (empty($password)) {
                        throw new \Exception('Password can not be empty');
                    }

                    return $password;
                }
            );
            $input->setArgument('password', $password);
        }
        
        if (!$input->getArgument('promo')) {
            $promo = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a promotion:',
                function($promo) {
                    if (empty($promo)) {
                        throw new \Exception('Promotion can not be empty');
                    }

                    return $promo;
                }
            );
            $input->setArgument('promo', $promo);
        }
    }
}
