<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

return array(
    'controllers\\CalculatorController' => array(
        'model'     => 'models\\CalculatorModel',
    ),
    'models\\UsersModel'                => array(
        'db'        => 'Database',
    ),
    'controllers\\UsersController'      => array(
        'model'     => 'models\\UsersModel',
    ),
    'controllers\\LoginController'      => array(
        'model'     => 'models\\UsersModel',
    ),
);