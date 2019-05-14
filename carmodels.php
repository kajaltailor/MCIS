<?php include "includes/header.php"; ?>
<?php
include "classes/model.php";

function populatemfgselect() {
    $m = new model;
    $arr = $m->getAllMfgData();
    $sel = '<select class="input100" name="mfg_id">
                 <option>Select Manufacturer</option>';
    if (count($arr) > 0) {
        foreach ($arr as $a) {
            $sel.='<option value="' . $a['mfg_id'] . '">' . $a['mfg_name'] . '</option>';
        }
    }
    $sel.='</select>';
    echo $sel;
}
?>
<div class="container">
    <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
<?php //include_once('addeditmodel.php');  ?>
        <form class="login100-form validate-form flex-sb flex-w validate-car-model-form" id="frmcar" method="post" enctype="multipart/form-data" action="">
            <div id = "stage">
                <span class="error" id="errorMsg" style="display:none;"></span>
                <span class="success" id="successMsg"  style="display:none;"></span>
            </div><BR><BR>
            <span class="login100-form-title p-b-32">
                Add Car model
            </span>
            <table width="100%">
                <tr>
                    <td width="50%">
                        <span class="txt1 p-b-11">
                            Car Model Name
                        </span>
                        <div class="wrap-input100 validate-input m-b-36" data-validate = "Car Model Name is required">
                            <input class="input100" type="text" name="model_name" id="model_name" >
                            <span class="focus-input100"></span>
                        </div>
                    </td>
                    <td width="50%">
                        <span class="txt1 p-b-11">
                            Select Manufacturer
                        </span>
                        <div class="wrap-input100 validate-input m-b-36" data-validate = " Manufacturer is required">
<?php populatemfgselect(); ?>

                            <span class="focus-input100"></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <span class="txt1 p-b-11">
                            Car Model Color
                        </span>
                        <div class="wrap-input100 validate-input m-b-36" data-validate = "Car Model Color is required">
                            <input class="input100" type="text" name="model_color" id="model_color" >
                            <span class ="focus-input100"></span>
                        </div>
                    </td>
                    <td width="50%">
                        <span class="txt1 p-b-11">
                            Manufacturing Year
                        </span> (Only Numeric) 
                        <div class="wrap-input100 validate-input m-b-36" data-validate = "Manufacturing Year is required(numer)">
                            <input class="input100 numeric" type="text" name="mfg_year" id="mfg_year" >
                            <span class="focus-input100"></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <span class="txt1 p-b-11">
                            Registration Number
                        </span>
                        <div class="wrap-input100 validate-input m-b-36" data-validate = "Registration Number is required">
                            <input class="input100" type="text" name="reg_no" id="reg_no" >
                            <span class ="focus-input100"></span>
                        </div>
                    </td>
                    <td width="50%">
                        <span class="txt1 p-b-11">
                            Notes  
                        </span>
                        <div class="wrap-input100 m-b-36">
                            <input class="input100" type="text" name="note" id="note" >
                            <span class="focus-input100"></span>
                        </div>
                    </td>

                </tr>
                <tr>
                    <td width="50%">
                        <span class="txt1 p-b-11">
                            Picture 1
                        </span>
                        <div class="wrap-input100 validate-input m-b-36" data-validate = "Please choose any once Picture">
                            <input class="input100" type="file" name="pict1" id="pict1" >
                            <span class ="focus-input100"></span>
                        </div>
                        <div>
                            <div id="image_preview1"></div>
                            <span>
                                <input type="hidden" name="image1" id="image1" value="">
                            <img id="previewing1" width=200 height=200 src="assets/images/noimage.png" /></div>
                        </span> 
                    </td>
                    <td width="50%">
                        <span class="txt1 p-b-11">
                            Picture 2
                        </span>
                        <div class="wrap-input100 m-b-36">
                            <input class="input100" type="file" name="pict2" id="pict2" >
                            <span class="focus-input100"></span>
                        </div>
                        <div id="image_preview2"></div>
                        <span>
                            <input type="hidden" name="image2" id="image2" value="">
                            <img id="previewing2" width=200 height=200 src="assets/images/noimage.png" />
                        </span>

                    </td>

                </tr>
            </table>

            <BR><BR><BR><BR><BR><BR><BR>
            <input type="hidden" name="action" id="action" value="add_car_model">
            <div class="container-login100-form-btn">
                        <!--<input  class="login100-form-btn"  type="button" name="btnadd" id="btnadd" value="ADD">-->
                <button class="login100-form-btn" id="btnadd" name="btnadd">ADD</button>
            </div>
        </form>
    </div>
    <p></p>
    <BR><BR>
    <BR>
    <div id="tableDiv"> </div>
