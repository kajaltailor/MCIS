<?php
/*
 * Jscript.php
 * intermediate file for every ajax call in application
 * which return table grid, add data, inventory data and view inventory page
 * very  important file for application
 * 
 */
include_once "classes/manufacturer.php";
include_once "classes/model.php";
if (isset($_POST['action']) && $_POST['action'] != "") {
    $action = $_POST['action'];
    switch ($action) {
        case "add_mfg":
            //Add Manufacturer code 
            $mfg_name = $_POST['mfg_name'];
            if (isset($mfg_name) && $mfg_name == "") {
                echo "<span class='error' id='errorMsg'>Please Enter Manufacturer Name</span>";
            } else {
                $arr = array('mfg_name' => $mfg_name, 'created' => date("Y-m-d H:i:s"));
                $m = new Manufacturer;
                $lastId = $m->add($arr);
                if (isset($lastId) && $lastId != 0) {
                    echo "<span class='success' id='successMsg'>Manufacturer Name Added Successfully</span>";
                } else {
                    echo "<span class='error' id='errorMsg'>Duplicate Manufacturer can not be added.</span>";
                }
            }
            break;

        case "show_mfg_json":  //Show Manufacturer page data grid by ajax
            $m = new Manufacturer;
            $arr = $m->getAllData();
            $data = array();
            if ($arr != 0) {
                $j = 0;
                foreach ($arr as $a) {
                    $data[$j]['mfg_id'] = $a['mfg_id'];
                    $data[$j]['mfg_name'] = $a['mfg_name'];
                    $data[$j]['created'] = $a['created'];
                    /*  $data[$j]['action']="<button type='button' name='update-mfg[]' class='btn btn-info btn-xs update-mfg' id=".$a['mfg_id']." >Update</button>
                      <button type='button' name='delete-mfg' class='btn btn-success btn-xs delete-mfg' id=".$a['mfg_id']." >Delete</button>";
                     */
                    $j++;
                }
            }
            echo json_encode($data);

            break;
        case "add_car_model": //add new Car Model
            //print_r($_POST);
            //print_r($_FILES);
            $arr['model_name'] = $_POST['model_name'];
            $arr['mfg_id'] = $_POST['mfg_id'];
            $arr['model_color'] = $_POST['model_color'];
            $arr['mfg_year'] = $_POST['mfg_year'];
            $arr['reg_no'] = $_POST['reg_no'];
            $arr['note'] = $_POST['note'];
            $arr['created'] = date("Y-m-d H:i:s");
            $validextensions = array("jpeg", "jpg", "png");

            if (isset($_FILES['pict1']) && $_FILES['pict1'] != "") {
                //pictureUpload($_FILES['pict1']);
                $arr['pict1'] = $_POST['image1'];
            }
            if (isset($_FILES['pict2']) && $_FILES['pict2'] != "") {
                //pictureUpload($_FILES['pict2']);
                $arr['pict2'] = $_POST['image2'];
            }
            $arr['created'] = date("Y-m-d H:i:s");
            $m = new model;
            $lastId = $m->add($arr);
            if (isset($lastId) && $lastId != 0) {
                echo "<span class='success' id='successMsg'>New Car Model Added Successfully</span>";
            } else {
                echo "<span class='error' id='errorMsg'>Can't add Duplicate Car Model, Duplicate Registration Id .</span>";
            }
            break;
        case "uploadPic":  // ajax call to upload pics of car
            // print_r($_POST);
            // print_r($_FILES);
            $arr = $_FILES['file'];
            $picarr = pictureUpload($arr);
            echo json_encode($picarr);
            break;
        case "show_mfg_json":// get all the manufacturerdata in Json format
            $m = new Manufacturer;
            $arr = $m->getAllData();
            $data = array();
            if ($arr != 0) {
                $j = 0;
                foreach ($arr as $a) {
                    $data[$j]['mfg_id'] = $a['mfg_id'];
                    $data[$j]['mfg_name'] = $a['mfg_name'];
                    $data[$j]['created'] = $a['created'];
                    /*  $data[$j]['action']="<button type='button' name='update-mfg[]' class='btn btn-info btn-xs update-mfg' id=".$a['mfg_id']." >Update</button>
                      <button type='button' name='delete-mfg' class='btn btn-success btn-xs delete-mfg' id=".$a['mfg_id']." >Delete</button>";
                     */
                    $j++;
                }
                echo json_encode($data);
            }
            break;
        case "show_modelcar_json": // all model car grid ajax population
            $m = new Model;
            $arr = $m->getAllData();
            $data = array();
            if ($arr != 0) {
                $j = 0;
                foreach ($arr as $a) {
                    $data [$j]['model_id'] = $a['model_id'];
                    $data[$j]['mfg_name'] = $a['mfg_name'];
                    $data[$j]['model_name'] = $a['model_name'];
                    $data[$j]['model_color'] = $a['model_color'];
                    $data[$j]['mfg_year'] = $a['mfg_year'];
                    $data[$j]['reg_no'] = $a['reg_no'];
                    $data[$j]['sold'] = $a['sold'];
                    /*  $data[$j]['action']="<button type='button' name='update-mfg[]' class='btn btn-info btn-xs update-mfg' id=".$a['mfg_id']." >Update</button>
                      <button type='button' name='delete-mfg' class='btn btn-success btn-xs delete-mfg' id=".$a['mfg_id']." >Delete</button>";
                     */
                    $j++;
                }
                echo json_encode($data);
            }
            break;
        case "show_inventory_json":  //Show inventory page json script ajax
            $m = new model;
            $row = $m->getInventory();
            if ($row != 0) {
                $i = 0;
                foreach ($row as $r) {
                    $row[$i]['sr_no'] = $i + 1;
                    $a['mfg_id'] = $r['mfg_id'];
                    $a['model_id'] = $r['model_id'];
                    $a['model_name'] = $r['model_name'];
                    $a['model_count'] = $r['model_count'];
                    $str = json_encode($a);
                    $row[$i]['action'] = "<button type='button' name='view[]' data-url='viewcarmodels.php' class='btn btn-info btn-xs view-mfg' id=" . $str . " >View</button>";
                    $i++;
                }
            }
            //print_r($row);
            echo json_encode($row);
            break;
        case "car_sold":  // Car soldstatus Update ajax jquery
            //print_r($_POST);
            $model_id = $_POST['model_id'];
            $m = new model;

            $stat = $m->SoldStatusUpdate($model_id);
            if ($stat == 1) {
                $mm = $m->getModelManufacturer($model_id);
                echo "$mm  car Sold";
            } else
                echo $stat;
            break;
    }
}
//Picture Upload function for both the pictures
function pictureUpload($arr) {
    $validextensions = array("jpeg", "jpg", "png");
    $filename = $arr['name'];
    $temporary = explode(".", $filename);
    $file_extension = end($temporary);
    $picarr = array();
    if ((($arr["type"] == "image/png") || ($arr["type"] == "image/jpg") || ($arr["type"] == "image/jpeg")) && ($arr["size"] < 500000)//Approx. 100kb files can be uploaded.
            && in_array($file_extension, $validextensions)) {
        if ($arr["error"] > 0) {
            $picarr['error'] = 1;
            $picarrp['msg'] = "Return Code: " . $arr["error"];
            $picarr['filename'] = '';
        } else {
            $msg = '';
            $msg.= "<span class='success'>Your File Uploaded Succesfully...!!</span>";
            /* $msg.= "<br/><b>File Name:</b> " . $arr["name"] . "<br>";
              $msg.= "<b>Type:</b> " . $arr["type"] . "<br>";
              $msg.= "<b>Size:</b> " . ($arr["size"] / 1024) . " kB<br>";
              $msg.= "<b>Temp file:</b> " . $arr["tmp_name"] . "<br>";
             */
            $filename = "upload/" . $filename;
            if (file_exists("upload/" . $arr["name"])) {
                // $msg.= $arr["name"] . " <b>already exists.</b> ";
            } else {
                move_uploaded_file($arr["tmp_name"], "./upload/" . $arr["name"]);
                $imgFullpath = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER["REQUEST_URI"] . '?') . '/' . "upload/" . $arr["name"];
                // $msg.= "<b>Stored in:</b><a href = '$imgFullpath' target='_blank'> " .$imgFullpath.'<a>';
                $filename = "upload/" . $filename;
                //return $filename;
            }
            $picarr['error'] = 0;
            $picarr['msg'] = $msg;
            $picarr['filename'] = $filename;
        }
    } else {
        $picarr['error'] = 0;
        $picarr['msg'] = "<span class='error'>***Invalid file Size or Type***<span>";
        $picarr['filename'] = 'assets/images/noimage.png';
    }
    return $picarr;
}

?>
