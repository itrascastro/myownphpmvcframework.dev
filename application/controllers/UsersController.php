<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 21/12/13
 * Time: 22:44
 */

namespace controllers;

use models\UsersModel;
use xen\Controller;
use xen\View;

class UsersController extends Controller
{

    public function init()
    {
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
        $viewVariables = array(
            'title'     => $title
        );
        $this->_view = new View($title, $description, $layout, $content, $viewVariables);
        return $this->_view->render();
    }

    public function addDoAction()
    {
        $this->_model->add($_POST['email'], $_POST['password']);
        $this->userListAction();
    }

    public function removeAction()
    {
        $this->_model->remove($this->_params['id']);
        $this->userListAction();
    }

    public function updateAction()
    {
        $user = $this->_model->getUserById($this->_params['id']);
        $title = 'Update an user';
        $description = 'Change user';
        $layout = 'default';
        $content = 'users/update';
        $viewVariables = array(
            'title'     => $title,
            'user'      => $user
        );
        $this->_view = new View($title, $description, $layout, $content, $viewVariables);
        return $this->_view->render();
    }

    public function updateDoAction()
    {
        $this->_model->update($_POST['id'], $_POST['email'], $_POST['password']);
        $this->userListAction();
    }

    public function userListAction()
    {
        $users = $this->_model->all();
        $title = 'User List';
        $description = 'Show all users';
        $layout = 'default';
        $content = 'users/list';
        $viewVariables = array(
            'title'     => $title,
            'users'     => $users
        );
        $this->_view = new View($title, $description, $layout, $content, $viewVariables);
        return $this->_view->render();
    }
}