</div>
<?php include "includes/footer.php" ?>
<script>
    function loadModelCarData() {
        $.ajax('jscript.php', {
            processing: true,
            serverSide: true,
            type: 'POST', // http method
            data: {action: 'show_modelcar_json'}, // data to submit
            dataType: 'json',
            success: function (data, status, xhr) {
                //  alert(JSON.stringify(data));  
                $("#tableDiv").empty();
                //$("#tableDiv").append(JSON.stringify(data));
                $("#tableDiv").append("<table id=tableId class='table table-borderless table-striped table-hover table-sm w-100'></table>");
                var oTable = $('#tableId').DataTable({
                    "processing": true,
                    "data": data,
                    select: {
                        style: 'os',
                        selector: 'td:first-child'
                    },
                    "columns": [
                        {"data": "model_id", "title": 'ID'},
                        {"data": "mfg_name", "title": 'Manufacturer'},
                        {"data": "model_name", "title": "Model Name"},
                        {"data": "model_color", "title": "Model Color", },
                        {"data": "mfg_year", "title": "Manufacture Year"},
                        {"data": "reg_no", "title": "Registration NO", },
                        {"data": "sold", "title": "Sold"}
                    ]
                });

            },
            error: function (jqXhr, textStatus, errorMessage) {
                $('p').append('Error' + errorMessage);
            },
            afterSend: function () {
                $('#tableId').dataTable().reload();
            }
        });
    }
    $(document).ready(function () {

        $("#mfg_year").keyup(function (e)
        {
            if (/\D/g.test(this.value))
            {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D{/g, '');
            }
        });


        loadModelCarData();
        function uploadpicjs(obj, imgobj, divobj, hidobj) {
            if ($(obj).val() != "") {
                var data = new FormData($("#frmcar"));

                var file_data = $(obj).prop("files")[0];   // Getting the properties of file from file field
                var form_data = new FormData();                  // Creating object of FormData class
                form_data.append("file", file_data);              // Appending parameter named file with properties of file_field to form_data
                form_data.append("action", 'uploadPic');
                $.ajax({
                    url: "jscript.php",
                    //dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data, // Setting the data attribute of ajax with file_data
                    type: 'post',
                    success: function (data) {
                        var result = $.parseJSON(data);
                        $(divobj).empty();
                        if (result.error == 1) {
                            $(imgobj).attr('src', result.filename);
                            $(divobj).append(result.msg);
                            $(hidobj).val('');
                        }
                        else {
                            $(imgobj).attr('src', result.filename);
                            $(divobj).append(result.msg);
                            $(hidobj).val(result.filename);
                        }
                    }
                });
            }
        }
        $("#pict1").change(function () {
            uploadpicjs(this, $('#previewing1'), $('#image_preview1'), $('#image1'));
        });
        $("#pict2").change(function () {
            uploadpicjs(this, $('#previewing2'), $('#image_preview2'), $('#image2'));
        });
        $('form.validate-car-model-form').on('submit', function () {
            $.ajax({
                url: "jscript.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    //alert(data);
                    $("#stage").html(data);
                    loadModelCarData();
                }

            });

            return false;
        });
    });
</script>