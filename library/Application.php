<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:41
 */

namespace library;

require_once APPLICATION_PATH . '/library/Autoloader.php';
require_once APPLICATION_PATH . '/library/Boostrap.php';
require_once APPLICATION_PATH . '/library/FrontController.php';

class Application 
{
    private $_autoloader;
    private $_boostrap;
    private $_frontController;

    public function __construct()
    {
        $this->_autoloader = new Autoloader();
        $this->_boostrap = new Boostrap();
        $this->_frontController = new FrontController();
    }

    public function autoload()
    {
        $this->_autoloader->autoload(Autoloader::AUTOLOAD_DEFAULT);
    }

    public function boostrap()
    {
        $this->_boostrap->boostrap();
    }

    public function run()
    {
        $this->_frontController->route();
    }

}