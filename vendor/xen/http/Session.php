<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace xen\http;


class Session 
{
    public function __construct()
    {

    }

    public function start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {

            session_start();
        }
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function get($name)
    {
        return (isset($_SESSION[$name])) ? $_SESSION[$name] : null;
    }

    public function delete($name)
    {
        unset($_SESSION[$name]);
    }

    public function destroy()
    {
        session_destroy();
    }
} 