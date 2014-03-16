<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 21/12/13
 * Time: 22:47
 */

namespace views\helpers;

use xen\mvc\helpers\ViewHelper;

class UsersMenuHelper extends ViewHelper
{

    function __construct($params = array())
    {
        $router = $params['router'];

        $this->_html = '
            <ul class="list-inline">
                <li><a href="' . $router->toUrl('users', 'index') . '">Users</a></li>
                <li><a href="' . $router->toUrl('users', 'add') . '">Add new user</a></li>
                <li><a href="' . $router->toUrl('users', 'list') . '">Delete user</a></li>
                <li><a href="' . $router->toUrl('users', 'list') . '">Update user</a></li>
                <li><a href="' . $router->toUrl('users', 'list') . '">User list</a></li>
            </ul>
        ';
    }
}