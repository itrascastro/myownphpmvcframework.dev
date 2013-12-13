<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 12/12/13
 * Time: 16:45
 */

namespace application\controllers;

use library\Controller;
use library\View;

class IndexController extends Controller
{
    public function init()
    {
    }

    public function indexAction()
    {
        $title = 'MyOwnPhpMVCFramework';
        $description = 'Create your own Php MVC Framework from scratch';
        $layout = '../application/layouts/default.phtml';
        $content = '../application/views/scripts/index/index.phtml';
        $viewVariables = array();
        $viewHelpers = array();
        $this->_view = new View($title, $description, $layout, $content, $viewVariables, $viewHelpers);
        return $this->_view->render();
    }
} 