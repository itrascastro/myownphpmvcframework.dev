<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 21/12/13
 * Time: 23:17
 */

namespace application;

use library\Config\Ini;

class Bootstrap extends \library\Bootstrap
{
    public function _initConfig()
    {
        $config = new Ini('application.ini', $this->appEnv);
        return $config;
    }

    public function _initView()
    {
        $view = 'view';
        return $view;
    }
}
