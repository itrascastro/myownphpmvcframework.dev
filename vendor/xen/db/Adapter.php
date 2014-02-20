<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 23/12/13
 * Time: 17:44
 */

namespace xen\db;

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
                if (isset($dbConfig->charset)) {
                    $dsn .= ';charset=' . $dbConfig->charset;
                }
                try {
                    parent::__construct($dsn, $dbConfig->username, $dbConfig->password);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    die();
                }
                break;
            case 'pgsql': //PostgreSQL
                $dsn = 'pgsql:host=' . $dbConfig->hostname;
                if (isset($dbConfig->port)) {
                    $dsn .= ';port=' . $dbConfig->port;
                }
                $dsn .= ';dbname=' . $dbConfig->dbname;
                $dsn .= ';user=' . $dbConfig->username;
                $dsn .= ';password=' . $dbConfig->password;
                try {
                    parent::__construct($dsn);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    die();
                }
                break;
            case 'dblib': //MS Sql
                $dsn = 'dblib:host=' . $dbConfig->hostname;
                if (isset($dbConfig->port)) {
                    $dsn .= ',' . $dbConfig->port;
                }
                $dsn .= ';Database=' . $dbConfig->dbname;
                $dsn .= ',' . $dbConfig->username;
                $dsn .= ',' . $dbConfig->password;
                try {
                    parent::__construct($dsn);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    die();
                }
                break;
        }
    }
}