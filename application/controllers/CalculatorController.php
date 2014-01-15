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
use xen\mvc\view\Phtml;
use xen\mvc\view\ViewScript;

class CalculatorController extends Controller
{
    public function init()
    {
        $this->_model = new CalculatorModel();
    }

    public function indexAction()
    {
        $this->_layout->title           = 'Calculator - 4 basic operations';
        $this->_layout->description     = 'Calculator Index';

        $this->render();
    }

    public function addAction()
    {
        $this->_layout->title           = 'Add Form';
        $this->_layout->description     = 'Add 2 numbers';

        $this->render();
    }

    public function addDoAction()
    {
        $this->_model->setOp1($_POST['op1']);
        $this->_model->setOp2($_POST['op2']);
        $this->_model->add();

        $this->_layout->title           = 'Add Result';
        $this->_layout->description     = 'Add Result';
        $this->_view->op1               = $this->_model->getOp1();
        $this->_view->op2               = $this->_model->getOp2();
        $this->_view->result            = $this->_model->getResult();

        $this->render();
    }

    public function subtractAction()
    {
        $this->_layout->title           = 'Subtract Form';
        $this->_layout->description     = 'Subtract 2 numbers';

        $this->render();
    }

    public function subtractDoAction()
    {
        $this->_model->setOp1($_POST['op1']);
        $this->_model->setOp2($_POST['op2']);
        $this->_model->subtract();

        $this->_layout->title           = 'Subtract Result';
        $this->_layout->description     = 'Subtract Result';
        $this->_view->op1               = $this->_model->getOp1();
        $this->_view->op2               = $this->_model->getOp2();
        $this->_view->result            = $this->_model->getResult();

        $this->render();
    }
} 