<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:41
 */

namespace xen\application;

use controllers\ErrorController;
use controllers\IndexController;

class FrontController
{
    const URL_CONTROLLER    = 'Controller';
    const URL_ACTION        = 'Action';

    private $_controller;
    private $_bootstrap;

    public function __construct($bootstrap)
    {
        $this->_bootstrap = $bootstrap;
    }

    public function route()
    {
        if (isset($_GET['url']))
        {
            $url = rtrim($_GET['url'], '/'); //remove last /
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $controllerName = $this->_getName($url[0], self::URL_CONTROLLER);
            $controllerName .= 'Controller';
            $file = str_replace('/', DIRECTORY_SEPARATOR, 'application/controllers/') . $controllerName . '.php';

            if (file_exists($file)) {
                $controllerClassName = 'controllers\\' . $controllerName;
                $defaultViewPath = str_replace('/', DIRECTORY_SEPARATOR,
                    'application/views/scripts/' . strtolower($controllerName));
                $this->_controller = new $controllerClassName($this->_bootstrap, $defaultViewPath);

                if (isset($url[1])) {
                    $action = $this->_getName($url[1], self::URL_ACTION) . 'Action';
                    if (method_exists($this->_controller, $action)) {
                        if (isset($url[2])) {
                            $this->_controller->setParams($this->_getParamsFromUrl($url));
                        }
                        $this->_controller->setView($this->_bootstrap->getResource('View'));

                        return $this->_controller->$action();

                    } else {//method does not exist
                        $params = array(
                                    'msg' => 'Method ' . $url[1] . ' does not exist',
                                  );

                        return $this->_showError($params);
                    }
                }

                return $this->_controller->indexAction();

            } else {//controller does not exist
                $params = array(
                    'msg' => 'Controller ' . $url[0] . ' does not exist',
                );

                return $this->_showError($params);
            }
        }

        return $this->_showIndex();
    }

    /*
     * $type = {'Controller' | 'Action'}
     */
    private function _getName($url, $type)
    {
        $words = explode('-', $url);
        $name = '';
        if ($type == 'Action') {
            $first = true;
        } else {
            $first = false;
        }

        foreach ($words as $word)
        {
            if (!$first) {
                $name .= ucfirst($word);
            } else {
                $name .= $word;
                $first = false;
            }
        }

        return $name;
    }

    private function _showIndex()
    {
        $defaultViewPath = str_replace('/', DIRECTORY_SEPARATOR, 'application/views/scripts/index');
        $this->_controller = new IndexController($this->_bootstrap, $defaultViewPath);
        $this->_controller->setView($this->_bootstrap->getResource('View'));

        return $this->_controller->indexAction();
    }

    private function _showError($params = array())
    {
        $defaultViewPath = str_replace('/', DIRECTORY_SEPARATOR, 'application/views/scripts/error');
        $this->_controller = new ErrorController($this->_bootstrap, $defaultViewPath);
        $this->_controller->setParams($params);
        $this->_controller->setView($this->_bootstrap->getResource('View'));

        return $this->_controller->indexAction();
    }

    private function _getParamsFromUrl($url)
    {
        $params = array();
        $i = 2;

        while (isset($url[$i]))
        {
            if (isset($url[$i+1])) {
                $params[$url[$i]] = $url[$i+1];
            } else {
                $params[$url[$i]] = null;
            }
            $i += 2;
        }

        return $params;
    }
}
