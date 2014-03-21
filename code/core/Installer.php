<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 22.03.14
 * Time: 0:59
 */
class Installer {

    public function start(){

        $sampleFile = ROOT_PATH.'config.php.sample';
//        $fp = fopen($sampleFile,'r');
        $sample = file_get_contents($sampleFile);
        $data = Core::getParams();
        $data['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/';
        $config = $this->parse($sample,$data);

//        var_dump($config); exit;
        $fileName = ROOT_PATH.'config.php';
        file_put_contents($fileName,$config);
        chmod($fileName,0777);
        $this->createDB($data);
        header('Refresh: 0; url=http://'.$_SERVER['HTTP_HOST'].'/');

    }

    function parse($file,$params){
        foreach ($params as $key => $param){
            $file = str_replace('{'.$key.'}',"'".$param."'",$file);
        }

        return $file;
    }

    public function createDB($data){
        try {$connection = new PDO($data['driver'].":host=".$data['host'].';dbname='.$data['db_name'],$data['username'],$data['password']);
            $connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $query ="
            DROP TABLE IF EXISTS `sites`;

            CREATE TABLE `sites` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `path` varchar(255) DEFAULT NULL,
              `url` varchar(255) DEFAULT NULL,
              `description` text,
              `name` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            ";
            $connection->exec($query);

            $query= "
            DROP TABLE IF EXISTS `not_sites_directory`;

            CREATE TABLE `not_sites_directory` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `path` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            ";

            $connection->exec($query);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}