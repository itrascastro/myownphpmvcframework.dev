<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace xen\mvc;

use xen\application\Application;
use xen\mvc\view\Phtml;

abstract class ErrorControllerBase extends Controller
{
    public function init()
    {

    }
    
    public function indexAction()
    {
    }

    abstract function exceptionHandlerAction();
    abstract function pageNotFoundAction();

}