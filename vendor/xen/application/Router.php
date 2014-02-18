<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace xen\application;

class Router
{
    const URL_CONTROLLER    = 'Controller';
    const URL_ACTION        = 'Action';

    private $_url;
    private $_routes;
    private $_controller;
    private $_action;
    private $_params;

    public function __construct($_url)
    {
        $this->_cleanUrl($_url);
        $this->_routes = require str_replace('/', DIRECTORY_SEPARATOR, 'application/configs/routes.php');
        $this->_parseRoutes();
        $this->_params = array();
    }

    public function route()
    {
        if ($this->_url != '') {

            if ($customRoute = $this->_customRoute()) {

                $this->_controller  = ucfirst($customRoute['controller']);
                $this->_action      = $customRoute['action'];
                $this->_params      = $customRoute['params'];

            } else {

                $this->_defaultRoute();
            }
        } else {

            $this->_controller  = 'Index';
            $this->_action      = 'index';
        }
    }

    public function toUrl($controller, $action, $params = array())
    {
        if ($route = $this->_getRoute($controller, $action, $params)) {

            return $route;

        } else {

            return '/' . $controller . '/' . $action . '/' . $this->_paramsToString($params);
        }
    }

    private function _getRoute($controller, $action, $params = array())
    {
        foreach ($this->_routes as $route => $value) {

            if (array_key_exists('constraints', $value)) {

                $constraints = $value['constraints'];

            } else {

                $constraints = array();
            }

            if ($value['controller'] == $controller &&
                $value['action'] == $action &&
                $this->_hasParams($route, $params, $constraints)
            ) {
                return $this->_setParamsToRoute($route, $params);
            }
        }
    }

    private function _setParamsToRoute($route, $params)
    {
        foreach ($params as $key => $value) {

            $route = preg_replace('/\{' . $key . '\}/', $value, $route);
        }

        return $route;
    }

    private function _hasParams($route, $params, $constraints)
    {
        foreach ($params as $key => $value) {

            if (strpos(preg_replace('/\s+/', '', $route), '{' . $key . '}') === false ||
               (
                   array_key_exists($key, $constraints) &&
                   preg_match('!' . preg_replace('/\s+/', '', $constraints[$key]) . '!', $value) == 0
               )
            )
                return false;
        }

        return true;
    }

    private function _paramsToString($params)
    {
        $first = true;
        $str = '';

        foreach ($params as $param => $value)
        {
            if (!$first) {

                $str .= '/';

            } else {

                $first = false;
            }

            $str .= $param . '/' . $value;
        }

        if ($str != '') {

            $str .= '/';
        }

        return $str;
    }

    private function _customRoute()
    {
        foreach ($this->_parseRoutes() as $route => $value) {

            if (preg_match('!' . $route . '!', $this->_url, $results) == 1) {

                $params = array();

                foreach ($value['params'] as $param) {

                    $params[$param] = $results[$param];
                }

                return array(
                    'controller'    => $value['controller'],
                    'action'        => $value['action'],
                    'params'        => $params,
                );
            }
        }

        return false;
    }

    private function _parseRoutes()
    {
        $routes = array();

        foreach ($this->_routes as $route => $routeValue) {

            //remove white spaces
            $pattern = preg_replace('/\s+/', '', $route);

            $paramPosEnd = 0;
            $params = array();

            //we need a copy because we are modifying it in every iteration
            $tmpPattern = $pattern;

            while ($pos = strpos($pattern, '{', $paramPosEnd)) {

                $paramPosEnd = strpos($pattern, '}', $pos);
                $paramName = substr($pattern, $pos + 1, $paramPosEnd - $pos - 1);

                if (isset($routeValue['constraints'][$paramName])) {

                    $constraint = '(?P<' . $paramName . '>' . $routeValue['constraints'][$paramName] . ')';
                    $constraint = preg_replace('/\s+/', '', $constraint);
                    $tmpPattern = str_replace('{' . $paramName . '}', $constraint, $tmpPattern);

                } else {

                    $constraint = '(?P<' . $paramName . '>\S+)';
                    $tmpPattern = str_replace('{' . $paramName . '}', $constraint, $tmpPattern);
                }

                $params[] = $paramName;
            }

            $parsedRoute = array(
                'controller'    => $routeValue['controller'],
                'action'        => $routeValue['action'],
                'params'        => $params,
            );

            $pattern = ltrim(str_replace('!', '\!', $tmpPattern), '/');
            $routes[$pattern] = $parsedRoute;
        }

        return $routes;
    }

    private function _defaultRoute()
    {
        $url = explode('/', $this->_url);

        $controller = $this->_getName($url[0], self::URL_CONTROLLER);
        $file = str_replace('/', DIRECTORY_SEPARATOR, 'application/controllers/') . $controller . 'Controller.php';

        if (file_exists($file)) {

            $this->_controller = $controller;

            if (isset($url[1])) {

                $action = $this->_getName($url[1], self::URL_ACTION);

                if (method_exists('controllers\\' . $this->_controller . 'Controller', $action . 'Action')) {

                    $this->_action = $action;

                    if (isset($url[2])) {

                        $this->_params = $this->_getParamsFromUrl($url);
                    }
                } else {

                    $this->_404();
                }
            } else {

                $this->_action = 'index';
            }
        } else {

            $this->_404();
        }
    }

    private function _404()
    {
        $this->_controller = 'Error';
        $this->_action = 'pageNotFound';
        $this->_params = array('url' => $this->_url);
    }

    private function _cleanUrl($url)
    {
        $this->_url = ($url === null) ? '' : rtrim(filter_var($url, FILTER_SANITIZE_URL), '/');
    }

    /*
     * $type = {'Controller' | 'Action'}
     */
    private function _getName($url, $type)
    {
        $words = explode('-', $url);
        $name = '';

        if ($type == 'Action') {

            $first = true;

        } else {

            $first = false;
        }

        foreach ($words as $word)
        {
            if (!$first) {

                $name .= ucfirst($word);

            } else {

                $name .= $word;
                $first = false;
            }
        }

        return $name;
    }

    private function _getParamsFromUrl($url)
    {
        $params = array();
        $i = 2;

        while (isset($url[$i])) {

            if (isset($url[$i+1])) {

                $params[$url[$i]] = $url[$i+1];

            } else {

                $params[$url[$i]] = null;
            }

            $i += 2;
        }

        return $params;
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

    /**
     * @param mixed $routes
     */
    public function setRoutes($routes)
    {
        $this->_routes = $routes;
    }

    /**
     * @return mixed
     */
    public function getRoutes()
    {
        return $this->_routes;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->_params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

}