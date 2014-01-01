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
 *          Layout and ViewScript are the same. They are two files with the same methods.
 */
abstract class File
{
    protected $_basePath;
    protected $_folder;
    protected $_name;
    protected $_variables;
    protected $_viewHelperBroker;

    function __construct($_folder, $_name, $_variables)
    {
        $this->_folder = $_folder;
        $this->_name = $_name;
        $this->_variables = $_variables;
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

    public function setVariable($key, $value)
    {
        $this->_variables[$key] = $value;
    }

    public function setVariables($_variables)
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

    /**
     * @param mixed $folder
     */
    public function setFolder($folder)
    {
        $this->_folder = $folder;
    }

    /**
     * @return mixed
     */
    public function getFolder()
    {
        return $this->_folder;
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
     * @return mixed
     */
    public function getBasePath()
    {
        return $this->_basePath;
    }

    public function render($file = '')
    {
        if ($file == '') {
            $file = $this->_name;
        }
        require $this->_basePath . DIRECTORY_SEPARATOR . $this->_folder . DIRECTORY_SEPARATOR . $file  . '.phtml';
    }
}