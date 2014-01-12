<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     Affero GNU Public License - http://en.wikipedia.org/wiki/Affero_General_Public_License
 */

namespace xen\eventSystem;

/**
 * Class Handler
 *
 * @package xen\eventSystem
 * @author  Ismael Trascastro itrascastro@xenframework.com
 *
 *          A Handler object is the VB handler function concept
 *          a function can handle events (>=1)1
 */
abstract class Handler
{
    private $_events;

    public function __construct(array $_events = array())
    {
        $this->_events = $_events;
    }

    public function addHandles(array $events)
    {
        $this->_events = array_merge($this->_events, $events);
    }

    public function handles($event)
    {
        return in_array($event, $this->_events);
    }

    public abstract function handle($params);
}