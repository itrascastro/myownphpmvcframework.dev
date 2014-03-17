<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * This file is part of the xenframework package.
 *
 * (c) Ismael Trascastro <itrascastro@xenframework.com>
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     MIT License - http://en.wikipedia.org/wiki/MIT_License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace xen\application;

class Router
{
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

    private function _cleanUrl($url)
    {
        $this->_url = ($url === null) ? '/' : '/' . filter_var($url, FILTER_SANITIZE_URL);
    }

    public function route($role)
    {
        $found = false;

        foreach ($this->_parseRoutes() as $route => $value) {

            if (preg_match('!^' . $route . '$!', $this->_url, $results) == 1) {

                $found = true;

                if (in_array($role, $value['allow'])) {

                    $params = array();

                    foreach ($value['params'] as $param) {

                        $params[$param] = $results[$param];
                    }

                    $this->_controller  = ucfirst($value['controller']);
                    $this->_action      = $value['action'];
                    $this->_params      = $params;

                } else {

                    $this->_controller  = 'Error';
                    $this->_action      = 'forbidden';
                    $this->_params      = array(
                        'controller'    => $value['controller'],
                        'action'        => $value['action'],
                    );
                }

                break;
            }
        }

        if (!$found) {

            $this->_controller  = 'Error';
            $this->_action      = 'pageNotFound';
            $this->_params      = array('url' => $this->_url);
        }
    }

    public function toUrl($controller, $action, $params = array())
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

        return false;
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
                'allow'         => $routeValue['allow'],
            );

            $pattern = str_replace('!', '\!', $tmpPattern);
            $routes[$pattern] = $parsedRoute;
        }

        return $routes;
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