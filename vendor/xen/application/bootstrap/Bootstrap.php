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

        $methods = $this->_BootstrapDefaults($methods);
        forEach($methods as $method)
        {
            $resourceName = ucfirst(substr($method, 5));
            $this->_resources[$resourceName] = $this->$method();
        }
    }

    private function _bootstrapDefaults($methods)
    {
        $initMethods = array();

        forEach($methods as $method)
        {
            if (strlen($method) > 8 && substr($method, 0, 8) == '_default') {
                $resourceName = ucfirst(substr($method, 8));
                $this->_resources[$resourceName] = $this->$method();
            } else if (strlen($method) > 5 && substr($method, 0, 5) == '_init') {
                $initMethods[] = $method;
            }
        }

        return $initMethods;
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

    protected function _defaultApplicationConfig()
    {
        return new Ini('application.ini', $this->_appEnv);
    }

    protected function _defaultViewHelperBroker()
    {
        return new HelperBroker(HelperBroker::VIEW_HELPER);
    }

    protected function _defaultActionHelperBroker()
    {
        return new HelperBroker(HelperBroker::ACTION_HELPER);
    }

    protected function _defaultLayoutPath()
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
    protected function _defaultLayout()
    {
        $layout = new Phtml($this->getResource('LayoutPath') . DIRECTORY_SEPARATOR . 'layout.phtml');

        $layout->setViewHelperBroker($this->getResource('ViewHelperBroker'));

        return $layout;
    }

    protected function _defaultEventSystem()
    {
        return new EventSystem();
    }

    protected function _defaultHandlers()
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

    protected function _defaultDependencies()
    {
        return require str_replace('/', DIRECTORY_SEPARATOR, 'application/configs/dependencies.php');
    }

    /*
     * Other resources not auto executed
     */

    protected function _dependencyDatabase()
    {
        $configDb = new Ini('db.ini', $this->_appEnv);
        $database = null;

        if (isset($configDb->driver)) {
            $database = new Adapter($configDb);
        }

        $this->_resources['Database'] = $database;
    }

    /**
     * Resolve dependencies for a given object
     *
     * We injects dependencies via setters methods, so every resource has to be their setters methods created for their
     * dependencies.
     *
     * @param $object
     *
     * @return mixed
     */
    public function resolveDependencies($object)
    {
        $dependencies = $this->_resources['Dependencies'];

        //it can be an object
        if (is_object($object)) {
            $className = get_class($object);
            if (array_key_exists($className, $dependencies)) {
                foreach ($dependencies[$className] as $dependency => $value) {
                    $setMethod = 'set' . ucfirst($dependency);
                    $object->$setMethod($this->resolveDependencies($value));
                }
            }
            $this->_resources[$className] = $object;
        //it can already be a resource
        } else if (array_key_exists($object, $this->_resources)) {
            return $this->_resources[$object];
        //it can be a resource not already executed in bootstrap
        //this kind of resources are added to bootstrap by its own like any other bootstrap resource
        } else if (method_exists($this, '_dependency' . $object)) {
            $resource = '_dependency' . $object;
            $this->$resource();
            return $this->_resources[$object];
        //it is not an object but it has dependencies and we have to resolve them and then instantiate it
        } else if (array_key_exists($object, $dependencies)) {
            $resource = new $object();
            foreach ($dependencies[$object] as $dependency => $value) {
                $arg = $this->resolveDependencies($value);
                $setMethod = 'set' . ucfirst($dependency);
                $resource->$setMethod($arg);
            }
            $this->_resources[$object] = $resource;
            return $resource;
        //it is not an object and it does not have dependencies but it must be instantiated
        //because it is needed as a dependency for another resource
        } else {
            $this->_resources[$object] = new $object();
            return $this->_resources[$object];
        }
    }
}
