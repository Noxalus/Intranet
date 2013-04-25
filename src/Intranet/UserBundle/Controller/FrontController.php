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
     * @Route("/profil/editer", name="user_profile_edit")
     * @Template()
     */
    public function profileditAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        if ('POST' === $request->getMethod())
        {
            $form->bind($request);

            if ($form->isValid())
            {
                /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
                $userManager = $this->container->get('fos_user.user_manager');

                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse())
                {
                    $url = $this->container->get('router')->generate('fos_user_profile_show');
                    $response = new RedirectResponse($url);
                }

                return $response;
            }
        }

        return $this->container->get('templating')->renderResponse(
                        'FOSUserBundle:Profile:edit.html.' . $this->container->getParameter('fos_user.template.engine'), array('form' => $form->createView())
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

                        $this->get('mailer')->send($message);

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