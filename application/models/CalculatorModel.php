<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 19/12/13
 * Time: 11:03
 */

namespace application\models;


class CalculatorModel 
{
    private $_op1;
    private $_op2;
    private $_result;

    public function __construct($_op1, $_op2)
    {
        $this->_op1 = $_op1;
        $this->_op2 = $_op2;
    }

    public function add()
    {
        $this->_result = $this->_op1 + $this->_op2;
    }

    public function subtract()
    {
        $this->_result = $this->_op1 - $this->_op2;
    }

    public function multiply()
    {
        $this->_result = $this->_op1 * $this->_op2;
    }

    public function divide()
    {
        $this->_result = (int) ($this->_op1 / $this->_op2);
    }

    public function getResult()
    {
        return $this->_result;
    }
} 