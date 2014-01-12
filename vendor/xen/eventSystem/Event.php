<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace xen\eventSystem;


class Event 
{
    private $_name;
    private $_params;

    public function __construct($_name, array $_params = array()) {
        $this->_name    = $_name;
        $this->_params  = $_params;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }
}