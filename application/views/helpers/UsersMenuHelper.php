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
        $this->_html = '
            <ul class="list-inline">
                <li><a href="/users/index/">Users</a></li>
                <li><a href="/users/add/">Add new user</a></li>
                <li><a href="/users/user-list/">Delete user</a></li>
                <li><a href="/users/user-list/">Update user</a></li>
                <li><a href="/users/user-list/">User list</a></li>
            </ul>
        ';
    }
}