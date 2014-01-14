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
 *          A phtml file can have partials that are also phtml files
 */
class Phtml
{
    private $_basePath;
    private $_name;
    private $_variables;
    private $_partials;
    private $_viewHelperBroker;

    function __construct($_basePath, $_name, $_variables=array())
    {
        $this->_basePath    = $_basePath;
        $this->_name        = $_name;
        $this->_variables   = $_variables;
        $this->_partials    = array();
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
     * We propagate phtml variables to partials and also inject the ViewHelperBroker
     * @param array $_partials Is an associative array ('name' => $partial)
     */
    public function addPartials($_partials)
    {
        foreach ($_partials as $name => $partial) {
            $this->_partials[$name] = $partial;
        }
    }

    public function partial($name)
    {
        return $this->_partials[$name];
    }

    public function out($string)
    {
        echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * In Bootstrap we set ViewHelperBroker to the very first view, the layout
     * ViewHelperBroker will be passed to the child in the render() method
     * as the view variables of every Phtml => At this point no more variables can be added to this phtml
     *
     */
    public function render()
    {
        $reflect = new \ReflectionObject($this);
        $properties = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($this->getPartials() as $partial) {
            foreach ($properties as $property) {
                $propertyName = $property->getName();
                $partial->$propertyName = $this->$propertyName;
            }
            $partial->setViewHelperBroker($this->_viewHelperBroker);
        }

        require $this->_basePath . DIRECTORY_SEPARATOR . $this->_name  . '.phtml';
    }
}
