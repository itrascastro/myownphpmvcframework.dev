<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

/**
 * Param name is the string between the brackets
 *
 * Constraints are optional. You can use RegEx
 */
return array(
    '/user/add/name/{name}/email/{email}/{age}/' => array(
        'controller'        => 'users',
        'action'            => 'add',
        'constraints'       => array(
            'email' => 'a | b',
            'age'   => '\d+',
        ),
    ),
    '/user-info/id/{id}/' => array(
        'controller'        => 'users',
        'action'            => 'show',
        'constraints'       => array(
            'id' => '\d{2}+',
        ),
    ),
    '/calculator/add/' => array(
        'controller'        => 'calculator',
        'action'            => 'add',
    ),
    '/calculatorSum/op1.{op1}.op2.{op2}' => array(
        'controller'        => 'calculator',
        'action'            => 'add',
        'constraints'       => array(
            'op1' => '\d',
            'op2' => '\d',
        ),
    ),
    'article-{id}-{year}.php' => array(
        'controller'        => 'blog',
        'action'            => 'show',
    ),
);
