<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 21/12/13
 * Time: 23:17
 */

use xen\Application;
use xen\config\Ini;
use xen\View;

require_once 'library/xen/Bootstrap.php';

class Bootstrap extends \xen\Bootstrap
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
        if ($this->_appEnv == Application::DEVELOPMENT) {
            error_reporting(E_ALL | E_STRICT);
        }
        $timeZone = (string) $this->Config->timezone;
        if (empty($timeZone)) {
            $timeZone = 'Europe/Madrid';
        }
        date_default_timezone_set($timeZone);

        return null;
    }

    protected function _initView()
    {
        //$view = $this->_view = new View($title, $description, $layout, $content, $viewVariables);
        //return $view;
    }
}
