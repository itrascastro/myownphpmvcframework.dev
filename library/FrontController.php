<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:41
 */

namespace library;

use application\controllers\ErrorController;
use application\controllers\IndexController;

class FrontController
{
    const URL_CONTROLLER = 'Controller';
    const URL_ACTION = 'Action';

    private $_url;
    private $_controller;
    private $_bootstrap;

    public function __construct($bootstrap)
    {
        $this->_bootstrap = $bootstrap;
        if (isset($_GET['url']))
        {
            $url = rtrim($_GET['url'], '/'); //remove last /
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $this->_url = explode('/', $url);
        }
    }

    public function route()
    {
        if (isset($this->_url))
        {
            $controllerName = $this->_getName($this->_url[0], self::URL_CONTROLLER);
            $modelName = $controllerName . 'Model';
            $controllerName .= 'Controller';
            $file = 'application/controllers/' . $controllerName . '.php';

            if (file_exists($file)) {
                $controllerClassName = 'application\\controllers\\' . $controllerName;
                $this->_controller = new $controllerClassName($this->_bootstrap);
                if (isset($this->_url[1])) {
                    $action = $this->_getName($this->_url[1], self::URL_ACTION) . 'Action';
                    if (method_exists($this->_controller, $action)) {
                        if (isset($this->_url[2])) {
                            $this->_controller->setParams($this->_getParamsFromUrl($this->_url));
                        }
                        $modelClassName = 'application\\models\\' . $modelName;
                        $model = new $modelClassName($this->_bootstrap->Database);
                        $this->_controller->setModel($model);
                        return $this->_controller->$action();
                    } else {//method does not exist
                        $params = array(
                                    'msg' => 'Method ' . $this->_url[1] . ' does not exist',
                                  );
                        return $this->_showError($params);
                    }
                }
                return $this->_controller->indexAction();
            } else {//controller does not exist
                $params = array(
                    'msg' => 'Controller ' . $this->_url[0] . ' does not exist',
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
        $this->_controller = new IndexController($this->_bootstrap);
        return $this->_controller->indexAction();
    }

    private function _showError($params = array())
    {
        $this->_controller = new ErrorController($this->_bootstrap);
        $this->_controller->setParams($params);
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