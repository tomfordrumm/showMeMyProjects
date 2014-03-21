<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 19.03.14
 * Time: 1:29
 */
class Connection {

    public $connection;

    /**
     * Create PDO connection
     */
    function __construct(){
        $this->connection = new PDO(DB_DRIVER.":host=".DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
    }


    function checkError(){
        $error_array = $this->connection->errorInfo();

        if ($this->connection->errorCode() != 0000)

            echo "SQL error: " . $error_array[2] . '<br />';
    }

    /**
     * Get all sites information
     * @return array
     */
    function getAllSites(){

        if ($this->connection) {
            $rows = $this->connection->query("SELECT * FROM `sites`");

            $this->checkError();

            $result = $rows->fetchAll();

            return $result;
        }
    }

    /**
     * Add new row to database
     * @param $data array
     */
    function createNewSite($data){
//        var_dump($data); exit;
        if ($this->connection){
            $this->connection->beginTransaction();
            $stmt = $this->connection->prepare("INSERT INTO sites(name,url,description,path) VALUES (?,?,?,?)");

            try {

                $stmt->execute(array($data['name'],$data['url'],$data['description'],$data['path']));
                $this->connection->commit();
            } catch (PDOException $e) {
                $this->connection->rollBack();
            }

            $this->checkError();

        }
    }

    function getSitesDirectory(){
        if ($this->connection) {
            $rows = $this->connection->query("SELECT path FROM sites");
            $this ->checkError();

            $out = array();
            foreach ($rows->fetchAll() as $row){
                $out[]= $row['path'];
            }
            return $out;
        }
    }

    function delete($tablename,$id){
        if ($this->connection){
            try {
                $quer = "DELETE FROM ".$tablename." WHERE id = '".$id."';";
                $this->connection->exec($quer);
//                $del = $this->connection->prepare("DELETE FROM ? WHERE id =?");
//                $del->execute(array($tablename, $id));
                $this->checkError();
                return true;
            } catch (Exception $e) {
                $_SESSION['sql_error'] = $e->getMessage();
                return false;
            }
        }
    }
}