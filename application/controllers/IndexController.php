<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 12/12/13
 * Time: 16:45
 */

namespace application\controllers;

use application\views\helpers\ShowFormHelper;
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
        $layout = 'default';
        $content = 'index/index';
        $viewVariables = array('msg' => 'PHPMVCFramework');
        $viewHelpers = array('ShowFormHelper' => new ShowFormHelper('index', 'fr1', 'ok'));
        $this->_view = new View($title, $description, $layout, $content, $viewVariables, $viewHelpers);
        return $this->_view->render();
        //$this->_actionHelper->getHelper('CustomRedirector')->redirect('error', 'index');
    }
} 