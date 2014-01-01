<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 21/12/13
 * Time: 23:17
 */

namespace bootstrap;

use xen\application\Application;
use xen\config\Ini;
use xen\mvc\view\Layout;
use xen\mvc\view\View;

require str_replace('/', DIRECTORY_SEPARATOR, 'vendor/xen/application/bootstrap/Bootstrap.php');

class Bootstrap extends \xen\application\bootstrap\Bootstrap
{
    protected function _initConfig()
    {
        $config = new Ini('application.ini', $this->_appEnv);

        return $config;
    }

    /*
     * This resource is not needed anymore so we do not store it in the Bootstrap container (return null)
     * In fact this is not a resource, only do actions at the beginning of the new request
     */
    protected function _initEnvironment()
    {
        if ($this->_appEnv == Application::DEVELOPMENT || $this->_appEnv == Application::TEST) {
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_errors', 'on');
        } else if ($this->_appEnv == Application::PRODUCTION) {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
            ini_set('display_errors', 'off');
        }
        $timeZone = (string) $this->getResource('Config')->timezone;
        if (empty($timeZone)) {
            $timeZone = 'Europe/Madrid';
        }
        date_default_timezone_set($timeZone);

        return null;
    }

    protected function _initLayout()
    {
        $config = $this->getResource('Config');
        $variables = array(
            'charset' => (string) $config->charset
        );
        $layout = new Layout('default', 'layout', $variables);

        return $layout;
    }

    protected function _initView()
    {
        $layout = $this->getResource('Layout');
        $view = new View($layout);

        return $view;
    }
}
