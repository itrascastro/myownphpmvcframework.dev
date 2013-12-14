<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 12/12/13
 * Time: 16:48
 */

namespace application\controllers;

use library\Controller;
use library\View;

class ErrorController extends Controller
{
    public function init()
    {

    }

    public function indexAction()
    {
        $title = 'MyOwnPhpMVCFramework - Error';
        $description = 'Error found';
        $layout = 'default';
        $content = 'error/index';
        $viewVariables = array('msg' => $this->getParam('msg'));
        $viewHelpers = array();
        $this->_view = new View($title, $description, $layout, $content, $viewVariables, $viewHelpers);
        return $this->_view->render();
    }

} 