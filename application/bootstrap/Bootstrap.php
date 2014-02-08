<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 21/12/13
 * Time: 23:17
 */

namespace bootstrap;

use xen\application\bootstrap\BootstrapBase;
use xen\mvc\view\Phtml;

class Bootstrap extends BootstrapBase
{
//    protected function _initLayoutPath()
//    {
//        return str_replace('/', DIRECTORY_SEPARATOR, 'application/layouts/default');
//    }

    /**
     *
     * @return Phtml
     *
     */
    protected function _initLayout()
    {
        $layout     = $this->getResource('Layout');
        $config     = $this->getResource('Config');

        $header = new Phtml($this->getResource('LayoutPath') . DIRECTORY_SEPARATOR . 'header.phtml');
        $header->charset = (string) $config->charset;

        if (isset($_SESSION['user'])) {
            $layout->loggedUser = $_SESSION['user']->getEmail();
        } else {
            $layout->loggedUser = 'Login';
        }

        $partials   = array(
            'header' => $header,
            'footer' => new Phtml($this->getResource('LayoutPath') . DIRECTORY_SEPARATOR . 'footer.phtml'),
        );

        $layout->addPartials($partials);

        return $layout;
    }
}
