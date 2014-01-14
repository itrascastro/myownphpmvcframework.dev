<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:41
 */

/*
 * Bootstrap does two things:
 * 1: Initializes every resource in application/Bootstrap
 * 2: Stores the resources as properties
 */

namespace xen\application\bootstrap;

use xen\config\Ini;
use xen\db\Adapter;
use xen\eventSystem\EventSystem;
use xen\mvc\helpers\HelperBroker;
use xen\mvc\view\Phtml;
use xen\mvc\view\View;

require str_replace('/', DIRECTORY_SEPARATOR, 'vendor/xen/application/bootstrap/Autoloader.php');

/**
 * Class Bootstrap
 *
 * @package xen\application\bootstrap
 * @author  Ismael Trascastro itrascastro@xenframework.com
 *
 */
class Bootstrap
{
    protected $_appEnv;
    protected $_resources;

    /**
     * @param $_appEnv
     *
     * we call _autoload here instead of as an _init resource because we need it to be the first created resource
     */
    public function __construct($_appEnv)
    {
        $this->_appEnv = $_appEnv;
        $this->_resources = array();
        $this->_autoload();
    }

    /*
     * Default autoload
     */

    private function _autoload()
    {
        $defaultAutoload = new Autoloader(array('application', 'vendor'));
        $defaultAutoload->register();
    }

    /*
     * Here we call every _init method in application/Bootstrap.php
     * This initializes resources and store them in properties
     */
    public function bootstrap()
    {
        $methods = get_class_methods($this);

        $this->_defaultBootstrap($methods);
        forEach($methods as $method)
        {
            if (strlen($method) > 5 && substr($method, 0, 5) == '_init') {
                $resourceName = ucfirst(substr($method, 5));
                $this->_resources[$resourceName] = $this->$method();
            }
        }
    }

    private function _defaultBootstrap($methods)
    {
        forEach($methods as $method)
        {
            if (strlen($method) > 12 && substr($method, 0, 12) == '_initDefault') {
                $resourceName = ucfirst(substr($method, 12));
                $this->_resources[$resourceName] = $this->$method();
            }
        }
    }

    public function addResources(array $resources)
    {
        foreach ($resources as $resource => $value) {
            $this->_resources[$resource] = $value;
        }
    }

    public function getResource($resource)
    {
        return (array_key_exists($resource, $this->_resources) ? $this->_resources[$resource] : null);
    }

    /*
     * Default Resources
     */

    protected function _initDefaultApplicationConfig()
    {
        return new Ini('application.ini', $this->_appEnv);
    }

    protected function _initDefaultDatabase()
    {
        $configDb = new Ini('db.ini', $this->_appEnv);
        if (isset($configDb->driver)) {
            $database = new Adapter($configDb);
            return $database;
        }
        return null;
    }

    protected function _initDefaultViewHelperBroker()
    {
        return new HelperBroker(HelperBroker::VIEW_HELPER);
    }

    protected function _initDefaultActionHelperBroker()
    {
        return new HelperBroker(HelperBroker::ACTION_HELPER);
    }

    protected function _initDefaultLayoutPath()
    {
        $applicationConfig = $this->getResource('ApplicationConfig');

        if (isset($applicationConfig->defaultLayoutPath)) {
            return str_replace('/', DIRECTORY_SEPARATOR, $applicationConfig->defaultLayoutPath);
        }
        return null;
    }

    /**
     * Here we set ViewHelperBroker, then it will be propagated to child phtml in render()
     *
     * @return Phtml
     */
    protected function _initDefaultLayout()
    {
        $layout = new Phtml($this->getResource('LayoutPath') . DIRECTORY_SEPARATOR . 'layout.phtml');

        $layout->setViewHelperBroker($this->getResource('ViewHelperBroker'));

        return $layout;
    }

    protected function _initDefaultEventSystem()
    {
        return new EventSystem();
    }

    protected function _initDefaultHandlers()
    {
        $handlers = require str_replace('/', DIRECTORY_SEPARATOR, 'application/configs/handlers.php');

        $eventSystem = $this->getResource('EventSystem');

        foreach ($handlers as $handler) {
            $handlerName = 'eventHandlers\\' . $handler['handler'];
            $handlerInstance = new $handlerName();
            $handlerInstance->addHandles($handler['events']);
            $eventSystem->addHandler($handlerInstance);
        }
    }
}
