<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:40
 */

namespace library;

require_once APPLICATION_PATH . '/library/Application.php';

class Index 
{
    private $_application;

    public function __construct()
    {
        $this->_application = new Application();
    }

    public function run()
    {
        $this->_application->autoload();
        $this->_application->bootstrap();
        $this->_application->run();
    }
} 