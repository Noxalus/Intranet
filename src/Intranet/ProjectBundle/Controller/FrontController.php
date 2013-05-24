<?php

namespace Intranet\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Intranet\ProjectBundle\Entity\Project;
use Intranet\ProjectBundle\Entity\ProjectGroup;
use Intranet\ProjectBundle\Form\Type\ProjectType;
use Intranet\ProjectBundle\Entity\ProjectSubmission;

class FrontController extends Controller
{

    /**
     * @Route("/projets", name="projects")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('IntranetProjectBundle:Project');

        $projects = $repository->findAll();
        
        return array(
            'projects' => $projects
        );
    }

    /**
     * @Route("/projet/voir/{id}", name="projects_display")
     * @Template()
     */
    public function displayAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('IntranetProjectBundle:ProjectGroup');

        $projectGroup = $repository->findProjectGroup($id, $user->getId());
        
        return array(
            'projectGroup' => $projectGroup
        );
    }

    /**
     * @Route("/projets/ajouter", name="projects_add")
     * @Template()
     */
    public function addAction()
    {
        $project = new Project();
        
        $deadline = new \Intranet\ProjectBundle\Entity\ProjectDeadline();
        $deadline->setDate(new \DateTime());
        $project->addDeadline($deadline);
        /*
        $formBuilder = $this->createFormBuilder($project);

        $formBuilder
                ->add('name', 'text')
                ->add('description', 'textarea');

        $form = $formBuilder->getForm();
        */
        $form = $this->createForm(new ProjectType(), $project);
        
        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($project);
                $em->flush();

                return $this->redirect($this->generateUrl('projects'));
            }
            else
            {
                
            }
        }
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/projets/groupe/ajouter", name="projects_group_add")
     * @Template()
     */
    public function addGroupAction()
    {
        $projectGroup = new ProjectGroup();

        $formBuilder = $this->createFormBuilder($projectGroup);

        $formBuilder
                ->add('group_number', 'integer')
                ->add('users', 'entity', array(
                    'class' => 'IntranetUserBundle:User',
                    'multiple' => true))
                ->add('project', 'entity', array(
                    'class' => 'IntranetProjectBundle:Project'));

        $form = $formBuilder->getForm();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($projectGroup);
                $em->flush();

                return $this->redirect($this->generateUrl('projects'));
            }
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
        
    /**
     * @Route("/projet/{id_project}/editer", name="edit_project")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function editAction($id_project)
    {
        $request = $this->get('request');
        $session = $request->getSession();
        
        $project = $this->getDoctrine()
                ->getRepository('IntranetProjectBundle:Project')
                ->find($id_project);

        if ($project)
        {
            $form = $this->createForm(new ProjectType(), $project);
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);
                if ($form->isValid())
                {                      
                    // On l'enregistre notre objet $project dans la base de données
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($project);
                    $em->flush();

                    $msg = 'Projet édité avec succès.';
                    $session->getFlashBag()->add('success', $msg);

                    return $this->redirect($this->generateUrl('projects'));
                }
            }
            return array(
                'form' => $form->createView(),
            );
        }
        else
        {
            $error = 'Il semblerait que ce projet n\'existe pas dans la base de données. L\'édition est donc impossible.';
            $session->getFlashBag()->add('error', $error);
            return $this->redirect($this->generateUrl('projects'));
        }
    }

    
     /**
     * @Route("/projet/{id_project}/supprimer", name="delete_project")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function deleteAction($id_project)
    {
        $request = $this->get('request');
        $session = $request->getSession();
        
        $project = $this->getDoctrine()
                ->getRepository('IntranetProjectBundle:Project')
                ->find($id_project);

        if ($project)
        {
            $form = $this->createFormBuilder()->getForm();

            $request = $this->getRequest();
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);

                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($project);
                    $em->flush();
               
                    $error = 'Projet supprimé avec succès.';
                    $session->getFlashBag()->add('success', $error);
                    
                    return $this->redirect($this->generateUrl('projects'));
                }
            }

            return array(
                'project' => $project,
                'form'    => $form->createView()
                );
        }
        else
        {
            $error = 'Il semblerait que ce projet n\'existe pas dans la base de données. Il n\'a donc pas pu être supprimé.';
            $session->getFlashBag()->add('error', $error);
        }
        return $this->redirect($this->generateUrl('projects'));
        
    }
}
