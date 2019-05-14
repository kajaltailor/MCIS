<?php
/*
 * View Car Model Popup window Page
 *  on View Button click on Inventory page
 * 
 */
require_once("classes/manufacturer.php");
require_once("classes/model.php");
//print_r($_POST);    
$data = $_POST['data'];
$action = $_POST['action'];
if (isset($_POST['data']) && $_POST['data'] != "") {
    $arr = json_decode($data);
    $m = new model;
    $res = $m->getAllData($arr);
    if (count($res) > 0) {
        ?>
        <ul class="list-group">
            <?php
            $defimg = "assets/images/noimage.png";
            foreach ($res as $r) {
                $pict1 = $r['pict1'] != "" ? $r['pict1'] : $defimg;
                $pict2 = $r['pict2'] != "" ? $r['pict2'] : $defimg;
                ?>
                <li class="list-group-item">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="media">
                                <div class="media-left">
                                    <img class="media-object" width="200" height="200" src="<?php echo $pict1; ?>" alt="...">
                                    <img class="media-object" width="200" height="200" src="<?php echo $pict2; ?>" alt="...">
                                </div>
                                <div class="media-body">
                                    <div class="media-rightpane">
                                        <h4 class="media-heading"><?php echo $r['mfg_name'] . " " . $r['model_name'] ?></h4><BR>
                                        <span><B>Color :</b><?php echo $r['model_color']; ?></span><BR>
                                        <span><B>Manufacturer Year :</b><?php echo $r['mfg_year']; ?></span><br>
                                        <span><B>Registration No. :</b><?php echo $r['reg_no']; ?></span><BR>
                                        <span><B>Color :</b><?php echo $r['model_color']; ?></span><BR>
                                        <span><B>Note:</b><BR>
                                            <?php echo $r['note']; ?><BR>
                                            <BR>
                                            <button type='button' name='btnsold[]' class='btn btn-success btn-xs btn-sold' id="<?php echo $r['model_id']; ?>" >Sold</button>         
                                    </div>
                                </div>              
                            </div>
                        </div>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
    }
    ?>
    <?php
} else {
    echo "No record found";
}
?>