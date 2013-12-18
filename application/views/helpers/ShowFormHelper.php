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
    private $_html;

    function __construct($params)
    {
        $this->_html = '<form action="' . $params['action'] . '" id="' . $params['id'] . '" method="post">
                        <input type="number" id="op1" name="op1"><br>
                        <input type="number" id="op2" name="op2"><br>
                        <input type="submit" value="' . $params['buttonValue'] . '">
                        </form>';
    }

    public function show()
    {
        return $this->_html;
    }
} 