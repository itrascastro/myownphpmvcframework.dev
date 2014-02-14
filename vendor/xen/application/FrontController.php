<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:41
 */

namespace xen\application;

use controllers\ErrorController;
use xen\eventSystem\Event;
use xen\mvc\view\Phtml;

// ****************************
//        $eventSystem = $this->_bootstrap->getResource('EventSystem');
//        $event = new Event('FrontController_Load', array('msg' => 'Event Raised from FrontController'));
//        $eventSystem->raiseEvent($event);
//*****************************

class FrontController
{
    const ERROR_ACTION = 'exceptionHandler';

    private $_bootstrap;
    private $_request;
    private $_router;
    private $_controller;
    private $_action;
    private $_errorController;
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

        $statusCode = ($this->_router->getAction() != 'PageNotFound') ? 200 : 404;

        $this->_setErrorController();
        $this->_setController();

        $this->_response = new Response();
        $this->_response->setHeaders('Content-Type', 'text/html');

        try {

            $action = $this->_action;
            $content = $this->_controller->$action();

        } catch (\Exception $e) {

            $this->_errorController->setParams(array('e' => $e));
            $action = FrontController::ERROR_ACTION . 'Action';
            $content = $this->_errorController->$action();
            $statusCode = 500;
        }

        $this->_response->setStatusCode($statusCode);
        $this->_response->setContent($content);

        return $this->_response->send();
    }

    private function _setErrorController()
    {
        $this->_errorController = new ErrorController();
        $action = FrontController::ERROR_ACTION;
        $this->_resolveDependencies($this->_errorController, 'error', $action, true);
        set_exception_handler(array($this->_errorController, FrontController::ERROR_ACTION . 'Action'));
    }

    private function _setController()
    {
        $controller = 'controllers\\' . $this->_router->getController() . 'Controller';
        $this->_action = $this->_router->getAction() . 'Action';

        $this->_controller = new $controller();

        $this->_resolveDependencies($this->_controller, $this->_router->getController(), $this->_router->getAction());
    }

    private function _resolveDependencies($controller, $controllerName, $action, $error = false)
    {
        $eventSystem = $this->_bootstrap->getResource('EventSystem');
        $controller->setEventSystem($eventSystem);

        $this->_bootstrap->addResource('Router', $this->_router);

        $layout =  ($error) ? clone $this->_bootstrap->getResource('Layout') : $this->_bootstrap->getResource('Layout');
        $controller->setLayout($layout);

        $actionHelperBroker = $this->_bootstrap->getResource('ActionHelperBroker');
        $controller->setActionHelperBroker($actionHelperBroker);

        $config = $this->_bootstrap->getResource('Config');
        $controller->setConfig($config);

        $controller->setParams($this->_router->getParams());

        $viewPath = str_replace('/', DIRECTORY_SEPARATOR,
            'application/views/scripts/' . lcfirst($controllerName));
        $view = new Phtml($viewPath . DIRECTORY_SEPARATOR . $action . '.phtml');
        $controller->setView($view);

        $this->_request->setController(lcfirst($controllerName));
        $this->_request->setAction($action);
        $controller->setRequest($this->_request);
        $this->_bootstrap->addResource('Request', $this->_request);

        $this->_bootstrap->resolveDependencies($controller);
    }

}
