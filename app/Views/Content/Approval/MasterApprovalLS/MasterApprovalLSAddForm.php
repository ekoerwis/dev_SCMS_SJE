<style>
    .divbottom {
        margin-bottom: -8px;
    }

    .titleForm {
        color: white;
        font-weight: bold;
        display: inline-block;
        line-height: 30px;
    }

    .cekmerah {
        border: red;
        border-style: solid;
        border-width: 1px;
    }

    .table td {
        padding: 2px;
        vertical-align: middle;
    }

    .table th {
        padding: 5px;
        vertical-align: middle;
    }

    thead th {
        border: 1px solid white;
        background-color: #36A5B2;
        color: white;
        text-align: center;
        /* vertical-align: middle; */
    }

    .table thead th {
        vertical-align: middle;
    }

    .table tbody td {
        border-top: 0px;
        border-left: 0px;
        border-right: 0px;
        border-bottom: 1px solid lightgray;
    }

    .table tfoot th {
        border-width: 0px;
    }
</style>
<meta name="viewport" content="width=device-width,initial-scale=1.0">

    <!-- ini container utama -->
<div class="container col  pt-2 bg-white container_utama" style="<?php echo $tinggi_dg; ?>">

<!-- form di pindahkan ke dalam container utama karena detail mau menggunakan pilihan  upload atau manual -->
    <form id="fm" method="post" novalidate>

        <!-- ini container judul dan tombol -->
        <div class="col row headcls titleHeader">
            <div class="col  panel-title">
                Master Approval List
            </div>
            <div class="col-md-auto">
                <a href="#" id="saveBtnFm" class="easyui-linkbutton" iconCls="icon-save" onclick="saveData()" style="width:70px;height:28px;display:inline-block;">Save</a>
                <a href="#" id="AddNewBtnFm" class="easyui-linkbutton" iconCls="icon-add" onclick="addData()" style="width:70px;height:28px;display:none;">New</a>
                <a href="<?php echo site_url() . '/../Content/Approval/MasterApprovalLS';  ?>" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:70px;height:28px">Cancel</a>
            </div>
        </div>
        <!-- ini container form header-->
        <div id="containerHeaderForm"  class=" col-md-12 pt-3 contentHeader">

            <div class="row col-12 col-12 pb-2">
                <div class="col-12 col-md-6  ">
                    <div class="col-12 col-md-2 col-form-label">
                        Content
                    </div>

                    <div class="col-12 col-md-10 row">
                        <div class="col-12 col-md-12">
                            <input id="cb-content" name="IDCONTENT" class="" style="width:100%;" data-options="readonly:false, required:true" prompt="Content Logsheet">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row col-12 col-12 pb-2">
                <div class="col-12 col-md-6  ">
                    <div class="col-12 col-md-2 col-form-label">
                        Keterangan
                    </div>

                    <div class="col-12 col-md-10 row">
                        <div class="col-12 col-md-12">
                            <input id="tb-remarks" name="REMARKS" class="easyui-textbox" style="width:100%;" data-options="readonly:false, required:false" prompt="Keterangan">
                        </div>
                    </div>
                </div>
            </div>
            <!-- ---------------------- -->


        </div>

        <div class="col row headcls pt-2 titleDetail">
            <div class="col  panel-title" >
                Master Approval List Details
            </div>
        </div>

        <div id="containerDetailForm" class=" col-md-12 pt-3 pl-0 ">
            <table style="margin-top:5px;" class="col-md-12 table table-sm table-responsive tableScroll">
                <thead>
                    <tr>
                        <th rowspan=2 class="headadd" style="width:32px;height:35px;">add</th>
                        <th style="width:100px">Level</th>
                        <th style="width:250px">Role</th>
                    </tr>
                </thead>
                <tbody id="tbodyDetails">

                </tbody>
            </table>
        </div>
       

        <!-- </div> -->

    </form>

</div>



