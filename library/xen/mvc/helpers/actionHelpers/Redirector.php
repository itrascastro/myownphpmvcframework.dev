<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 17/12/13
 * Time: 11:22
 */

namespace xen\mvc\helpers\actionHelpers;

class Redirector
{
    public function __construct()
    {

    }

    public function redirect($controller, $action)
    {
        header('location:' . '/' . $controller . '/' . $action . '/');
        exit;
    }
} 