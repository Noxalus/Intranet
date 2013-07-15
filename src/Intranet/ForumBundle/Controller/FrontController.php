<?php

namespace Intranet\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Intranet\ForumBundle\Entity\Category;
use Intranet\ForumBundle\Entity\Topic;
use Intranet\ForumBundle\Entity\Post;
use Intranet\ForumBundle\Form\CategoryType;
use Intranet\ForumBundle\Form\TopicType;
use Intranet\ForumBundle\Form\PostType;

class FrontController extends Controller
{
    /**
     * @Route("/", name="forum_index")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetForumBundle:Category');
             
        $categories = $repository->findAll();
        
        return array(
            'categories' => $categories
        );
    }
    
    /**
     * @Route("/categorie/ajouter", name="forum_add_category")
     * @Template()
     */
    public function addCategoryAction()
    {
        $request = $this->get('request');

        $category = new Category();
        
        $form = $this->createForm(new CategoryType(), $category);

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $category->setCreatedAt(new \DateTime());
                $em->persist($category);
                $em->flush();
                
                return $this->redirect($this->generateUrl('forum_index'));
            }
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/categorie/{id}", name="forum_display_category")
     * @Template()
     */
    public function displayCategoryAction($id)
    {
        $request = $this->get('request');
        $session = $request->getSession();
        
        $category = $this->getDoctrine()
                ->getRepository('IntranetForumBundle:Category')
                ->find($id);
        
        if (!$category)
        {
            $error = 'Il semblerait que cette catégorie n\'existe pas dans la base de données.';
            $session->getFlashBag()->add('error', $error);   
            return $this->redirect($this->generateUrl('forum_index'));
        }
        
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetForumBundle:Topic');
             
        $topics = $repository->findBy(array('category' => $id));
        
        return array(
            'category' => $category,
            'topics' => $topics
        );
    }
    
    /**
     * @Route("/categorie/{category_id}/sujet/ajouter", name="forum_add_topic")
     * @Template()
     */
    public function addTopicAction($category_id)
    {
        $request = $this->get('request');

        $topic = new Topic();
        
        $form = $this->createForm(new TopicType(), $topic);

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $user = $this->get('security.context')->getToken()->getUser();
                $category = $em->find('IntranetForumBundle:Category', $category_id);
                
                $topic->setCategory($category);
                $topic->setAuthor($user);
                
                $em->persist($topic);
                $em->flush();
                
                return $this->redirect($this->generateUrl('forum_display_category', array('id' => $category_id)));
            }
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/sujet/editer/{id}", name="forum_edit_topic")
     * @Template()
     */
    public function editTopicAction($id)
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $topic = $em->find('IntranetForumBundle:Topic', $id);
        
        $form = $this->createForm(new TopicType(), $topic);

        $form->setData($topic);
        
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em->persist($topic);
                $em->flush();
                
                return $this->redirect($this->generateUrl('forum_display_topic', array('id' => $id)));
            }
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/sujet/{id}", name="forum_display_topic")
     * @Template()
     */
    public function displayTopicAction($id)
    {
        $request = $this->get('request');
        $session = $request->getSession();
        
        $topic = $this->getDoctrine()
                ->getRepository('IntranetForumBundle:Topic')
                ->find($id);
        
        if (!$topic)
        {
            $error = 'Il semblerait que ce sujet n\'existe pas dans la base de données.';
            $session->getFlashBag()->add('error', $error);
            
            return $this->redirect($this->generateUrl('forum_index'));
        }
        
        return array(
            'topic' => $topic
        );
    }
    
     /**
     * @Route("/sujet/{topic_id}/ajouter", name="forum_add_post")
     * @Template()
     */
    public function addPostAction($topic_id)
    {
        $request = $this->get('request');

        $post = new Post();
        
        $form = $this->createForm(new PostType(), $post);

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $user = $this->get('security.context')->getToken()->getUser();
                $topic = $em->find('IntranetForumBundle:Topic', $topic_id);
                
                $post->setTopic($topic);
                $post->setAuthor($user);
                
                $em->persist($post);
                $em->flush();
                
                return $this->redirect($this->generateUrl('forum_display_topic', array('id' => $topic->getId())));
            }
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/message/editer/{id}", name="forum_edit_post")
     * @Template()
     */
    public function editPostAction($id)
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $post = $em->find('IntranetForumBundle:Post', $id);
        
        $form = $this->createForm(new PostType(), $post);

        $form->setData($post);
        
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em->persist($post);
                $em->flush();
                
                return $this->redirect($this->generateUrl('forum_display_topic', array('id' => $post->getTopic()->getId())));
            }
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/message/supprimer/{id}", name="forum_delete_post")
     * @Template()
     */
    public function deletePostAction($id)
    {
        $request = $this->get('request');
        $session = $request->getSession();
        
        $post = $this->getDoctrine()
                ->getRepository('IntranetForumBundle:Post')
                ->find($id);
             
        if ($post)
        {
            $form = $this->createFormBuilder()->getForm();

            $request = $this->getRequest();
            if ($request->getMethod() == 'POST')
            {
                $form->bind($request);

                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($post);
                    $em->flush();
               
                    $error = 'Message supprimé avec succès.';
                    $session->getFlashBag()->add('success', $error);
                    
                    return $this->redirect($this->generateUrl('forum_display_topic', array('id' => $post->getTopic()->getId())));
                }
            }

            return array(
                'post' => $post,
                'form'    => $form->createView()
            );
        }
        else
        {
            $error = 'Il semblerait que ce message n\'existe pas dans la base de données. Il n\'a donc pas pu être supprimé.';
            $session->getFlashBag()->add('error', $error);
        }
        
        return $this->redirect($this->generateUrl('home'));
    }
}
