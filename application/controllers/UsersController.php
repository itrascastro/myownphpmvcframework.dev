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
use xen\mvc\view\Phtml;

class UsersController extends Controller
{
    public function init()
    {
        $this->_model = new UsersModel($this->_bootstrap->getResource('Database'));
    }

    public function indexAction()
    {
        $layoutVariables = array(
            'title'         => 'Users Controller',
            'description'   => 'Controller for users management',
        );
        $this->_layout->setVariables($layoutVariables);
        $content = new Phtml($this->_viewPath, 'index', $this->_viewHelperBroker);
        $this->_layout->addPartials(
            array(
                'content' => $content,
            )
        );
        return $this->_view->render();
    }

    public function addAction()
    {
        $title = 'Add a new user';
        $layoutVariables = array(
            'title'         => $title,
            'description'   => 'Insert a new user',
        );
        $this->_layout->setVariables($layoutVariables);
        $viewVariables = array(
            'title' => $title,
        );
        $content = new Phtml($this->_viewPath, 'add', $this->_viewHelperBroker, $viewVariables);
        $this->_layout->addPartials(
            array(
                'content' => $content,
            )
        );
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
        $layoutVariables = array(
            'title'         => $title,
            'description'   => 'Change user',
        );
        $this->_layout->setVariables($layoutVariables);
        $viewVariables = array(
            'title'     => $title,
            'user'      => $user,
        );
        $content = new Phtml($this->_viewPath, 'update', $this->_viewHelperBroker, $viewVariables);
        $this->_layout->addPartials(
            array(
                'content' => $content,
            )
        );
        return $this->_view->render();
    }

    public function updateDoAction()
    {
        $this->_model->update($_POST['id'], $_POST['email'], $_POST['password']);
        $this->userListAction();
    }

    public function listAction()
    {
        $users = $this->_model->all();

        $title = 'User List';
        $layoutVariables = array(
            'title'         => $title,
            'description'   => 'Show all users',
        );
        $this->_layout->setVariables($layoutVariables);
        $viewVariables = array(
            'title'     => $title,
            'users'     => $users,
        );
        $content = new Phtml($this->_viewPath, 'list', $this->_viewHelperBroker, $viewVariables);
        $this->_layout->addPartials(
            array(
                'content' => $content,
            )
        );
        return $this->_view->render();
    }
}