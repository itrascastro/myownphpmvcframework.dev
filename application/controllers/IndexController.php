<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 12/12/13
 * Time: 16:45
 */

namespace controllers;

use views\helpers\ShowFormHelper;
use xen\mvc\Controller;
use xen\mvc\view\ViewScript;

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
        $layout->setVariables($layoutVariables);
        $viewScript = new ViewScript('index', 'index');
        $layout->setViewScript($viewScript);
        return $this->_view->render();
    }
} 