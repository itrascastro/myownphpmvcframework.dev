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
    private $_db;

    public function __construct()
    {
        $this->_db = new Database();
    }
} 