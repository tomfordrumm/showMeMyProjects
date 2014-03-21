<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 19.03.14
 * Time: 0:52
 */

class SitesController extends Controller {

    public $_badDir = array(
        '.',
        '..',
        '.DS_Store',
        '.DocumentRevisions-V100',
        '.Spotlight-V100',
        '.TemporaryItems',
        '.Trashes',
        '.apdisk',
        '.fseventsd'
    );

    /** Add action */
    public function addAction(){
        $data = $this->getParams();

        $connection = Core::getConnection();
        $connection->createNewSite($data);

        $this->successAction();
    }

    public function successAction(){

        $_SESSION['template'] = "design/page/success.phtml";
    }

    public function addSiteAction(){
        $_SESSION['template'] = "design/page/addsite.phtml";
    }

    public function softDelAction(){
        $id = Core::getParam('id');
        $connection = new Connection();
        $connection->delete('sites',$id);

        $this->successAction();
    }

    public function searchAction(){
        $megaroot = Core::getRootCatalogPath();
        $folders = scandir($megaroot);
        $out = array();
        foreach ($folders as $folder){
            if (!in_array($folder,$this->_badDir)){
                if (is_dir($megaroot.$folder.'/')){
                    $connection = new Connection();
//                    var_dump($connection->getSitesDirectory()); exit;
                    if (!in_array($megaroot.$folder.'/',$connection->getSitesDirectory())){
                        if ($megaroot.$folder.'/' != ROOT_PATH){
                            $out[] = $megaroot.$folder.'/';
                        }
                    }
                }
            }
        }

        $_SESSION['search_sites'] = $out;
        $_SESSION['template'] = 'design/page/search.phtml';
    }

}