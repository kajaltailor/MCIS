<?php
/*
 * 
 * Model Database Class
 * ---------------------------
 * for Add,delete, update or  select ModelCar  data from the 
 * Database. It also extends the functionality of Manufacturer Class
 * it will also  get Manufacturer details from manufacturer Model
 *  */
include_once "config.PHP";
include_once "classes/manufacturer.php";
class model extends manufacturer {

    private $dbh = null;
    private $tableName = 'model';
    private $mfg = null;

    function __construct() {
        $this->dbh = MysqliDb::getInstance();
        $this->tableName = "model";
        $this->mfg = new manufacturer;
    }
    //Add data for new model car 
    function add($arr) {
        // print_r($arr);
        $reg_no = $arr['reg_no'];
        if ($reg_no != "") {
            $this->dbh->where("reg_no", $reg_no);
            $row = $this->dbh->get($this->tableName);
            //$row=$this->dbh->table($this->tableName)->where("reg_no",$reg_no)->get()->toArray();
            $count = sizeof($row);
            if ($count > 0) {
                return 0;
            } else {
                $lastId = $this->dbh->insert($this->tableName, $arr);
                return $lastId;
            }
        }
    }
    //function to get all Manufacturer Data from manufacturer Table
    function getAllMfgData() {
        $arr = $this->mfg->getAllData();
        return $arr;
    }
    //Function to get all the Modeland Manufacturer Data combined in one result
    function getAllData($arr = '') {
        $this->dbh->join("manufacturer mfg", "m.mfg_id=mfg.mfg_id", "LEFT");
        if ($arr != "" && is_object($arr)) {
            $mfg_id = $arr->mfg_id;
            $model_name = $arr->model_name;

            $this->dbh->Where("m.mfg_id", $mfg_id);
            $this->dbh->Where("m.model_name", $model_name);
        }
        $row = $this->dbh->get("model m", null, "*");
        // echo $this->dbh->getLastQuery();
        $count = sizeof($row);
        if ($count > 0) {
            return $row;
        } else {
            return 0;
        }
    }
    //To get the Total Inventory Details from model and manufacturer class
    function getInventory() {

//$results = $db->get ('users');
        $this->dbh->join("manufacturer mfg", "m.mfg_id=mfg.mfg_id", "LEFT");
        $this->dbh->groupBy("m.model_name,mfg.mfg_id");
        $row = $this->dbh->where('sold', "N")->get("model m", null, "m.mfg_id,m.model_id,trim(mfg_name) mfg_name,trim(m.model_name) model_name,count(model_id) model_count");
        //echo $this->dbh->getLastQuery();
        //print_r($row);
        $count = sizeof($row);
        if ($count > 0) {

            return $row;
        } else {
            return 0;
        }
    }
    //When car is sold, it wll update the Sold status to Y
    function SoldStatusUpdate($model_id) {
        $this->dbh->where('model_id', $model_id)->update('model', ['sold' => 'Y', "modified" => date('Y-m-d H:i:s')]);

        if ($this->dbh->getLastErrno() === 0)
            return 1;
        else
            echo 'Update failed. Error: ' . $this->dbh->getLastError();
    }
    //function to get Model and manufacture details as string
    function getModelManufacturer($model_id) {
        $this->dbh->join("manufacturer mfg", "m.mfg_id=mfg.mfg_id", "LEFT");
        $row = $this->dbh->where('model_id', $model_id)->getOne("model m", null, "m.mfg_id,m.model_id,trim(mfg_name) mfg_name,trim(m.model_name) model_name, m.mfg_year,m.reg_no,m.model_color");
        if ($row != null) {
            return $row['mfg_name'] . " " . $row['model_name'] . " [color:" . $row['model_color'] . ",Reg. No.: " . $row['reg_no'] . ",Mfg. Year : " . $row['mfg_year'] . "]";
        } else {
            return "No Car Model";
        }
    }

}

?>
