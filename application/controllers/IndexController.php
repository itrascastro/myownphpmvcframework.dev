<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 12/12/13
 * Time: 16:45
 */

namespace controllers;

use views\helpers\ShowFormHelper;
use xen\config\Ini;
use xen\mvc\Controller;
use xen\mvc\view\Phtml;

class IndexController extends Controller
{
    public function init()
    {
    }

    public function indexAction()
    {
        $layout = $this->_view->getLayout();
        $layoutVariables = array(
            'title'         => 'xenFramework.com',
            'description'   => 'Create your own Php MVC Framework from scratch',
        );
        $layout->addVariables($layoutVariables);
        $viewHelperBroker = $this->_bootstrap->getResource('ViewHelperBroker');
        $content = new Phtml($this->_viewPath, 'index', $viewHelperBroker);
        $layout->addPartials(
            array(
                'content' => $content,
            )
        );
        return $this->_view->render();
    }
} 