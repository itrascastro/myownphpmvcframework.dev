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
use xen\mvc\view\ViewScript;

class UsersController extends Controller
{
    public function init()
    {
        $this->_model = new UsersModel($this->_bootstrap->getResource('Database'));
    }

    public function indexAction()
    {
        $layout = $this->_view->getLayout();
        $layoutVariables = array(
            'title'         => 'Users Controller',
            'description'   => 'Controller for users management',
        );
        $layout->setVariables($layoutVariables);
        $viewScript = new ViewScript('users', 'index');
        $layout->setViewScript($viewScript);
        return $this->_view->render();
    }

    public function addAction()
    {
        $layout = $this->_view->getLayout();
        $title = 'Add a new user';
        $layoutVariables = array(
            'title'         => $title,
            'description'   => 'Insert a new user',
        );
        $layout->setVariables($layoutVariables);
        $viewScript = new ViewScript('users', 'add');
        $viewScriptVariables = array(
            'title' => $title,
        );
        $viewScript->setVariables($viewScriptVariables);
        $layout->setViewScript($viewScript);
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

        $layout = $this->_view->getLayout();
        $title = 'Update an user';
        $layoutVariables = array(
            'title'         => $title,
            'description'   => 'Change user',
        );
        $layout->setVariables($layoutVariables);
        $viewScript = new ViewScript('users', 'update');
        $viewScriptVariables = array(
            'title'     => $title,
            'user'      => $user,
        );
        $viewScript->setVariables($viewScriptVariables);
        $layout->setViewScript($viewScript);
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

        $layout = $this->_view->getLayout();
        $title = 'User List';
        $layoutVariables = array(
            'title'         => $title,
            'description'   => 'Show all users',
        );
        $layout->setVariables($layoutVariables);
        $viewScript = new ViewScript('users', 'list');
        $viewScriptVariables = array(
            'title'     => $title,
            'users'     => $users,
        );
        $viewScript->setVariables($viewScriptVariables);
        $layout->setViewScript($viewScript);
        return $this->_view->render();
    }
}