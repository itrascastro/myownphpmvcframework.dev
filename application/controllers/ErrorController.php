<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 12/12/13
 * Time: 16:48
 */

namespace controllers;

use xen\mvc\Controller;
use xen\mvc\view\View;
use xen\mvc\view\ViewScript;

class ErrorController extends Controller
{
    public function init()
    {

    }

    public function indexAction()
    {
        $layout = $this->_view->getLayout();
        $layoutVariables = array(
            'title' => 'xenFramework - Error',
            'description'   => 'Error found',
        );
        $layout->setVariables($layoutVariables);
        $viewScript = new ViewScript('error', 'index');
        $viewScriptVariables = array(
            'msg' => $this->getParam('msg'),
        );
        $viewScript->setVariables($viewScriptVariables);
        $layout->setViewScript($viewScript);
        return $this->_view->render();
    }
}
