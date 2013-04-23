<?php

namespace Intranet\UserBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class IntranetExtension extends \Twig_Extension
{
    protected $container;

    public function __construct()
    {
        
    }

    public function getFunctions()
    {
        return array(
            'user_photo' => new \Twig_Function_Method($this, 'user_photo'),
            'photo' => new \Twig_Function_Method($this, 'photo'),
            'photoUrl' => new \Twig_Function_Method($this, 'photo_url')
        );
    }

    public function getFilters()
    {
        return array();
    }

    public function user_photo($user, $filter, $type = null)
    {
        $alt = $user->getFirstName() . ' ' . substr($user->getLastName(), 0, 1);

        $src = $this->container->get('intranet.user.manager')->getUserPhoto($user, $filter, $type);

        echo '<img src="' . $src . '" alt="' . $alt . '" />';
    }

    public function photo($url, $alt, $filter)
    {
        echo '<img src="' . $this->photo_url($url, $filter) . '" alt="' . $alt . '" />'; //TODO ajouter width & height
    }

    public function photo_url($url, $filter)
    {
        $imagineTemplating = $this->container->get('liip_imagine.templating.helper');
        $url = 'upload/' . $url;

        return $src = $imagineTemplating->filter($url, $filter, true);
    }

    public function getName()
    {
        return 'intranet';
    }

}