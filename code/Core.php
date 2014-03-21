<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 18.03.14
 * Time: 23:53
 */

//include(ROOT_PATH.'code/Controller.php');
include(ROOT_PATH.'code/core/Connection.php');

function getDefaultPaths(){
    return array(
        'code/',
        'code/core',
        'code/controllers'
    );
}

/**
 * Load all classes automaticly
 * @param $name string
 */
function __autoload($name){
    if (strpos($name,'_')){
        $dirArray = explode('_',$name);
        $k = count($dirArray);
        $modulePath = '/';
        $i =0;
        foreach ($dirArray as $dir){
            $i++;
            $modulePath.= $dir;
            if ($i == $k){
                $modulePath.='.php';
            }
        }
    } else {
        $modulePath = '/'.$name.'.php';
    }

    foreach (getDefaultPaths() as $defPath){
        if (file_exists(ROOT_PATH.$defPath.$modulePath)){
            include(ROOT_PATH.$defPath.$modulePath);
        }
    }

}

new Core;
class Core
{

    /**
     * Select controller action, and template
     */
    function __construct(){

        if (self::isInstalled()){
            $_SESSION['template'] = "page/main.phtml";
            $controller = new Controller();
            $contName = $controller->getController();
            if ($contName != 'home'){
//            include(ROOT_PATH.'code/controllers/'.$contName.'Controller.php');
                $contName.='Controller';
                $contModel = new $contName;
                $action = $controller->getAction();
                $contModel->$action();
//            include(ROOT_PATH.'design/page/success.phtml');
            } else {
                $contModel = new IndexController();
                $contModel->indexAction();

                $_SESSION['template'] = "design/page/main.phtml";
//            include(ROOT_PATH.'design/page/main.phtml');
            }
        } elseif (!isset($_SESSION['run_install'])) {

//            var_dump($_SERVER); exit;
            header('Refresh: 0; url=http://'.$_SERVER['HTTP_HOST'].'/install.php');
        }
    }

    /**
     * Initialize PDO connection
     * @return Connection
     */
    static function getConnection(){
        return new Connection();
    }

    public static function isInstalled(){
        if (file_exists(ROOT_PATH.'config.php')){
            return true;
        } else {
            return false;
        }
    }

    static function getParam($name){
        $data = '';
        if($_GET and isset($_GET[$name])){
            $data = $_GET[$name];
        } elseif($_POST and isset($_POST[$name])) {
            $data = $_POST[$name];
        }

        return $data;
    }

    static function getParams(){
        $data = '';
        if($_GET){
            $data = $_GET;
        } elseif($_POST) {
            $data = $_POST;
        }
        return $data;
    }

    static function getRootCatalogPath(){
        $explodetpath = explode('/',ROOT_PATH);
        foreach ($explodetpath as $item){
            if ($item != ""){
                $foldername = $item;
            }
        }

        $megaroot = str_replace($foldername.'/','',ROOT_PATH);
        return $megaroot;
    }

    /**
     * Get Current Url
     * @return string
     */
    static function getCurrentURL()
    {
        $currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $currentURL .= $_SERVER["SERVER_NAME"];

        if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
        {
            $currentURL .= ":".$_SERVER["SERVER_PORT"];
        }

        $currentURL .= $_SERVER["REQUEST_URI"];
        return $currentURL;
    }
}