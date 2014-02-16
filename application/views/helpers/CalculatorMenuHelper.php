<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 19/12/13
 * Time: 10:05
 */

namespace views\helpers;

use xen\mvc\helpers\ViewHelper;

class CalculatorMenuHelper extends ViewHelper
{
    public function __construct($params=array())
    {
        $router = $params['router'];

        $this->_html = '
            <ul class="list-inline">
                <li><a href="' . $router->toUrl('calculator', 'add') . '">Add</a></li>
                <li><a href="' . $router->toUrl('calculator', 'subtract') . '">Subtract</a></li>
                <li><a href="' . $router->toUrl('calculator', 'multiply') . '">Multiply</a></li>
                <li><a href="' . $router->toUrl('calculator', 'divide') . '">Divide</a></li>
            </ul>
        ';
    }
} 