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
        $layoutVariables = array(
            'description'   => 'Calculator - 4 basic operations',
            'title'         => 'Calculator Index',
        );
        $this->_layout->setVariables($layoutVariables);
        $content = new Phtml($this->_viewPath, 'index', $this->_viewHelperBroker);
        $this->_layout->addPartials(
            array(
                'content' => $content,
            ));
        $this->_view->render();
    }

    public function addAction()
    {
        $layoutVariables = array(
            'description'   => 'Add 2 numbers',
            'title'         => 'Add Form',
        );
        $this->_layout->setVariables($layoutVariables);
        $content = new Phtml($this->_viewPath, 'add', $this->_viewHelperBroker);
        $this->_layout->addPartials(
            array(
                 'content' => $content,
            )
        );
        $this->_view->render();
    }

    public function addDoAction()
    {
        $this->_model->setOp1($_POST['op1']);
        $this->_model->setOp2($_POST['op2']);
        $this->_model->add();

        $layoutVariables = array(
            'description'   => 'Add Result',
            'title'         => 'Add Result',
        );
        $this->_layout->setVariables($layoutVariables);
        $viewVariables = array(
            'op1'       => $this->_model->getOp1(),
            'op2'       => $this->_model->getOp2(),
            'result'    => $this->_model->getResult(),
        );
        $content = new Phtml($this->_viewPath, 'addDo', $this->_viewHelperBroker, $viewVariables);
        $this->_layout->addPartials(
            array(
                 'content' => $content,
            )
        );
        $this->_view->render();
    }

    public function subtractAction()
    {
        $layoutVariables = array(
            'title'         => 'Subtract Form',
            'description'   => 'Subtract 2 numbers',
        );
        $this->_layout->setVariables($layoutVariables);
        $content = new Phtml($this->_viewPath,'subtract', $this->_viewHelperBroker);
        $this->_layout->addPartials(
            array(
                 'content' => $content,
            )
        );
        $this->_view->render();
    }

    public function subtractDoAction()
    {
        $this->_model->setOp1($_POST['op1']);
        $this->_model->setOp2($_POST['op2']);
        $this->_model->subtract();

        $layoutVariables = array(
            'description'   => 'Subtract Result',
            'title'         => 'Subtract Result',
        );
        $this->_layout->setVariables($layoutVariables);
        $viewVariables = array(
            'op1'       => $this->_model->getOp1(),
            'op2'       => $this->_model->getOp2(),
            'result'    => $this->_model->getResult(),
        );
        $content = new Phtml($this->_viewPath, 'subtractDo', $this->_viewHelperBroker, $viewVariables);
        $this->_layout->addPartials(
            array(
                 'content' => $content,
            )
        );
        $this->_view->render();
    }
} 