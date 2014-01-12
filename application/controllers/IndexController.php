<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 12/12/13
 * Time: 16:45
 */

namespace controllers;

use eventHandlers\Bootstrap_Load;
use views\helpers\ShowFormHelper;
use xen\config\Ini;
use xen\eventSystem\Event;
use xen\eventSystem\EventSystem;
use xen\mvc\Controller;
use xen\mvc\view\Phtml;

class IndexController extends Controller
{
    public function init()
    {

//        $event = new Event('Bootstrap_Load', array('msg' => 'event from Bootstrap'));
//        $eventSystem = $this->_bootstrap->getResource('EventSystem');
//        $eventSystem->raiseEvent($event);

    }

    public function indexAction()
    {
        $layout = $this->_view->getLayout();
        $layoutVariables = array(
            'title'         => 'xenFramework.com',
            'description'   => 'Create your own Php MVC Framework from scratch',
        );
        $layout->addVariables($layoutVariables);
        $viewHelperBroker = $this->_bootstrap->getResource('ViewHelperBroker');
        $content = new Phtml($this->_viewPath, 'index', $viewHelperBroker);
        $layout->addPartials(
            array(
                'content' => $content,
            )
        );
        return $this->_view->render();
    }
} 