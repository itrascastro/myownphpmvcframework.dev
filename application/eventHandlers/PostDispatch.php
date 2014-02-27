<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace eventHandlers;


use xen\eventSystem\Handler;

class PostDispatch extends Handler
{

    public function handle($params)
    {
        echo 'Hi from PostDispath';
    }
}