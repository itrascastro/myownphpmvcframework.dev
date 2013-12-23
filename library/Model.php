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

    public function __construct($dbConfig)
    {
        $this->_db = new Adapter($dbConfig);
    }
} 