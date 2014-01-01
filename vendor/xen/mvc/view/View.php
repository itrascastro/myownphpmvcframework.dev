<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace xen\mvc\view;
use xen\mvc\helpers\HelperBroker;

/**
 * Class View
 *
 * @package xen\mvc\view
 * @author  Ismael Trascastro itrascastro@xenframework.com
 *
 *          View is a concept. It is composed by a Layout and the layout uses a ViewScript
 */
class View 
{
    private $_layout;
    private $_viewHelperBroker;

    public function __construct($_layout)
    {
        $this->_layout = $_layout;
        $this->_viewHelperBroker = new HelperBroker(HelperBroker::VIEW_HELPER);
        $this->_layout->setViewHelperBroker($this->_viewHelperBroker);
    }

    /**
     * @param mixed $layout
     */
    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }

    /**
     * @return mixed
     */
    public function getLayout()
    {
        return $this->_layout;
    }

    public function render()
    {
        return $this->_layout->render();
    }
}
