<?php

include("classes/model.php");
$m = new Model;
$arr = $m->getAllData();


die();

include "classes/manufacturer.php";
$m = new Manufacturer;
$arr = $m->getAllData();
print_r($arr);
$data = array();
if ($arr != 0) {
    $j = 0;
    foreach ($arr as $a) {
        $data[$j]['mfg_id'] = $a['mfg_id'];
        $data[$j]['mfg_name'] = $a['mfg_name'];
        $data[$j]['created'] = $a['created'];
        $j++;
    }
}
echo json_encode($data);
?>