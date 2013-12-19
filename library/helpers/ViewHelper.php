<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 19/12/13
 * Time: 10:08
 */

namespace library\helpers;


abstract class ViewHelper
{
    protected $_html;

    abstract function __construct($params);

    public function show()
    {
        return $this->_html;
    }
}