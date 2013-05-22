<?php

namespace Intranet\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
}
