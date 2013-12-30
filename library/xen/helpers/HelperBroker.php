<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 17/12/13
 * Time: 11:34
 */

namespace xen\helpers;

class HelperBroker
{
    const ACTION_HELPER = 0;
    const VIEW_HELPER = 1;

    private $_type;

    private $_libNamespace;
    private $_appNamespace;
    private $_libPath;
    private $_appPath;

    public function __construct($_type)
    {
        if ($_type == self::ACTION_HELPER) {
            $this->_type = $_type;
            $this->_libNamespace = 'xen\\helpers\\actionHelpers';
            $this->_appNamespace = 'controllers\\helpers\\';
            $this->_libPath      = str_replace('/', DIRECTORY_SEPARATOR, 'library/xen/helpers/actionHelpers/');
            $this->_appPath      = str_replace('/', DIRECTORY_SEPARATOR, 'application/controllers/helpers/');
        } else if ($_type == self::VIEW_HELPER) {
            $this->_type = $_type;
            $this->_libNamespace = 'xen\\helpers\\viewHelpers';
            $this->_appNamespace = 'views\\helpers\\';
            $this->_libPath      = str_replace('/', DIRECTORY_SEPARATOR, 'library/xen/helpers/viewHelpers/');
            $this->_appPath      = str_replace('/', DIRECTORY_SEPARATOR, 'application/views/helpers/');
        } else {
            $this->_type = null;
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