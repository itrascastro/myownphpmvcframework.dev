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

require str_replace('/', DIRECTORY_SEPARATOR, 'library/xen/application/bootstrap/Autoloader.php');

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
        $defaultAutoload = new Autoloader(array('application', 'library'));
        $defaultAutoload->register();
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
            if (strlen($method) > 5 && substr($method, 0, 5) == '_init') {
                $resourceName = ucfirst(substr($method, 5));
                $this->_resources[$resourceName] = $this->$method();
            }
        }
    }

    public function getResource($resource)
    {
        return (array_key_exists($resource, $this->_resources) ? $this->_resources[$resource] : null);
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
