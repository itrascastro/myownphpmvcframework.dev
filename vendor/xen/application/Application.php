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

namespace xen\application;

use bootstrap\Bootstrap;
use xen\application\bootstrap\Autoloader;

require str_replace('/', DIRECTORY_SEPARATOR, 'vendor/xen/application/bootstrap/Autoloader.php');

class Application 
{
    const DEVELOPMENT   = 'development';
    const TEST          = 'test';
    const PRODUCTION    = 'production';

    private $_bootstrap;
    private $_frontController;
    private $_appEnv;

    public function __construct($_appEnv)
    {
        $this->_appEnv = $_appEnv;
    }

    public function bootstrap()
    {
        $autoLoader = new Autoloader(array('application', 'vendor'));
        $autoLoader->register();

        $this->_bootstrap = new Bootstrap($this->_appEnv);
        $this->_bootstrap->addResource('AutoLoader', $autoLoader);
        $this->_bootstrap->bootstrap();
    }

    public function run()
    {
        $this->_frontController = new FrontController($this->_bootstrap);
        $this->_frontController->run();
    }
}
