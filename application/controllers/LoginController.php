<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 21/12/13
 * Time: 19:01
 */

namespace controllers;

use models\UsersModel;
use xen\mvc\Controller;

class LoginController extends Controller
{
    public function init()
    {
    }

    public function indexAction()
    {
        $this->_layout->title           = 'Login Form';
        $this->_layout->description     = 'Introduce your credentials';

        $this->render();
    }

    public function doLoginAction()
    {
        $user = $this->_model->login($_POST['email'], $_POST['password']);

        if ($user != null) {

            $_SESSION['user'] = $user;
            $this->_layout->title       = 'Login success';
            $this->_layout->description = 'Restricted Area';
            $this->_view->msg           = 'Success';

            $this->render();

        } else {

            $this->_redirect('login', 'index');

        }
    }

} 