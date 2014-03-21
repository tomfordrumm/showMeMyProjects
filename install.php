<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 22.03.14
 * Time: 0:34
 */

session_start();
$_SESSION['run_install'] = 1;
/**
 * Error reporting
 */
error_reporting(E_ALL);

ini_set('display_errors', 1);

define('ROOT_PATH',dirname(__FILE__).'/');
require_once(ROOT_PATH.'code/Core.php');

if (Core::getParams() != ''){
    $install = new Installer();
    $install->start();

}

include_once(ROOT_PATH.'design/install/page.phtml');