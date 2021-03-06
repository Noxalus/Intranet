<?php

namespace Intranet\WikiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RenderController extends Controller
{
    /**
     * @Template()
     */
    public function searchAction()
    {
        $formBuilder = $this->createFormBuilder();

        $formBuilder->add('search', 'text', array('label' => 'Recherche', 'attr' => array('style' => 'margin-top: 10px;')));

        $form = $formBuilder->getForm();
        
        return array(
            'form' => $form->createView()
        );
    }
}

