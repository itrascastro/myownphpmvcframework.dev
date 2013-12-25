<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:42
 */

namespace library;


abstract class Model
{
    protected $_db;

    public function __construct($database=null)
    {
        if ($database != null) {
            $this->_db = $database;
        } else {
            $this->_db = null;
        }
        $this->init();
    }

    public abstract function init();
} 