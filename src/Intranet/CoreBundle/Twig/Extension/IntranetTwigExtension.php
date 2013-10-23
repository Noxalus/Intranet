<?php

namespace Intranet\CoreBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class IntranetTwigExtension extends \Twig_Extension
{
    protected $container;
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'user_photo' => new \Twig_Function_Method($this, 'user_photo'),
            'has_read_category' => new \Twig_Function_Method($this, 'has_read_category'),
            'has_read_topic' => new \Twig_Function_Method($this, 'has_read_topic')
        );
    }

    public function getFilters()
    {
        return array();
    }

    public function user_photo($user, $filter)
    {
        $alt = 'Photo';


        $photo = $user->getPhoto();

        if ($photo)
        {
            $url = $photo->getWebPath();
        }
        else
        {
            $url = 'img/photo/nophoto.png';
        }

        if ($filter)
        {
            $imagineTemplating = $this->container->get('liip_imagine.templating.helper');
            $src = $imagineTemplating->filter($url, $filter, true);
        }
        else
        {
            $src = $this->container->get('templating.helper.assets')->getUrl($url);
        }

        echo '<img src="' . $src . '" alt="' . $alt . '" />';
    }

    public function has_read_category($user, $category)
    {
        $repository = $this->doctrine->getManager()->getRepository('IntranetForumBundle:TopicView');
        
        return $repository->hasReadCategory($user, $category);
    }
    
    public function has_read_topic($user, $topic)
    {
        $repository = $this->doctrine->getManager()->getRepository('IntranetForumBundle:TopicView');
        
        return $repository->hasReadTopic($user, $topic);
    }
    
    public function getName()
    {
        return 'intranet';
    }

}