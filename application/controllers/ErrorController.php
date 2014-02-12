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
        switch ($this->getParam('errorCode')) {

            case '404':
                $this->_layout->title           = $this->_config->siteName . ' - Error 404 - Page not found';
                $this->_layout->description     = 'Page not found';
                $url = $this->_config->siteUrl . '/' . $this->getParam('url');
                $this->_view->msg               = 'The url: ' . $url . ' does not exist in this server';
                break;
        }

        return $this->render();
    }

    public function exceptionHandler($exception)
    {
        echo "Uncaught exception: " , $exception->getMessage(), "\n";
    }
}
