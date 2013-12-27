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

namespace library;


use library\Config\Ini;

class Bootstrap
{
    protected $appEnv;

    public function __construct($appEnv)
    {
        $this->appEnv = $appEnv;
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

    protected function _initDatabase()
    {
        $configDb = new Ini('db.ini', $this->appEnv);
        if (isset($configDb->driver)) {
            $database = new Adapter($configDb);
            return $database;
        }
        return null;
    }

    public function getResource($resource)
    {
        return $this->$resource;
    }

}
