<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 14/12/13
 * Time: 17:07
 */

namespace application\views\helpers;


class ShowFormHelper 
{
    private $_action;
    private $_id;
    private $_buttonValue;
    private $_html;

    function __construct($_action, $_id, $_buttonValue)
    {
        $this->_action = $_action;
        $this->_buttonValue = $_buttonValue;
        $this->_id = $_id;
        $this->_html = '<form action="' . $this->_action . '" id="' . $this->_id . '" method="post">
                        <input type="number" id="op1" name="op1" /><br />
                        <input type="number" id="op2" name="op2" /><br />
                        <input type="submit" value="' . $this->_buttonValue . '" />
                        </form>';
    }

    public function show()
    {
        return $this->_html;
    }
} 