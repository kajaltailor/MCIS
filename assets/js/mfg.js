//loading data in data table dynamically
function loadTableData() {
    $.ajax('jscript.php', {
        processing: true,
        serverSide: true,
        type: 'POST', // http method
        data: {action: 'show_mfg_json'}, // data to submit
        dataType: 'json',
        success: function (data, status, xhr) {
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
                    {"data": "mfg_id", "title": 'Manufacturer ID'},
                    {"data": "mfg_name", "title": "Manufacturer Name"},
                    {"data": "created", "title": "Created On", }
                    //,{"data":"action" ,"title" :""}
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


//////on document on load event
$(document).ready(function () {
    loadTableData();
    //manufcature form validation
    $('.validate-mfg-form').on('submit', function () {
        var mfgname = $('#mfg_name').val();
        if (mfgname != "") {
            $("#stage").load('jscript.php', {"mfg_name": mfgname, "action": 'add_mfg'}, function (responseTxt, statusTxt, xhr) {
                if (statusTxt == "success") {
                    $('#mfg_name').val('');
                    loadTableData();
                }
                if (statusTxt == "error")
                    console.write("Error: " + xhr.status + ": " + xhr.statusText);
            });
        }
        return false;
    });
});


        