<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

/**
 * IoC
 *
 * In this array you can put your own dependencies
 *
 * Each entry is a service with his dependencies declared in an array
 *
 * A service has to have one setter method for each dependency
 *
 * You can use default dependencies as: {Database} which are resolved in xen\Bootstrap
 * The rest of services and dependencies must have their NAMESPACE as a part of their names
 *
 * array(
 *      'service1' => array(
 *          'dependencySetter1' => 'dependency1',
 *          'dependencySetter2' => 'dependency2',
 *          ...
 *          'dependencySetterN' => 'dependencyN',
 *      ),
 *      'service2' => array(
 *          'dependencySetter1' => 'dependency1',
 *          'dependencySetter2' => 'dependency2',
 *          ...
 *          'dependencySetterN' => 'dependencyN',
 *      ),
 *      ...
 *      'serviceN' => array(
 *          'dependencySetter1' => 'dependency1',
 *          'dependencySetter2' => 'dependency2',
 *          ...
 *          'dependencySetterN' => 'dependencyN',
 *      ),
 * )
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