<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 17/12/13
 * Time: 11:34
 */

namespace library\helpers;

class HelperBroker
{
    const ACTION_HELPER = 0;
    const VIEW_HELPER = 1;

    private $_type;

    private $_libNamespace;
    private $_appNamespace;
    private $_libPath;
    private $_appPath;

    public function __construct($type)
    {
        if ($type == self::ACTION_HELPER) {
            $this->type = $type;
            $this->_libNamespace = 'library\\helpers\\actionHelpers';
            $this->_appNamespace = 'application\\controllers\\helpers\\';
            $this->_libPath      = 'library/helpers/actionHelpers/';
            $this->_appPath      = 'application/controllers/helpers/';
        } else if ($type == self::VIEW_HELPER) {
            $this->type = $type;
            $this->_libNamespace = 'library\\helpers\\viewHelpers';
            $this->_appNamespace = 'application\\views\\helpers\\';
            $this->_libPath      = 'library/helpers/viewHelpers/';
            $this->_appPath      = 'application/views/helpers/';
        } else {
            $this->type = null;
        }
    }

    public function getHelper($helper, $params=array())
    {
        if ($this->isLibraryHelper($helper)) {
            $className = $this->_libNamespace . $helper;
            return new $className($params);
        } else if ($this->isApplicationHelper($helper)) {
            $className = $this->_appNamespace . $helper;
            return new $className($params);
        }
        return null;
    }

    public function helperExists($helper)
    {
        return $this->isLibraryHelper($helper) || $this->isApplicationHelper($helper);
    }

    public function isLibraryHelper($helper)
    {
        return file_exists($this->_libPath . $helper . '.php');
    }

    public function isApplicationHelper($helper)
    {
        return file_exists($this->_appPath . $helper . '.php');
    }
} 