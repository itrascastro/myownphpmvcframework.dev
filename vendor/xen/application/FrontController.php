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
use xen\http\Response;

// ****************************
//        $eventSystem = $this->_bootstrap->getResource('EventSystem');
//        $event = new Event('FrontController_Load', array('msg' => 'Event Raised from FrontController'));
//        $eventSystem->raiseEvent($event);
//*****************************

class FrontController
{
    const EXCEPTION_HANDLER_ACTION = 'exceptionHandler';

    private $_bootstrap;
    private $_request;
    private $_router;
    private $_controller;
    private $_action;
    private $_content;
    private $_errorController;
    private $_response;
    private $_statusCode;
    private $_eventSystem;

    public function __construct($_bootstrap, $_request)
    {
        $this->_bootstrap = $_bootstrap;
        $this->_request = $_request;
        $this->_eventSystem = $_bootstrap->getResource('EventSystem');
    }

    public function run()
    {
        $url = $this->_request->get('url');
        $this->_request->setUrl($url);

        $this->_router = new Router($url);
        $this->_bootstrap->addResource('Router', $this->_router);
        $this->_router->route();

        $this->_statusCode = ($this->_router->getAction() != 'PageNotFound') ? 200 : 404;

        $this->_response = new Response();
        $this->_bootstrap->addResource('Response', $this->_response);
        $this->_response->setHeaders('Content-Type', 'text/html');

        $this->_setErrorController();
        $this->_setController();

        try {

            $this->_raiseEvent('PreDispatch');

            $action = $this->_action;
            $this->_content = $this->_controller->$action();

            $this->_raiseEvent('PostDispatch');

        } catch (\Exception $e) {

            $this->_exceptionHandler($e);
        }

        $this->_response->setStatusCode($this->_statusCode);
        $this->_response->setContent($this->_content);

        return $this->_response->send();
    }

    private function _raiseEvent($name)
    {
        $event = new Event($name, array('controller' => $this->_controller));
        $this->_eventSystem->raiseEvent($event);
    }

    private function _exceptionHandler($e)
    {
        $this->_errorController->setParams(array('e' => $e));
        $action = FrontController::EXCEPTION_HANDLER_ACTION . 'Action';
        $this->_content = $this->_errorController->$action();
        $this->_statusCode = 500;
    }

    private function _setErrorController()
    {
        $this->_errorController = new ErrorController();
        $action = FrontController::EXCEPTION_HANDLER_ACTION . 'Action';
        $this->_bootstrap->resolveController(
            $this->_errorController,
            'error',
            FrontController::EXCEPTION_HANDLER_ACTION,
            true
        );
        set_exception_handler(array($this->_errorController, $action));
    }

    private function _setController()
    {
        $controller = 'controllers\\' . $this->_router->getController() . 'Controller';
        $this->_action = $this->_router->getAction() . 'Action';

        $this->_controller = new $controller();

        $this->_bootstrap->resolveController(
            $this->_controller,
            $this->_router->getController(),
            $this->_router->getAction()
        );

        $this->_controller->init();
    }
}
