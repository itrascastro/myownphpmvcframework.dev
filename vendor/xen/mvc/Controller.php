<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:41
 */

namespace xen\mvc;

/*
 * If the child controller does not define a constructor then it may be inherited from the parent class
 * just like a normal class method
 */


use xen\mvc\helpers\HelperBroker;

abstract class Controller
{
    protected $_bootstrap;
    protected $_view;
    protected $_layout;
    protected $_model;
    protected $_params;
    protected $_actionHelperBroker;

    public function __construct($_bootstrap)
    {
        $this->_bootstrap   = $_bootstrap;
        $this->_layout      = $_bootstrap->getResource('Layout');
        $this->_params      = array();
        $this->_actionHelperBroker = $_bootstrap->getResource('ActionHelperBroker');

        $this->init();
    }

    public abstract function init();
    public abstract function indexAction();

    /**
     * @param $_params
     *
     * @internal param mixed $params
     */
    public function setParams($_params)
    {
        $this->_params = $_params;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->_params;
    }

    public function getParam($key)
    {
        foreach ($this->_params as $keyword => $value)
        {
            if ($keyword == $key) {
                return $value;
            }
        }
        return null;
    }

    public function setModel($_model)
    {
        $this->_model = $_model;
    }

    /**
     * @param mixed $view
     */
    public function setView($_view)
    {
        $this->_view = $_view;
        $this->_layout->addPartials(
            array(
                'content' => $this->_view,
            )
        );
    }

    /**
     * @return mixed
     */
    public function getView()
    {
        return $this->_view;
    }

    /**
     * We extend layout properties to partials
     */
    public function render()
    {
        $this->_layout->render();
    }

    protected function _redirect($controller, $action)
    {
        header('location:' . '/' . $controller . '/' . $action . '/');
        exit;
    }

    protected function _forward($action, $controller = '')
    {
        if ($controller == '') {
            $controllerNameWithoutSuffix = strtolower(
                basename(str_replace('\\', DIRECTORY_SEPARATOR, get_class($this)), 'Controller')
            );
        } else {
            $controllerNameWithoutSuffix = $controller;
        }

        $viewPath = str_replace('/', DIRECTORY_SEPARATOR, 'application/views/scripts/');
        $this->_view->setFile($viewPath . $controllerNameWithoutSuffix . DIRECTORY_SEPARATOR . $action . '.phtml');

        $actionName = $action . 'Action';

        if ($controller == '') {
            return $this->$actionName();
        } else {
            $controllerClassName = '\\controllers\\' . $controller . 'Controller';
            $controllerInstance = new $controllerClassName($this->_bootstrap);
            return $controllerInstance->$actionName();
        }

    }
}
