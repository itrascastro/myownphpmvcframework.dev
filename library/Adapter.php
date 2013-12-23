<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 23/12/13
 * Time: 17:44
 */

namespace library;

class Adapter extends \PDO
{
    function __construct($dbConfig)
    {
        switch (strtolower($dbConfig->driver)) {
            case 'mysql': //MySQL
                $dsn = 'mysql:host=' . $dbConfig->hostname;
                if (isset($dbConfig->port)) {
                    $dsn .= ';port=' . $dbConfig->port;
                }
                $dsn .= ';dbname=' . $dbConfig->dbname;
                parent::__construct($dsn, $dbConfig->username, $dbConfig->password);
                break;
            case 'pgsql': //PostgreSQL
                $dsn = 'pgsql:host=' . $dbConfig->hostname;
                if (isset($dbConfig->port)) {
                    $dsn .= ';port=' . $dbConfig->port;
                }
                $dsn .= ';dbname=' . $dbConfig->dbname;
                $dsn .= ';user=' . $dbConfig->username;
                $dsn .= ';password=' . $dbConfig->password;
                parent::__construct($dsn);
                break;
        }
    }
}