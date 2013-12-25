<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 21/12/13
 * Time: 22:44
 */

namespace application\controllers;


use application\models\UsersModel;
use library\Controller;
use library\View;

class UsersController extends Controller
{

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function indexAction()
    {
        $title = 'Users Controller';
        $description = 'Controller for users management';
        $layout = 'default';
        $content = 'users/index';
        $this->_view = new View($title, $description, $layout, $content);
        return $this->_view->render();
    }

    public function addAction()
    {
        $title = 'Add a new user';
        $description = 'Insert a new user';
        $layout = 'default';
        $content = 'users/add';
        $this->_view = new View($title, $description, $layout, $content);
        return $this->_view->render();
    }

    public function addDoAction()
    {
    }
}