<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace xen\mvc\view;


class View 
{
    private $_layout;

    public function __construct($_layout=null)
    {
        $this->_layout = $_layout;
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
        $this->_layout->render();
    }
}
