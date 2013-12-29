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

namespace xen;

use xen\Config\Ini;

require_once 'library/xen/Autoloader.php';

class Bootstrap
{
    protected $_appEnv;

    public function __construct($_appEnv)
    {
        $this->_appEnv = $_appEnv;
        $this->_autoload();
    }

    /*
     * Default autoload
     */

    private function _autoload()
    {
        $applicationAutoloader = new Autoloader();
        $xenAutoloader = new Autoloader('library');

        $applicationAutoloader->register();
        $xenAutoloader->register();

    }

    /*
     * Here we call every _init method in application/Bootstrap.php
     * This initializes resources and store them in properties
     */
    public function bootstrap()
    {
        $methods = get_class_methods($this);

        forEach($methods as $method)
        {
            if (strlen($method) > 5 && substr($method, 0, 5) === '_init') {
                $resourceName = ucfirst(substr($method, 5));
                $this->$resourceName = $this->$method();
            }
        }
    }

    public function getResource($resource)
    {
        return $this->$resource;
    }

    /*
     * Default Resources
     */

    protected function _initDatabase()
    {
        $configDb = new Ini('db.ini', $this->_appEnv);
        if (isset($configDb->driver)) {
            $database = new Adapter($configDb);
            return $database;
        }
        return null;
    }

}
