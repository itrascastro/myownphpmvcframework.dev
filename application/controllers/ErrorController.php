<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 12/12/13
 * Time: 16:48
 */

namespace controllers;

use xen\mvc\Controller;

class ErrorController extends Controller
{
    public function init()
    {
    }

    public function indexAction()
    {
        $this->_layout->title           = 'xenFramework - Error';
        $this->_layout->description     = 'Error found';
        $this->_view->msg               = $this->getParam('msg');

        return $this->render();
    }
}
