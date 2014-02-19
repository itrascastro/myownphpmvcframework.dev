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
        $user = $this->_model->login($this->_request->post('email'), $this->_request->post('password'));

        if ($user != null) {

            $this->_response->setSession('user', $user);

            $this->_layout->title       = 'Login success';
            $this->_layout->description = 'Restricted Area';
            $this->_view->msg           = 'Success';

            $this->render();

        } else {

            $this->_redirect('login', 'index');

        }
    }

} 