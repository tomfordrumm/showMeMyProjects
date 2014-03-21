<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 19.03.14
 * Time: 1:33
 */
class IndexController extends Controller {

    public function indexAction(){
        $connection = Core::getConnection();
        $sites = $connection->getAllSites();
        $_SESSION['sites'] = $sites;

    }
}