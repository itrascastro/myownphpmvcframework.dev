<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 17/12/13
 * Time: 12:08
 */

namespace controllers\helpers;


class CustomRedirector 
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