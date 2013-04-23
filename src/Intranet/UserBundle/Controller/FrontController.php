<?php

namespace Intranet\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Intranet\UserBundle\Entity\User;

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

        if ($request->getMethod() == 'POST')
        {
            $file = $_FILES['file']['tmp_name'];
            $extensions = array('.csv');
            $extension = strrchr($_FILES['file']['name'], '.');

            if (!in_array($extension, $extensions))
            {
                $error = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
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
                            $info = array();
                            $user = $userManager->createUser();
                            for ($c = 0; $c < $num; $c++)
                            {
                                $info[] = $data[$c];
                            }
                            
                            // Hydratation
                            $user->setUsername($info[0]);
                            $user->setFirstName($info[1]);
                            $user->setLastName($info[2]);
                            $user->setEmail($info[3]);
                            $user->setPlainPassword('coucou');
                            $user->setPromo(2014);
                            
                            $userManager->updateUser($user);
                            
                            $users[] = $user;
                        }
                        $row++;
                    }
                    fclose($handle);
                }
            }
            else
            {
                echo $error;
            }
        }

        return array(
            'users' => $users
        );
    }

}