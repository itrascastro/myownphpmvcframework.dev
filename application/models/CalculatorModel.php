<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 19/12/13
 * Time: 11:03
 */

namespace models;


use xen\Model;

class CalculatorModel extends Model
{
    private $_op1;
    private $_op2;
    private $_result;

    public function init()
    {
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

    /**
     * @param mixed $op1
     */
    public function setOp1($op1)
    {
        $this->_op1 = $op1;
    }

    /**
     * @return mixed
     */
    public function getOp1()
    {
        return $this->_op1;
    }

    /**
     * @param mixed $op2
     */
    public function setOp2($op2)
    {
        $this->_op2 = $op2;
    }

    /**
     * @return mixed
     */
    public function getOp2()
    {
        return $this->_op2;
    }

}