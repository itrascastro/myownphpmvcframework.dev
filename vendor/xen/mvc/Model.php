<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace xen\mvc;


class Model 
{
    protected $_db;

    public function __construct()
    {}

    public function setDb($_db)
    {
        $this->_db = $_db;
    }
} 