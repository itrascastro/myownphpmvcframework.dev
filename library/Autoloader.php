<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 10:28
 */

namespace library;

define(AUTOLOAD_DEFAULT, 'autoloadDefault');

class Autoloader 
{
    private $_method;

    function __construct($_method = AUTOLOAD_DEFAULT)
    {
        $this->_method = $_method;
    }

    private function autoload()
    {
        spl_autoload_register(array($this, $this->_method));
    }

    private function autoloadDefault($className)
    {
        require_once APPLICATION_PATH . '/' . str_replace('\\', '/', $className) . '.php';
    }
} 