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
abstract class Controller
{
    protected $_view;
    protected $_model;
    protected $_params;

    public function __construct()
    {
        $this->_params = array();
        $this->init();
    }

    public abstract function init();

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->_params = $params;
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
}