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

    public function __construct()
    {
        if (isset($_GET['url']))
        {
            $url = rtrim($_GET['url'], '/'); //remove last /
            $this->_url = explode('/', $url);
        }
    }

    public function route()
    {
        if (isset($this->_url))
        {
            $controllerName = $this->getName($this->_url[0], self::URL_CONTROLLER);
            $file = APPLICATION_PATH . '/application/controllers/' . $controllerName . '.php';

            if (file_exists($file)) {
                $className = 'application\\controllers\\' . $controllerName;
                $this->_controller = new $className();
                if (isset($this->_url[1])) {
                    $action = $this->getName($this->_url[1], self::URL_ACTION);
                    if (method_exists($this->_controller, $action)) {
                        if (isset($this->_url[2])) {
                            $this->_controller->setParams($this->getParamsFromUrl($this->_url));
                        }
                        return $this->_controller->$action();
                    } else {//method does not exist
                        $params = array(
                                    'msg' => 'Method ' . $this->_url[1] . ' does not exist',
                                  );
                        return $this->showError($params);
                    }
                }
                return $this->_controller->indexAction();
            } else {//controller does not exist
                $params = array(
                    'msg' => 'Controller ' . $this->_url[0] . ' does not exist',
                );
                return $this->showError($params);
            }
        }
        return $this->showIndex();
    }

    /*
     * $type = {'Controller' | 'Action'}
     */
    private function getName($url, $type)
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

        return $name . $type;
    }

    private function showIndex()
    {
        $this->_controller = new IndexController();
        return $this->_controller->indexAction();
    }

    private function showError($params = array())
    {
        $this->_controller = new ErrorController();
        $this->_controller->setParams($params);
        return $this->_controller->indexAction();
    }

    private function getParamsFromUrl($url)
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