<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:41
 */

namespace library;

/*
 * If the child controller does not define a constructor then it may be inherited from the parent class
 * just like a normal class method
 */


use library\helpers\HelperBroker;

abstract class Controller
{
    protected $_bootstrap;
    protected $_view;
    protected $_model;
    protected $_params;
    protected $_actionHelperBroker;

    public function __construct($bootstrap)
    {
        $this->_bootstrap = $bootstrap;
        $this->_actionHelperBroker = new HelperBroker(HelperBroker::ACTION_HELPER);
        $this->_params = array();
        $this->init();
    }

    public abstract function init();
    public abstract function indexAction();

    /**
     * @param mixed $params
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

}