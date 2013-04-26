<?php

namespace Intranet\UserBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class IntranetTwigExtension extends \Twig_Extension
{
    protected $container;

    public function __construct()
    {
        
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'user_photo' => new \Twig_Function_Method($this, 'user_photo')
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

    public function getName()
    {
        return 'intranet';
    }

}