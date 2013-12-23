<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 19/12/13
 * Time: 10:05
 */

namespace application\views\helpers;


use library\helpers\ViewHelper;

class CalculatorMenuHelper extends ViewHelper
{
    public function __construct($params=array())
    {
        $this->_html = '
            <ul class="list-inline">
                <li><a href="/calculator/add/">Add</a></li>
                <li><a href="/calculator/subtract/">Subtract</a></li>
                <li><a href="/calculator/multiply/">Multiply</a></li>
                <li><a href="/calculator/divide/">Divide</a></li>
            </ul>
        ';
    }
} 