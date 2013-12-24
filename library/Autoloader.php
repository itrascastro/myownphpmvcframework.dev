<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 10:28
 *
 * We need this class because if PHP change the autoload function interface
 * we implement this using the adapter design pattern
 */

namespace library;

class Autoloader 
{
    const AUTOLOAD_DEFAULT = '_autoloadDefault';

    private $_method;

    public function __construct($_method = self::AUTOLOAD_DEFAULT)
    {
        $this->_method = $_method;
    }

    public function autoload()
    {
        spl_autoload_register(array($this, $this->_method));
    }

    private function _autoloadDefault($className)
    {
        require_once str_replace('\\', '/', $className) . '.php';
    }
} 