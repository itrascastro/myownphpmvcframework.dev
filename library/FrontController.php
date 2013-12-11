<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:41
 */

namespace library;


class FrontController {
    private $_url;
    private $_controller;

    function __construct()
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
            $controllerName = $this->getName($this->_url[0], 'Controller');
            $file = APPLICATION_PATH . '/application/controllers/' . $controllerName . '.php';

            if (file_exists($file)) {
                $className = 'application\\controllers\\' . $controllerName;
                $this->_controller = new $className;
                if (isset($url[1])) {
                    $action = $this->getName($url[1], 'Action');
                    if (method_exists($this->_controller, $action)) {
                        if (isset($url[2])) {
                            $this->_controller->setParams($this->getParamsFromUrl($url));
                        }
                        return $this->_controller->$action();
                    }
                    return $this->showError();
                }
                return $this->showError();
            }
            return $this->showError();
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
        $this->_controller = new Controllers\IndexController();
        return $this->_controller->indexAction();
    }

    private function showError()
    {
        $this->_controller = new Controllers\ErrorController();
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