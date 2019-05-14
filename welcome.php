<?php
/*
 * 
 * Welcome Page to Show all the the Cars details in Inventory 
 * 
 */
include_once("includes/header.php");
include_once "classes/model.php";
$m = new model;
$res = $m->getAllData();
?>
<div class="container">
    <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
        <span class="login100-form-title p-b-32">
            View All Cars
        </span>
        <BR><BR>
        <span class="error" id="errorMsg" style="display:none;"></span>
        <span class="success" id="successMsg"  style="display:none;"></span>
        <?php
        // print_r($res);
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
                                <?php echo $r['note']; ?><BR><BR>
                                <?php if ($r['sold'] == "Y") {  ?>
                                    <img class="media-object" width="100" height="100" src="assets/images/sold.png" alt="...">
                                <?php } ?>
                            </div>
                        </div>              
                    </div>
                </div>
            </div>
        </li>
        <?php  }  ?>
        </ul>
        <?php  } else {
                  echo "No record found";
               } ?>
    </div>
</div>
<?php
include("includes/footer.php");
?>