<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 16/12/13
 * Time: 19:34
 */

namespace library;


class Database extends \PDO
{
    public function __construct()
    {
        parent::__construct('mysql:host=localhost;dbname=someDatabase', $username, $password);
    }
} 