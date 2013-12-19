<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:42
 */

namespace library;


use library\helpers\HelperBroker;

class View
{
    private $_title;
    private $_description;
    private $_layout;
    private $_viewScript;
    private $_viewVariables;
    private $_viewHelperBroker;

    function __construct(
        $_title,
        $_description,
        $_layout,
        $_viewScript,
        $_viewVariables = array())
    {
        $this->_title = $_title;
        $this->_description = $_description;
        $this->_layout = $_layout;
        $this->_viewScript = $_viewScript;
        $this->_viewVariables = $_viewVariables;
        $this->_viewHelperBroker = new HelperBroker(HelperBroker::VIEW_HELPER);
    }

    /*
     * Every method has access to class properties.
     * This is also true inside a required file in a method
     */
    public function render()
    {
        require_once APPLICATION_PATH . '/application/layouts/' . $this->_layout . '.phtml';
    }

    public function content()
    {
        require_once APPLICATION_PATH . '/application/views/scripts/' . $this->_viewScript . '.phtml';
    }

    public function title()
    {
        return $this->_title;
    }

    public function description()
    {
        return $this->_description;
    }

}