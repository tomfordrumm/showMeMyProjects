<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 18.03.14
 * Time: 23:37
 */
if (version_compare(phpversion(), '5.2.0', '<')===true) {
    echo  '<div style="font:12px/1.35em arial, helvetica, sans-serif;">
<div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
<h3 style="margin:0; font-size:1.7em; font-weight:normal; text-transform:none; text-align:left; color:#2f2f2f;">
Whoops, it looks like you have an invalid PHP version.</h3></div><p>Magento supports PHP 5.2.0 or newer.
<a href="http://www.magentocommerce.com/install" target="">Find out</a> how to install</a>
 Magento using PHP-CGI as a work-around.</p></div>';
    exit;
}
session_start();
/**
 * Error reporting
 */
error_reporting(E_ALL);

ini_set('display_errors', 1);

define('ROOT_PATH',dirname(__FILE__).'/');
if (file_exists(ROOT_PATH.'config.php')){
    include_once(ROOT_PATH.'config.php');
}
require_once(ROOT_PATH.'code/Core.php');


require_once(ROOT_PATH.'design/page.phtml');
