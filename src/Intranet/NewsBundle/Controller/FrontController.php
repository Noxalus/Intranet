<?php

namespace Intranet\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
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
             
        $news = $repository->findBy(array(), array('date' => 'DESC'), 5, 0);
        
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

                $request = $this->get('request');
                $session = $request->getSession();
                $error = 'Article ajouté avec succès.';
                $session->getFlashBag()->add('success', $error);
                
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
        $request = $this->get('request');
        $session = $request->getSession();
        
        $article = $this->getDoctrine()
                ->getRepository('IntranetNewsBundle:Article')
                ->find($id_article);

        if ($article)
        {
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

                    $error = 'Article édité avec succès.';
                    $session->getFlashBag()->add('success', $error);

                    return $this->redirect($this->generateUrl('home'));
                }
            }
            return array(
                'form' => $form->createView(),
            );
        }
        else
        {
            $error = 'Il semblerait que cet article n\'existe pas dans la base de données. L\'édition est donc impossible.';
            $session->getFlashBag()->add('error', $error);   
            return $this->redirect($this->generateUrl('home'));
        }
        
    }

    
     /**
     * @Route("/news/{id_article}/supprimer", name="delete_news")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function deleteAction($id_article)
    {
        $request = $this->get('request');
        $session = $request->getSession();
        
        $article = $this->getDoctrine()
                ->getRepository('IntranetNewsBundle:Article')
                ->find($id_article);
             
        if ($article)
        {
            $form = $this->createFormBuilder()->getForm();

            $request = $this->getRequest();
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);

                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($article);
                    $em->flush();

                    $error = 'Article supprimé avec succès.';
                    $session->getFlashBag()->add('success', $error);
                    
                    return $this->redirect($this->generateUrl('home'));
                }
            }

            return array(
                'article' => $article,
                'form'    => $form->createView()
                );
        }
        else
        {
            $error = 'Il semblerait que cet article n\'existe pas dans la base de données. Il n\'a donc pas pu être supprimé.';
            $session->getFlashBag()->add('error', $error);
        }
        return $this->redirect($this->generateUrl('home'));
        
    }

}
