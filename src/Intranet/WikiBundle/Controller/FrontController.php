<?php

namespace Intranet\WikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Intranet\WikiBundle\Entity\Article;
use Intranet\WikiBundle\Entity\Modif;
use Intranet\WikiBundle\Entity\Thematic;
use Intranet\WikiBundle\Form\Type\ModifType;

class FrontController extends Controller
{
    /**
     * @Route("/liste", name="index_wiki")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetWikiBundle:Thematic');
             
        $thematics = $repository->findAll();
        
        return array(
            'thematics' => $thematics
        );
    }
    
    /**
     * @Route("/ajouter", name="wiki_add_article")
     * @Template()
     */
    public function addAction()
    {

        $modif = new Modif();
        
        $form = $this->createForm(new ModifType(), $modif);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $user = $this->get('security.context')->getToken()->getUser();
                
                $modif->setUser($user);
                $modif->setType(1);
                $modif->getArticle()->setActive(true);
                $modif->setDate(new \DateTime());
                
                $em->persist($modif->getArticle());
                $em->persist($modif);
                $em->flush();
                
                
                $em->persist($modif);
                $em->flush();
                

                return $this->redirect($this->generateUrl('index_wiki'));
            }
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/article/{id_article}/edit", name="wiki_edit")
     * @Template()
     */
    public function editAction($id_article)
    {
       
        $article = $this->getDoctrine()
                ->getRepository('IntranetWikiBundle:Article')
                ->find($id_article);
        
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetWikiBundle:Modif');
             
       
        
        $modif = $repository->findBy(array('article' => $article->getId()), array('date' => 'DESC'));
        
        if (!$article || count($modif) == 0)
        {
            $error = 'Il semblerait que cet article n\'existe pas dans la base de données.';
            $session->getFlashBag()->add('error', $error);   
            return $this->redirect($this->generateUrl('index_wiki'));
        }

        $formBuilder = $this->createFormBuilder();

        $formBuilder
                ->add('Nom', 'text', array('data' => $article->getName()))
                ->add('Contenu', 'ckeditor', array('data' => $modif[0]->getContent()));
        
        $form = $formBuilder->getForm();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $newModif = new Modif();
                
                $user = $this->get('security.context')->getToken()->getUser();
                
                $article->setName($_POST['form']['Nom']);
                $newModif->setContent($_POST['form']['Contenu']);
                $newModif->setDate(new \DateTime());
                $newModif->setUserId($user);
                $newModif->setArticle($article);
                $newModif->setType(0);
                
                
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->persist($newModif);
                $em->flush();

                $session = $request->getSession();
                $error = 'Article modifié avec succès.';
                $session->getFlashBag()->add('success', $error);
                
                return $this->redirect($this->generateUrl('wiki_display', array('id_article' => $article->getId())));
            }
        }
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/article/{id_article}/voir", name="wiki_display_article")
     * @Template()
     */
    public function displayArticleAction($id_article)
    {
        $request = $this->get('request');
        $session = $request->getSession();
        
        $article = $this->getDoctrine()
                ->getRepository('IntranetWikiBundle:Article')
                ->find($id_article);
        
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetWikiBundle:Modif');
             
        $modif = $repository->findBy(array('article' => $article->getId()), array('date' => 'DESC'));
        
        if (!$article || count($modif) == 0)
        {
            $error = 'Il semblerait que cet article n\'existe pas dans la base de données.';
            $session->getFlashBag()->add('error', $error);   
            return $this->redirect($this->generateUrl('index_wiki'));
        }
        
        return array(
            'modif' => $modif[0],
        );

    }
    
    /**
     * @Route("/historique", name="wiki_history")
     * @Template()
     */
    public function HistoryAction()
    {
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetWikiBundle:Modif');
        
        $modifs = $repository->findBy(array(), array('date' => 'DESC'));
        
        return array(
            'history' => $modifs
        );
    }
    
    /**
     * @Route("/historique/{id_modif}/voir", name="wiki_display_change")
     * @Template();
     */
    public function DisplayChangeAction($id_modif)
    {
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetWikiBundle:Modif');
        
        $modif = $repository->find($id_modif);
        $history = $repository->findBy(array('article' => $modif->getArticle()->getId()), array('date' => 'DESC'));
        
        if ($history[0]->getId() == $id_modif)
            return $this->redirect($this->generateUrl('wiki_display', array('id_article' => $modif->getArticle()->getId())));
        
        $article = $this->getDoctrine()
                ->getRepository('IntranetWikiBundle:Article')
                ->find($modif->getArticle()->getId());
        
        return array(
            'article' => $modif,
            'actu' => $history[0]
        );
    }

    /**
     * @Route("/historique/article/{id_article}/voir", name="wikiArticle_history")
     * @Template()
     */
    public function HistoryArticleAction($id_article)
    {
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('IntranetWikiBundle:Modif');
        
        $article = $this->getDoctrine()
                ->getRepository('IntranetWikiBundle:Article')
                ->find($id_article);
        
        $modifs = $repository->findBy(array('article' => $id_article), array('date' => 'DESC'));
        
        return array(
            'article' => $article,
            'history' => $modifs
        );
    }
    
    /**
     * @Route("/article/{id_article}/supprimer", name="wiki_delete")
     * @Template()
     */
    public function deleteAction($id_article)
    {
        $request = $this->get('request');
        $session = $request->getSession();
        
        $article = $this->getDoctrine()
                ->getRepository('IntranetWikiBundle:Article')
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
                    $newModif = new Modif();
                
                    $user = $this->get('security.context')->getToken()->getUser();

                    $article->setActive(false);
                    $newModif->setDate(new \DateTime());
                    $newModif->setUser($user);
                    $newModif->setArticle($article);
                    $newModif->setType(2);
                    $newModif->setContent('<p>Cet article a été supprimé</p>');
                    
                    // On l'enregistre notre objet $article dans la base de données
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($article);
                    $em->persist($newModif);
                    $em->flush();

                    $error = 'Article supprimé avec succès.';
                    $session->getFlashBag()->add('success', $error);
                    
                    return $this->redirect($this->generateUrl('index_wiki'));
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
     * @Route("/ajouter/thematique", name="wiki_add_thematic")
     * @Template()
     */
    public function addThematicAction()
    {        
        $thematic = new Thematic();

        $formBuilder = $this->createFormBuilder($thematic);

        $formBuilder
                ->add('name', 'text', array('label' => 'Nom'))
                ->add('description', 'ckeditor', array('label' => 'Description'));

        $form = $formBuilder->getForm();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($thematic);
                $em->flush();

                return $this->redirect($this->generateUrl('index_wiki'));
            }
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
        
    
    /**
     * @Route("/thematique/{id}/voir", name="wiki_display_thematic")
     * @Template()
     */
    public function displayThematicAction($id)
    {
        $request = $this->get('request');
        $session = $request->getSession();
        
        $thematic = $this->getDoctrine()
                ->getRepository('IntranetWikiBundle:Thematic')
                ->find($id);
        
        if (!$thematic)
        {
            $error = 'Il semblerait que cette thématique n\'existe pas dans la base de données.';
            $session->getFlashBag()->add('error', $error);   
            return $this->redirect($this->generateUrl('index_wiki'));
        }
        
        return array(
            'thematic' => $thematic,
        );
    }
    
    
    /**
     * @Route("/recherche/resultats", name="wiki_search_results")
     * @Template()
     */
    public function searchResultsAction()
    {
        $results = null;
        $formBuilder = $this->createFormBuilder();

        $formBuilder->add('search', 'text', array('label' => 'Recherche'));

        $form = $formBuilder->getForm();
        
        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {                
                $repository = $this->getDoctrine()
                        ->getRepository('IntranetWikiBundle:Article');
                
                $results = $repository->searchWikiContent($_POST['form']['search']);
            }
        }
        
        return array(
            'form' => $form->createView(),
            'results' => $results
        );
    }
}