<script>


    $(document).ready(function() {

        $('#cb-content').combobox({
            url: "<?php echo site_url() . '/../Content/Approval/MasterApprovalLS/getCbContent'; ?>",
            required:true,
            loadMsg: 'Loading',
            panelHeight:'auto',
            valueField:'ID',
            textField:'JUDUL_MODULE',
            value:'',
            onSelect: function(record){
                

            }
        });

        addRowDetails(0, 0, 0);
       

    });

    
    var room = 1;

    function addRowDetails(length_data, key, val) {

        room++;
        var objTo = document.getElementById('tbodyDetails')
        var trAddDetails = document.createElement("tr");
        trAddDetails.setAttribute("class", "trDetails removeclass" + room);

        var HTMLDetails = '';

        if (length_data == 0 || key == 0) {
            HTMLDetails += '<td class="headadd-body" style="text-align: center;"> <div class="input-group-addon">  <a href="javascript:void(0)" class="btn btn-success addEMP" onclick="addRowDetails();"><i class="fas fa-plus"></i></a> </div> </td>';
        } else {
            HTMLDetails += '<td class="headadd-body" style="text-align: center;"> <div class="input-group-addon">  <a href="javascript:void(0)" class="btn btn-danger remove" onclick="remove_more(' + room + ');"><i class="fas fa-trash"></i></a> </div> </td>';
        }

        HTMLDetails += '<td><input style="width:100px" class="nb-level_details nb-level_details' + room + '" name="LEVEL_DETAILS[]" data-options="required:true,readonly:true"';
        HTMLDetails += '></td>';
        HTMLDetails += '<td><input style="width:250px" class="cb-role_details' + room + '" name="ROLE_DETAILS[]" data-options="required:true,readonly:false"';
        HTMLDetails += '></td>';
        trAddDetails.innerHTML = HTMLDetails;

        objTo.appendChild(trAddDetails);

        visualDetails(room);
    }


    function visualDetails(room = '') {

        $('.nb-level_details'+room).numberbox();

        $('.cb-role_details'+room).combobox({
            url: "<?php echo site_url() . '/../Content/Approval/MasterApprovalLS/getCbRole'; ?>",
            required:true,
            loadMsg: 'Loading',
            panelHeight:'auto',
            valueField:'ID_ROLE',
            textField:'JUDUL_ROLE',
            value:'',
            onSelect: function(record){
                

            }
        });

        generateLevel();
    }


    function remove_more(rid) {

        $('.removeclass' + rid).remove();
        generateLevel();

    }

    function generateLevel(){
        var fieldLevel = document.getElementsByClassName("nb-level_details");
        
        for (var i = 0; i < fieldLevel.length; i++) {
            $(fieldLevel[i]).numberbox('setValue', i+1);

        }

    }


</script>




<!-- save tambah data -->
<script type="text/javascript">

    function saveData() {

        // console.log('banyak data dataExcel :'+ Array.isArray(dataExcel));
        // alert(dataExcel);

        $('#fm').form('submit', {
            url: '<?php echo site_url() . '/../Content/Approval/MasterApprovalLS/saveData'; ?>',
            success: function(data_feedbacksave) {
                // tambahan substring karena aneh data hasil json ada script lain jadi json ga kebaca
                var feedbacksave = data_feedbacksave.substring(
                    data_feedbacksave.lastIndexOf("{"),
                    data_feedbacksave.lastIndexOf("}") + 1
                );
                obj = JSON.parse(feedbacksave);
                // alert(feedbacksave);
                // loadingBar('off');
                if (obj.status == "ok") {
                    $.messager.alert({
                        title: 'Alert',
                        msg: obj.content,
                        fn: function() {
                            document.getElementById("AddNewBtnFm").style.display = 'inline-block';
                            document.getElementById("saveBtnFm").style.display = 'none';
                        }
                    });
                    
                    loadingBar('off');
                    //If you want to allow the user to click on the Submit button now you can enable here like this :
                    $("#dlg-buttons").attr('disabled', false);
                    $('#dg').datagrid('reload'); // reload the user data

                } else if (obj.status == "warning") {
                    $.messager.alert({
                        title: 'Warning',
                        msg: obj.content,
                        fn: function() {
                            // $('#tb-vouchercode').textbox('setValue',obj.VOUCHERCODE);
                            document.getElementById("AddNewBtnFm").style.display = 'inline-block';
                            document.getElementById("saveBtnFm").style.display = 'none';
                        }
                    });

                    loadingBar('off');
                } else {
                    $.messager.alert('Alert', obj.content, 'info');
                    loadingBar('off');
                }
            },
            error: function() {
                alert('Error get data from ajax');
                loadingBar('off');
            }
        });
    }


    //JS addData
    function addData(){

        url = "<?php echo site_url().'/../Content/Approval/MasterApprovalLS/addForm'; ?>" ;
            window.open(url,"_self");
    }



</script>