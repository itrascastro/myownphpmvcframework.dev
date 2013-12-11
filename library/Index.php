<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:40
 */

namespace library;


class Index 
{
    private $_application;

    function __construct()
    {
        defined(APPLICATION_PATH) || define(APPLICATION_PATH, realpath(dirname(__FILE__)) . '/..');
        require_once APPLICATION_PATH . '/library/Application.php';

        $this->_application = new Application();

        $this->_application->boostrap();
        $this->_application->run();
    }
} 