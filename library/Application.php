<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:41
 */

/*
 * We injects Bootstrap into FrontController, then the FC will injects it into Controller
 * This allow controllers actions to have access to the resources available in the Bootstrap container
 *
 * Dependency injection: http://net.tutsplus.com/tutorials/php/dependency-injection-in-php/
 * http://richardmiller.co.uk/2011/07/07/dependency-injection-moving-from-basics-to-container/
 *
 * DI vs Registry
 * Registry is a global variable
 */

namespace library;

use application\Bootstrap;

require_once APPLICATION_PATH . '/library/Autoloader.php';

class Application 
{
    private $_autoloader;
    private $_bootstrap;
    private $_frontController;

    public function __construct()
    {
        $this->_autoloader = new Autoloader();
    }

    public function autoload()
    {
        $this->_autoloader->autoload(Autoloader::AUTOLOAD_DEFAULT);
    }

    public function bootstrap()
    {
        $this->_bootstrap = new Bootstrap();
        $this->_bootstrap->bootstrap();
    }

    public function run()
    {
        $this->_frontController = new FrontController($this->_bootstrap);
        $this->_frontController->route();
    }

}