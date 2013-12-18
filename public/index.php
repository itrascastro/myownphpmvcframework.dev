<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 09:38
 */

defined('APPLICATION_PATH') ||
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/..'));

require_once '../library/Index.php';

$index = new \library\Index();
$index->run();