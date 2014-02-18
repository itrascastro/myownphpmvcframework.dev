<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace xen\application;


class Request 
{
    private $_url;
    private $_controller;
    private $_action;
    private $_get;
    private $_post;
    private $_cookie;
    private $_files;
    private $_server;
    private $_env;

    function __construct($_get, $_post, $_cookie, $_files, $_server, $_env)
    {
        $this->_get     = $_get;
        $this->_post    = $_post;
        $this->_cookie  = $_cookie;
        $this->_files   = $_files;
        $this->_server  = $_server;
        $this->_env     = $_env;
    }

    public static function createFromGlobals()
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER, $_ENV);
    }

    public function get($name)
    {
        return (isset($_GET[$name])) ? $_GET[$name] : null;
    }

    public function post($name)
    {
        return (isset($_POST[$name])) ? $_POST[$name] : null;
    }

    public function cookie($name)
    {
        return (isset($_COOKIE[$name])) ? $_COOKIE[$name] : null;
    }

    public function getHeaders()
    {
        if (!function_exists('getallheaders')) {

            foreach ($_SERVER as $name => $value) {

                if (strtolower(substr($name, 0, 5)) == 'http_') {

                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }

            return $headers;

        } else {

            return getallheaders();
        }
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function isPut()
    {
        return $_SERVER['REQUEST_METHOD'] == 'PUT';
    }

    public function isDelete()
    {
        return $_SERVER['REQUEST_METHOD'] == 'DELETE';
    }

    public function isHead()
    {
        return $_SERVER['REQUEST_METHOD'] == 'HEAD';
    }

    public function isOptions()
    {
        return $_SERVER['REQUEST_METHOD'] == 'OPTIONS';
    }

    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function hasFiles()
    {
        return !empty($_FILES);
    }

    public function getFiles()
    {
        return $_FILES;
    }

    public function server($key)
    {
        return (isset($_SERVER[$key])) ? $_SERVER[$key] : null;
    }

    public function env($key)
    {
        return (isset($_ENV[$key])) ? $_ENV[$key] : null;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($_url)
    {
        $this->_url = $_url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->_action = $action;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->_controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->_controller;
    }

}