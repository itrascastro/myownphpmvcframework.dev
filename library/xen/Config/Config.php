<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 21/12/13
 * Time: 00:08
 */

/*
 * Converts an array into an object
 */

namespace xen\config;


class Config 
{
    public function __construct($array)
    {
        foreach($array as $key => $value)
        {
            if (!is_array($value)) {
                $this->$key = $value;
            } else {
                $this->$key = new Config($value);
            }
        }
    }

}