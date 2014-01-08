<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:38
 */

/*
 * All paths will be relative to project directory
 */
chdir(dirname(__DIR__));

require str_replace('/', DIRECTORY_SEPARATOR, 'vendor/xen/application/Application.php');

$app = new \xen\application\Application(\xen\application\Application::DEVELOPMENT);
$app->bootstrap();
$app->run();