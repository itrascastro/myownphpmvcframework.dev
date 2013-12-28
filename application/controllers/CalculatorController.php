<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 16/12/13
 * Time: 17:53
 */

namespace application\controllers;


use application\models\CalculatorModel;
use xen\Controller;
use xen\View;

class CalculatorController extends Controller
{
    public function init()
    {

    }

    public function indexAction()
    {
        $title = 'Calculator';
        $description = 'Add, Subtract, Multiply, Divide';
        $layout = 'default';
        $content = 'calculator/index';
        $viewVariables = array();
        $this->_view = new View($title, $description, $layout, $content, $viewVariables);
        return $this->_view->render();
    }

    public function addAction()
    {
        $title = 'Add';
        $description = 'Add two numbers';
        $layout = 'default';
        $content = 'calculator/add';
        $viewVariables = array();
        $this->_view = new View($title, $description, $layout, $content, $viewVariables);
        return $this->_view->render();
    }

    public function addDoAction()
    {
        $this->_model->setOp1($_POST['op1']);
        $this->_model->setOp2($_POST['op2']);
        $this->_model->add();

        $title = 'AddDo';
        $description = 'Add two numbers';
        $layout = 'default';
        $content = 'calculator/addDo';
        $viewVariables = array(
            'op1'    => $_POST['op1'],
            'op2'    => $_POST['op2'],
            'result' => $this->_model->getResult()
        );
        $this->_view = new View($title, $description, $layout, $content, $viewVariables);
        return $this->_view->render();
    }
} 