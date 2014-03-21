<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 19.03.14
 * Time: 0:40
 */
class Controller {

    public $home = 'index.php';

    /**
     * Valid URL
     */
    public function __construct(){
      if (!$parse = parse_url(Core::getCurrentURL())){
          echo 'Incorrect URL';
          die();
      }

    }

    /**
     * Parse url and find Controller Class Name
     * @return string
     */
    function getController(){
        $parse = parse_url(Core::getCurrentURL());
        if ($parse['path'] != '/'){
            $exp = explode('/',$parse['path']);
            $controller = ucfirst($exp[1]);
        } else {
            $controller = 'home';
        }
        return $controller;
    }

    /**
     * Parse url and find Controller Action Name
     * @return string
     */
    public function getAction(){
        $parse = parse_url(Core::getCurrentURL());
        if ($parse['path'] != '/'){
            $exp = explode('/',$parse['path']);
            $action = $exp[2].'Action';
        } else {
            $action = 'indexAction';
        }
        return $action;
    }


    /**
     * Get Any data to array
     * @return array
     */
    function getParams(){
        $data = array();
        if($_GET){
            $data = $_GET;
        } elseif($_POST) {
            $data = $_POST;
        }

        return $data;
    }
}