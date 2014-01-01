<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 16/12/13
 * Time: 17:53
 */

namespace controllers;

use models\CalculatorModel;
use xen\mvc\Controller;
use xen\mvc\view\ViewScript;

class CalculatorController extends Controller
{
    public function init()
    {
        $this->_model = new CalculatorModel();
    }

    public function indexAction()
    {
        $layout = $this->_view->getLayout();
        $layoutVariables = array(
            'title'         => 'Calculator',
            'description'   => 'Add, Subtract, Multiply, Divide',
        );
        $layout->setVariables($layoutVariables);
        $viewScript = new ViewScript('calculator', 'index');
        $layout->setViewScript($viewScript);
        return $this->_view->render();
    }

    public function addAction()
    {
        $layout = $this->_view->getLayout();
        $layoutVariables = array(
            'title'         => 'Add',
            'description'   => 'Add two numbers',
        );
        $layout->setVariables($layoutVariables);
        $viewScript = new ViewScript('calculator', 'add');
        $layout->setViewScript($viewScript);
        return $this->_view->render();
    }

    public function addDoAction()
    {
        $this->_model->setOp1($_POST['op1']);
        $this->_model->setOp2($_POST['op2']);
        $this->_model->add();

        $layout = $this->_view->getLayout();
        $layoutVariables = array(
            'title'         => 'AddDo',
            'description'   => 'Add two numbers',
        );
        $layout->setVariables($layoutVariables);
        $viewScript = new ViewScript('calculator', 'addDo');
        $viewScriptVariables = array(
            'op1'    => $_POST['op1'],
            'op2'    => $_POST['op2'],
            'result' => $this->_model->getResult(),
        );
        $viewScript->setVariables($viewScriptVariables);
        $layout->setViewScript($viewScript);
        return $this->_view->render();
    }
} 