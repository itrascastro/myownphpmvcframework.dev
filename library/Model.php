<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:42
 */

namespace library;


class Model 
{
    protected $_db;

    public function __construct($dbConfig=null)
    {
        if ($dbConfig != null) {
            $this->_db = new Adapter($this->_dbConfig);
        } else {
            $this->_db = null;
        }
    }
} 