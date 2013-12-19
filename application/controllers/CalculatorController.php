<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 16/12/13
 * Time: 17:53
 */

namespace application\controllers;


use application\models\CalculatorModel;
use library\Controller;
use library\View;

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
        $this->_model = new CalculatorModel($_POST['op1'], $_POST['op2']);
        $this->_model->add();

        $title = 'AddDo';
        $description = 'Add two numbers';
        $layout = 'default';
        $content = 'calculator/addDo';
        $viewVariables = array(
            'op1' => $_POST['op1'],
            'op2' => $_POST['op2'],
            'result' => $this->_model->getResult()
        );
        $this->_view = new View($title, $description, $layout, $content, $viewVariables);
        return $this->_view->render();
    }
} 