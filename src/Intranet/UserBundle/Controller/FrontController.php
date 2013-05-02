<?php

namespace Intranet\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Intranet\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Intranet\UserBundle\Form\UserType;

class FrontController extends Controller
{
    /**
     * @Route("/liste", name="user_list")
     * @Template()
     */
    public function listAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return array(
            'users' => $users
        );
    }

    /**
     * @Route("/trombi", name="user_trombi")
     */
    public function trombiDefaultAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $promo = $user->getPromo();

        return $this->redirect($this->generateUrl('user_trombi_promo', [
                            'promo' => $promo
        ]));
    }

    /**
     * @Route("/trombi/{promo}", name="user_trombi_promo")
     * @Template()
     */
    public function trombiAction($promo)
    {
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('IntranetUserBundle:User');

        $users = $repository->findByPromo($promo);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $promo = $request->request->get('promo');
            return $this->redirect($this->generateUrl('user_trombi_promo', [
                                'promo' => $promo
            ]));
        }

        return array(
            'users' => $users,
            'promo' => $promo
        );
    }

    /**
     * @Route("/profil", name="user_my_profile")
     */
    public function myProfileAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        return $this->redirect($this->generateUrl('user_profile', [
                            'username' => $user->getUsername()
        ]));
    }

    /**
     * @Route("/profil/{username}", name="user_profile")
     * @Template("IntranetUserBundle:Profile:profile.html.twig")
     */
    public function profileAction($username)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);

        if (!$user)
        {
            return new Response('Ceci est une page d\'erreur 404', 404);
        }

        if (!($this->get('security.context')->isGranted('ROLE_TEACHER') || $user == $currentUser))
        {
            return new Response('Ceci est une page d\'erreur 403', 403);
        }

        return array('user' => $user);
    }

    /**
     * @Route("/profil/editer/{user_id}", name="user_profile_edit")
     * @Template("IntranetUserBundle:Profile:edit.html.twig")
     */
    public function profileEditAction($user_id)
    {
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('IntranetUserBundle:User');

        $user = $repository->find($user_id);

        $form = $this->createForm(new UserType, $user);

        $form->setData($user);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                // If we don't do anything on the Photo entity, the image won't be moved
                if (!$user->getPhoto()->getCreatedAt())
                    $user->getPhoto()->setCreatedAt(new \DateTime());
                $user->getPhoto()->setUpdatedAt(new \DateTime());

                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl('user_profile', array('username' => $user->getUsername())));
            }
        }

        return array(
            'form' => $form->createView(),
            'user' => $user
        );
    }

    /**
     * @Route("/ajouter/promo", name="user_add_promo")
     * @Template()
     */
    public function addPromoAction()
    {
        $users = array();

        $request = $this->get('request');

        $session = $request->getSession();
        $session->set('users', null);

        if ($request->getMethod() == 'POST')
        {
            $promo = $request->request->get('promo');
            $file = $_FILES['file']['tmp_name'];
            $extensions = array('.csv');
            $extension = strrchr($_FILES['file']['name'], '.');

            if (!in_array($extension, $extensions))
            {
                $error = 'Vous devez uploader un fichier de type .csv';
            }

            if (!isset($error))
            {
                $row = 1;
                if (($handle = fopen($file, 'r')) !== FALSE)
                {
                    $userManager = $this->container->get('fos_user.user_manager');

                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                    {
                        $num = count($data);
                        if ($row > 1)
                        {
                            $infos = array();
                            $user = $userManager->createUser();
                            for ($c = 0; $c < $num; $c++)
                            {
                                $infos[] = $data[$c];
                            }

                            // Hydratation
                            $user->setUsername($infos[0]);
                            $user->setFirstName($infos[1]);
                            $user->setLastName($infos[2]);
                            $user->setEmail($infos[3]);
                            $user->setPromo($promo);

                            $user->setEnabled(true);

                            $users[] = $user;
                        }
                        $row++;
                    }
                    fclose($handle);

                    $session->set('users', $users);
                }
            }
            else
            {
                $session->getFlashBag()->add('error', $error);
            }
        }

        return array(
            'users' => $users
        );
    }

    /**
     * @Route("/ajouter/promo/selection", name="user_add_promo_selection")
     * @Template()
     */
    public function addPromoSelectionAction()
    {
        $request = $this->get('request');
        $session = $request->getSession();

        $users = $session->get('users');
        $usersSelected = array();

        if ($request->getMethod() == 'POST')
        {
            $parameters = $request->request;
            $userManager = $this->container->get('fos_user.user_manager');

            foreach ($parameters as $key => $value)
            {
                if ($value === 'on')
                {
                    $currentUser = $users[$key - 1];

                    // We check that this user doesn't exist
                    if (!$userManager->findUserByUsername($currentUser->getUsername()))
                    {
                        $password = '';
                        for ($i = 0; $i < 8; $i++)
                            $password .= chr(rand(32, 126));
                        $currentUser->setPlainPassword($password);

                        $currentUser->setPlainPassword('coucou');

                        $currentUser->setRoles(array('ROLE_STUDENT'));

                        // We save this new user into the database
                        $userManager->updateUser($currentUser);

                        $message = \Swift_Message::newInstance()
                                ->setSubject('Bienvenue sur l\'Intranet MTI !')
                                ->setFrom('intranet.mti@epita.fr')
                                ->setTo($currentUser->getEmail())
                                ->setBody($this->get('templating')->render('IntranetUserBundle:Mail:mail.html.twig', array(
                                    'user' => $currentUser,
                                    'password' => $password)), 'text/html')
                        ;
                        $message->setCharset('utf-8');

                        //$this->get('mailer')->send($message);

                        $usersSelected[] = $currentUser;
                    }
                    else
                    {
                        $error = $currentUser->getUsername() . ' existe déjà dans la base de données !';
                        $session->getFlashBag()->add('error', $error);
                    }
                }
            }
        }

        return array('users' => $usersSelected);
    }

}