<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace xen\mvc\view;

/**
 * Class ViewScript
 *
 * @package xen\mvc\view
 * @author  Ismael Trascastro itrascastro@xenframework.com
 */
class ViewScript extends File
{
    public function __construct($_folder, $_name, $_variables = array())
    {
        parent::__construct($_folder, $_name, $_variables);
        $this->_basePath = str_replace('/', DIRECTORY_SEPARATOR, 'application/views/scripts');
    }
}