<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:41
 */

namespace xen\application;

use xen\eventSystem\Event;
use xen\mvc\view\Phtml;

// ****************************
//        $eventSystem = $this->_bootstrap->getResource('EventSystem');
//        $event = new Event('FrontController_Load', array('msg' => 'Event Raised from FrontController'));
//        $eventSystem->raiseEvent($event);
//*****************************

class FrontController
{
    private $_bootstrap;
    private $_request;
    private $_router;
    private $_controller;
    private $_response;

    public function __construct($_bootstrap)
    {
        $this->_bootstrap = $_bootstrap;
    }

    public function run()
    {
        $this->_request = new Request();
        $this->_router = new Router($this->_request->getUrl());
        $this->_router->route();

        $controller = 'controllers\\' . $this->_router->getController() . 'Controller';
        $this->_controller = new $controller();

        $this->_resolveDependencies();

        $action = $this->_router->getAction() . 'Action';

        $this->_response = new Response();
        $this->_response->setHeaders('Content-Type', 'text/html');
        $this->_response->setContent($this->_controller->$action());

        return $this->_response->send();
    }

    private function _resolveDependencies()
    {
        $this->_bootstrap->addResource('Router', $this->_router);

        $layout = $this->_bootstrap->getResource('Layout');
        $this->_controller->setLayout($layout);

        $actionHelperBroker = $this->_bootstrap->getResource('ActionHelperBroker');
        $this->_controller->setActionHelperBroker($actionHelperBroker);

        $config = $this->_bootstrap->getResource('Config');
        $this->_controller->setConfig($config);

        $this->_controller->setParams($this->_router->getParams());

        $viewPath = str_replace('/', DIRECTORY_SEPARATOR,
            'application/views/scripts/' . lcfirst($this->_router->getController()));
        $view = new Phtml($viewPath . DIRECTORY_SEPARATOR . $this->_router->getAction() . '.phtml');
        $this->_controller->setView($view);

        $this->_request->setController(lcfirst($this->_router->getController()));
        $this->_request->setAction($this->_router->getAction());
        $this->_controller->setRequest($this->_request);
        $this->_bootstrap->addResource('Request', $this->_request);

        $this->_bootstrap->resolveDependencies($this->_controller);
    }

}
