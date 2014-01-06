<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace xen\mvc\view;

/**
 * Class File
 *
 * @package xen\mvc\view
 * @author  Ismael Trascastro itrascastro@xenframework.com
 *
 *          A phtml file can have partials. A partial is a phtml
 */
class Phtml
{
    public $_basePath;
    public $_name;
    public $_variables;
    public $_partials;
    public $_viewHelperBroker;

    function __construct($_basePath, $_name, $_viewHelperBroker, $_variables=array(), $_partials = array())
    {
        $this->_basePath = $_basePath;
        $this->_name = $_name;
        $this->_viewHelperBroker = $_viewHelperBroker;
        $this->_variables = $_variables;
        $this->_partials = $_partials;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    public function getVariables()
    {
        return $this->_variables;
    }

    public function setVariables($_variables)
    {
        $this->_variables = $_variables;
    }

    public function addVariables($_variables)
    {
        foreach ($_variables as $key => $value) {
            $this->_variables[$key] = $value;
        }
    }

    public function getVariable($key)
    {
        if (array_key_exists($key, $this->_variables)) {
            return $this->_variables[$key];
        }
    }

    /**
     * @param mixed $basePath
     */
    public function setBasePath($basePath)
    {
        $this->_basePath = $basePath;
    }

    public function getBasePath()
    {
        return $this->_basePath;
    }

    /**
     * @param mixed $viewHelperBroker
     */
    public function setViewHelperBroker($viewHelperBroker)
    {
        $this->_viewHelperBroker = $viewHelperBroker;
    }

    /**
     * @return mixed
     */
    public function getViewHelperBroker()
    {
        return $this->_viewHelperBroker;
    }

    public function render()
    {
        require $this->_basePath . DIRECTORY_SEPARATOR . $this->_name  . '.phtml';
    }

    /**
     * @param mixed $_partials
     */
    public function setPartials($_partials)
    {
        $this->_partials = $_partials;
    }

    /**
     * @return mixed
     */
    public function getPartials()
    {
        return $this->_partials;
    }

    /**
     * @param array $_partials Is an associative array ('name' => $partial)
     */
    public function addPartials($_partials)
    {
        foreach ($_partials as $name => $partial) {
            $partial->setViewHelperBroker($this->_viewHelperBroker);
            $this->_partials[$name] = $partial;
        }
    }

    public function partial($name)
    {
        return $this->_partials[$name];
    }
}
