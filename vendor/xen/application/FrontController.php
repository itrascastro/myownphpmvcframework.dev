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

class FrontController
{
    private $_controller;
    private $_bootstrap;

    public function __construct($_bootstrap)
    {
        $this->_bootstrap = $_bootstrap;
//        $eventSystem = $this->_bootstrap->getResource('EventSystem');
//        $event = new Event('FrontController_Load', array('msg' => 'Event Raised from FrontController'));
//        $eventSystem->raiseEvent($event);
    }

    public function run()
    {
        $url = (isset($_GET['url'])) ? $_GET['url'] : '';
        $router = new Router($url);
        $router->route();

        $this->_bootstrap->addResource('Router', $router);

        $viewPath = str_replace('/', DIRECTORY_SEPARATOR,
            'application/views/scripts/' . lcfirst($router->getController()));

        $layout = $this->_bootstrap->getResource('Layout');
        $actionHelperBroker = $this->_bootstrap->getResource('ActionHelperBroker');

        $controller = 'controllers\\' . $router->getController() . 'Controller';
        $this->_controller = new $controller($layout, $actionHelperBroker);

        $this->_controller->setParams($router->getParams());

        $view = new Phtml($viewPath . DIRECTORY_SEPARATOR . $router->getAction() . '.phtml');
        $this->_controller->setView($view);

        $request = new Request(lcfirst($router->getController()), $router->getAction());
        $this->_controller->setRequest($request);
        $this->_bootstrap->addResource('Request', $request);

        $this->_bootstrap->resolveDependencies($this->_controller);

        $action = $router->getAction() . 'Action';

        return $this->_controller->$action();
    }

}
