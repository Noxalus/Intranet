<?php

namespace Intranet\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Intranet\NewsBundle\Entity\Article;
use Intranet\NewsBundle\Entity\ArticleAttachment;
use Intranet\NewsBundle\Entity\PictoNews;
use Intranet\NewsBundle\Form\Type\PictoNewsType;
use Symfony\Component\HttpFoundation\Response;
use Eko\FeedBundle\Field\MediaItemField;
use Intranet\NewsBundle\Form\Type\ArticleType;
use Intranet\NewsBundle\Form\Type\ArticleAttachmentType;

class FrontController extends Controller
{
    /**
     * @Route("/page/{num_page}", name="home")
     * @Template()
     */
    public function indexAction($num_page = 0)
    {
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetNewsBundle:Article');
             
        $news = $repository->findBy(array(), array('date' => 'DESC'), $num_page * 5 + 5, $num_page * 5);
        $more = false;
        
        if (count($news) == 5)
        {
            $nextnews = $repository->findBy(array(), array('date' => 'DESC'), $num_page * 5 + 6, $num_page * 5 + 5);
            if (count($nextnews) != 0)
                $more = true;
        }
        
        return array(
            'news' => $news,
            'num_page' => $num_page,
            'ismore' => $more
        );
    }
    
    /**
     * @Route("/afficher/{article_id}", name="display_news")
     * @Template()
     */
    public function displayAction($article_id)
    {
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetNewsBundle:Article');
             
        $article = $repository->find($article_id);
        
        if ($article === null)
        {
            
        }
        
        return array(
            'article' => $article
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
        
        $form = $this->createForm(new ArticleType(), $article);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $user = $this->get('security.context')->getToken()->getUser();
                
                $article->setDate(new \DateTime());
                $article->setAuthor($user);
                
                foreach($article->getAttachments() as $attachment)
                {
                    $attachment->setArticle($article);
                }
                
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

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
                    ->add('title', 'text', array('label' => 'Titre'))
                    ->add('picto', 'entity', array(
                    'label' => 'Pictogramme',
                    'class' => 'IntranetNewsBundle:PictoNews',
                    'property' => 'description',
                    'empty_value' => 'Choisissez le pictogramme',
                    'expanded' => false,
                    'multiple' => false,))
                    ->add('content', 'ckeditor', array('label' => 'Contenu'));
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
  
    
    /**
     * @Route("/news/picto/", name="list_picto")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function listPictoAction()
    {
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetNewsBundle:PictoNews');
             
        $pictos = $repository->findBy(array(),array('description' => 'ASC'));
        
        return array(
            'pictos' => $pictos
        );
    }

     /**
     * @Route("/news/picto/ajouter", name="add_picto")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function addPictoAction()
    {
        $picto = new PictoNews();
        $form = $this->createForm(new PictoNewsType, $picto);
        
        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                
                $em->persist($picto);
                $em->flush();

                $session = $request->getSession();
                $error = 'Pictogramme ajouté avec succès.';
                $session->getFlashBag()->add('success', $error);
                
                return $this->redirect($this->generateUrl('list_picto'));
            }
        }
        return array(
            'form' => $form->createView()
        );
    }
      
     /**
     * @Route("/news/picto/{id_picto}/edit", name="edit_picto")
     * @Template()
     * @Secure(roles="ROLE_TEACHER")
     */
    public function editPictoAction($id_picto)
    {
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('IntranetNewsBundle:PictoNews');

        $picto = $repository->find($id_picto);

        $form = $this->createForm(new PictoNewsType, $picto);

        $form->setData($picto);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $em->persist($picto);
                $em->flush();

                $session = $request->getSession();
                $error = 'Pictogramme édité avec succès.';
                $session->getFlashBag()->add('success', $error);
                
                return $this->redirect($this->generateUrl('list_picto'));
            }
        }

        return array(
            'form' => $form->createView(),
            'picto' => $picto
        );
    }
    
    /**
     * Generate the article feed
     * @Route("/rss.xml", name="rss_feed_news")
     * 
     * @return Response XML Feed
     */
    public function feedAction()
    {
        $articles = $this->getDoctrine()->getRepository('IntranetNewsBundle:Article')->findAll();

        $feed = $this->get('eko_feed.feed.manager')->get('article');
        $feed->addFromArray($articles);
        $feed->addItemField(new MediaItemField('getFeedMediaItem'));
        
        return new Response($feed->render('atom')); // or 'atom'
    }
    
    /**
     * Serves an uploaded file.
     *
     * @Route("/news/fichier/{id}/{title}", name="news_file")
     * @Template()
     */
    public function fileAction($id, $title) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IntranetNewsBundle:ArticleAttachment')->find($id);

        $realExtension = pathinfo($entity->getPath(), PATHINFO_EXTENSION);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArticleAttachment entity.');
        }        
        
        $headers = array(
            'Content-Type' => mime_content_type($entity->getAbsolutePath()),
            'Content-Disposition' => 'attachment; filename="' . $entity->getTitle() . '.' + $realExtension . '"'
        );

        $filename = $entity->getAbsolutePath();

        
        return new Response(file_get_contents($filename), 200, $headers);
    }
}
