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
 * Class Layout
 *
 * @package xen\mvc\view
 * @author  Ismael Trascastro itrascastro@xenframework.com
 *
 * @var string $_layout Directory name. Every layout has his own directory
 */
class Layout extends File
{
    private $_viewScript;

    public function __construct($_folder, $_name, $_variables = array(), $_viewScript = null)
    {
        parent::__construct($_folder, $_name, $_variables);
        $this->_basePath = str_replace('/', DIRECTORY_SEPARATOR, 'application/layouts');
        $this->_viewScript = $_viewScript;
    }

    public function setViewScript($_viewScript)
    {
        $this->_viewScript = $_viewScript;
    }

    public function getViewScript()
    {
        return $this->_viewScript;
    }

    /**
     * content
     *
     * render view script
     */
    public function content()
    {
        $this->_viewScript->setViewHelperBroker($this->_viewHelperBroker);
        return $this->_viewScript->render();
    }
}