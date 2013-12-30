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
use xen\mvc\View;

class IndexController extends Controller
{
    public function init()
    {
    }

    public function indexAction()
    {
        $title = 'MyOwnPhpMVCFramework';
        $description = 'Create your own Php MVC Framework from scratch';
        $layout = 'default';
        $content = 'index/index';
        $viewVariables = array();
        $this->_view = new View($title, $description, $layout, $content, $viewVariables);

        return $this->_view->render();
    }
} 