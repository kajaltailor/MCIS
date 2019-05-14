<?php 
/*
 * inventory.php
 * View all the Inventory page for all the car models and manufacturer
 * 
 * show table grid for total count
 */
require_once("includes/header.php"); ?>
<div class="container">
    <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
        <span class="login100-form-title p-b-32">
            View Inventory
        </span>
        <BR><BR>
        <span class="error" id="errorMsg" style="display:none;"></span>
        <span class="success" id="successMsg"  style="display:none;"></span>    
               
        <!-- Modal -->
        <div class="modal fade" id="Modal-large-demo" tabindex="-1" role="dialog" aria-labelledby="Modal-large-demo-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">                
                        <h5 class="modal-title" id="Modal-large-demo-label">View Inventory Details</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!---------------------------->

        <BR><BR>
        <BR>
        <div id="tableDiv"></div>
    </div>
</div>

<?php require_once("includes/footer.php"); ?>
<script>

    function loadInventoryData() {
        $.ajax('jscript.php', {
            processing: true,
            serverSide: true,
            type: 'POST', // http method
            data: {action: 'show_inventory_json'}, // data to submit
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
                        {"data": "sr_no", "title": "sr no"},
                        {"data": "mfg_name", "title": 'Manufacturer'},
                        {"data": "model_name", "title": "Model Name"},
                        {"data": "model_count", "title": "Model Count"},
                        {"data": "action", "title": "View Details"}
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
        loadInventoryData();
        $("#tableDiv").on("click", "button.view-mfg", function () {
            // alert('you clicked me!' + this.id);
            $('.modal-body').load('viewcarmodels.php', {"data": this.id, "action": 'view-inventory-details'},
            function (response, status) {
                $('#Modal-large-demo').modal({show: true, width: '500px', height: "500px"});
                if (status == "success") {
                    //alert(status);
                    $('button.btn-sold').click(function () {
                        //alert("click on sold" +this.id);
                        $.ajax('jscript.php', {
                            processing: true,
                            serverSide: true,
                            type: 'POST', // http method
                            data: {action: 'car_sold', model_id: this.id}, // data to submit
                            //dataType: 'json',
                            success: function (data, status, xhr) {
                                //alert(data);  
                                $("#Modal-large-demo").modal("hide");
                                loadInventoryData();
                                if (status == "success") {
                                    $("#successMsg").html(data).show();
                                }
                            },
                            error: function (jqXhr, textStatus, errorMessage) {
                                $('p').append('Error' + errorMessage);
                            }
                        });
                    });
                }
            });
        });
    });
</script>