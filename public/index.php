<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:38
 */

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

require 'library/xen/Application.php';

$app = new \xen\Application(\xen\Application::DEVELOPMENT);
$app->bootstrap();
$app->run();