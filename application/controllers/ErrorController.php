<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace controllers;


use xen\mvc\Controller;
use xen\mvc\ErrorControllerBase;

class ErrorController extends ErrorControllerBase
{
    public function pageNotFoundAction()
    {
        $this->_layout->title           = 'Error 404 - Page Not Found';
        $this->_layout->description     = '404';

        $this->_view->url = $this->getParam('url');

        return $this->render();
    }

    function exceptionHandlerAction()
    {
        $e = $this->getParam('e');

        $this->_layout->title           = 'Error - Exception Raised';
        $this->_layout->description     = 'Error - ' . $e->getMessage();

        $exceptionValues = array();

        $exceptionValues['Message']     = $e->getMessage();
        $exceptionValues['Code']        = $e->getCode();
        $exceptionValues['File']        = $e->getFile();
        $exceptionValues['Line']        = $e->getLine();
        $exceptionValues['Trace']       = preg_replace("/\n/", '<br>', $e->getTraceAsString());

        $this->_view->msgs = $exceptionValues;

        return $this->render();
    }
}