<?php
/**
 * xenFramework (http://xenframework.com/)
 *
 * This file is part of the xenframework package.
 *
 * (c) Ismael Trascastro <itrascastro@xenframework.com>
 *
 * @link        http://github.com/xenframework for the canonical source repository
 * @copyright   Copyright (c) xenFramework. (http://xenframework.com)
 * @license     MIT License - http://en.wikipedia.org/wiki/MIT_License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace controllers\frontend;

use xen\mvc\Controller;
use xen\mvc\view\Phtml;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->_layout->title           = 'xenFramework.com';
        $this->_layout->description     = 'Create your own Php MVC Framework from scratch';

        $partial = new Phtml('application/views/partials/example.phtml', 10);

        if ($content = $this->_cache->get('application/views/partials/example.phtml', 10))
        {
            $partial->setCachedContent($content);
        }
        else
        {
            // ...
            // more complex code
            // ...

            $partial->complexQuery = 'complex3';

            // ...
            // more complex code
            // ...
        }

        $this->_view->addPartial('example', $partial);

        $this->render();
    }
} 