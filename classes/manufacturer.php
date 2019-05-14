<?php
/*
 * 
 * ManuFacturer Database Class
 * ---------------------------
 * for Add,delete, update or  select Manufacturer data from the 
 * Database
 * 
 *  */
include_once "config.PHP";

class manufacturer {

    private $dbh = null;
    private $tableName = "manufacturer";

    function __construct() {
        $this->dbh = MysqliDb::getInstance();
    }
    //To add New Manufacturer Details
    function add($arr) {
        $mfg_name = $arr['mfg_name'];
        $this->dbh->where('mfg_name', $mfg_name);
        $row = $this->dbh->get($this->tableName);
        //$row = $this->dbh->table($this->tableName)->where('mfg_name',$mfg_name)-> get()->toArray();
        $count = sizeof($row);
        if ($count > 0) {
            return 0;
        } else {
            $lastId = $this->dbh->insert($this->tableName, $arr);
            return $lastId;
        }
    }
    //Get all the Manufacturer Data
    function getAllData() {
        $row = $this->dbh->get($this->tableName);
        //$row = $this->dbh->table($this->tableName)->get()->toArray();
        $count = sizeof($row);
        if ($count > 0) {
            return $row;
        } else {
            return 0;
        }
    }
    //to delete any Manufacturer data by id
    function delete($id = 0) {
        
    }
    //to update any manufacturer
    function update($id = 0, $arr = '') {
        
    }

}

?>
