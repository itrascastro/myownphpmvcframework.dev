<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 12/12/13
 * Time: 16:48
 */

namespace controllers;

use xen\mvc\Controller;
use xen\mvc\view\Phtml;
use xen\mvc\view\View;
use xen\mvc\view\ViewScript;

class ErrorController extends Controller
{
    public function init()
    {
    }

    public function indexAction()
    {
        $layoutVariables = array(
            'title' => 'xenFramework - Error',
            'description'   => 'Error found',
        );
        $this->_layout->addVariables($layoutVariables);
        $viewVariables = array(
            'msg' => $this->getParam('msg'),
        );
        $content = new Phtml($this->_viewPath, 'index', $this->_viewHelperBroker, $viewVariables);
        $this->_layout->addPartials(
            array(
                 'content' => $content,
            )
        );
        return $this->_view->render();
    }
}
