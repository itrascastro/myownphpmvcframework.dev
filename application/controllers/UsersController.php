<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 21/12/13
 * Time: 22:44
 */

namespace controllers;

use models\UsersModel;
use xen\mvc\Controller;

class UsersController extends Controller
{
    public function init()
    {
        $this->_model = new UsersModel($this->_bootstrap->getResource('Database'));
    }

    public function indexAction()
    {
        $this->_layout->title           = 'Users Controller';
        $this->_layout->description     = 'Controller for users management';

        return $this->render();
    }

    public function addAction()
    {
        $this->_layout->title           = 'Add a new user';
        $this->_layout->description     = 'Insert a new user';

        return $this->render();
    }

    public function addDoAction()
    {
        $this->_model->add($_POST['email'], $_POST['password']);
        return $this->_forward('list');
    }

    public function removeAction()
    {
        $this->_model->remove($this->_params['id']);
        return $this->_redirect('users', 'list');
    }

    public function updateAction()
    {
        $user = $this->_model->getUserById($this->_params['id']);

        $this->_layout->title           = 'Update an user';
        $this->_layout->description     = 'Change user';

        $this->_view->user              = $user;

        return $this->render();
    }

    public function updateDoAction()
    {
        $this->_model->update($_POST['id'], $_POST['email'], $_POST['password']);
        return $this->_redirect('users', 'list');
    }

    public function listAction()
    {
        $users = $this->_model->all();

        $this->_layout->title           = 'User List';
        $this->_layout->description     = 'Show all users';

        $this->_view->users = $users;

        return $this->render();
    }
}