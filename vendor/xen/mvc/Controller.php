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
use xen\mvc\view\Phtml;

abstract class Controller
{
    protected $_view;
    protected $_layout;
    protected $_model;
    protected $_params;
    protected $_request;
    protected $_actionHelperBroker;

    public function __construct(
        Phtml $_layout,
        HelperBroker $_actionHelperBroker
    ) {
        $this->_layout              = $_layout;
        $this->_actionHelperBroker  = $_actionHelperBroker;

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
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->_request = $request;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->_request;
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

    protected function _forward($action)
    {
        $controller = $this->_request->getController();

        $viewPath = str_replace('/', DIRECTORY_SEPARATOR, 'application/views/scripts/');
        $this->_view->setFile($viewPath . $controller . DIRECTORY_SEPARATOR . $action . '.phtml');

        $actionName = $action . 'Action';

        return $this->$actionName();
    }
}
