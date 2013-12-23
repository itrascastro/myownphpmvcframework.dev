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
 * 2: Stores the resources in a container, $this->_resources
 */

namespace library;


class Bootstrap
{
    protected $_resources;

    public function __construct()
    {
        $this->_resources = array();
    }

    /*
     * Here we call every _init method in application/Bootstrap.php
     * This initializes resources and store them in $resources
     */
    public function bootstrap()
    {
        $methods = get_class_methods($this);

        forEach($methods as $method)
        {
            if (strlen($method) > 5 && substr($method, 0, 5) === '_init') {
                $this->_resources[ucfirst(substr($method, 5))] = $this->$method();
            }
        }
    }

    public function getResource($resource)
    {
        if (isset($this->_resources[$resource])) {
            return $this->_resources[$resource];
        }
        return null;
    }
} 