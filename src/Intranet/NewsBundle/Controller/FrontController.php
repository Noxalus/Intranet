<?php

namespace Intranet\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Intranet\NewsBundle\Entity\Article;

class FrontController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetNewsBundle:Article');
        
        $news = $repository->findAll();
        
        return array(
            'news' => $news
        );
    }
    
    /**
     * @Route("/news/ajouter", name="add_news")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function addAction()
    {
        $article = new Article();

        $formBuilder = $this->createFormBuilder($article);

        $formBuilder
                ->add('title', 'text')
                ->add('content', 'textarea');

        $form = $formBuilder->getForm();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $user = $this->get('security.context')->getToken()->getUser();
                
                $article->setDate(new \DateTime());
                $article->setAuthor($user);
                
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl('home'));
            }
        }
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/news/{id_article}/editer", name="edit_news")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function editAction($id_article)
    {
        $article = $this->getDoctrine()
                ->getRepository('IntranetNewsBundle:Article')
                ->find($id_article);

        $formBuilder = $this->createFormBuilder($article);

        $formBuilder
                ->add('title', 'text')
                ->add('content', 'textarea');

        $form = $formBuilder->getForm();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {                      
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl('home'));
            }
        }
        return array(
            'form' => $form->createView(),
        );
    }

    
     /**
     * @Route("/news/{id_article}/supprimer", name="delete_news")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function deleteAction($id_article)
    {
        
        $article = $this->getDoctrine()
                ->getRepository('IntranetNewsBundle:Article')
                ->find($id_article);
        
        $em = $this->getDoctrine()->getManager();
                $em->remove($article);
                $em->flush();
        return $this->redirect($this->generateUrl('home'));
    }

}
