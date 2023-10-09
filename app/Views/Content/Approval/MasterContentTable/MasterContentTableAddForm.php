<style>

</style>
<meta name="viewport" content="width=device-width,initial-scale=1.0">

    <!-- ini container utama -->
<div class="container col  pt-2 bg-white container_utama" style="<?php echo $tinggi_dg; ?>">

<!-- form di pindahkan ke dalam container utama karena detail mau menggunakan pilihan  upload atau manual -->
    <form id="fm" method="post" novalidate>

        <!-- ini container judul dan tombol -->
        <div class="col row headcls titleHeader">
            <div class="col  panel-title">
                Master Content Table
            </div>
            <div class="col-md-auto">
                <a href="#" id="saveBtnFm" class="easyui-linkbutton" iconCls="icon-save" onclick="saveData()" style="width:70px;height:28px;display:inline-block;">Save</a>
                <a href="#" id="AddNewBtnFm" class="easyui-linkbutton" iconCls="icon-add" onclick="addData()" style="width:70px;height:28px;display:none;">New</a>
                <a href="<?php echo site_url() . '/../Content/Approval/MasterContentTable';  ?>" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:70px;height:28px">Cancel</a>
            </div>
        </div>
        <!-- ini container form header-->
        <div id="containerHeaderForm"  class=" col-md-12 pt-3 contentHeader">

            <div class="row col-12 col-12 pb-2">
                <div class="col-12 col-md-6  ">
                    <div class="col-12 col-md-2 col-form-label">
                        Module
                    </div>

                    <div class="col-12 col-md-10 row">
                        <div class="col-12 col-md-12">
                            <input id="cb-module" name="ID_MODULE" class="" style="width:100%;" data-options="readonly:false, required:true" prompt="ID Module">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row col-12 col-12 pb-2">
                <div class="col-12 col-md-6  ">
                    <div class="col-12 col-md-2 col-form-label">
                        Table Content
                    </div>

                    <div class="col-12 col-md-10 row">
                        <div class="col-12 col-md-12">
                            <input id="cb-tablecontent" name="TABLECONTENT" class="" style="width:100%;" data-options="readonly:false, required:true" prompt="Nama Table">
                        </div>
                    </div>
                </div>
            </div>
            <!-- ---------------------- -->


        </div>

       

        <!-- </div> -->

    </form>

</div>



<script>


    $(document).ready(function() {

        $('#cb-module').combobox({
            url: "<?php echo site_url() . '/../Content/Approval/MasterContentTable/getCbModule'; ?>",
            required:true,
            loadMsg: 'Loading',
            panelHeight:'auto',
            valueField:'ID_MODULE',
            textField:'JUDUL_MODULE',
            value:'',
            onSelect: function(record){
                

            }
        });

        $('#cb-tablecontent').combobox({
            url: "<?php echo site_url() . '/../Content/Approval/MasterContentTable/getCbTableContent'; ?>",
            required:true,
            loadMsg: 'Loading',
            panelHeight:'auto',
            valueField:'TNAME',
            textField:'TNAME',
            value:'',
            onSelect: function(record){
                

            }
        });

        

    });

    

</script>




<!-- save tambah data -->
<script type="text/javascript">

    function saveData() {

        // console.log('banyak data dataExcel :'+ Array.isArray(dataExcel));
        // alert(dataExcel);

        $('#fm').form('submit', {
            url: '<?php echo site_url() . '/../Content/Approval/MasterContentTable/saveData'; ?>',
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

        url = "<?php echo site_url().'/../Content/Approval/MasterContentTable/addForm'; ?>" ;
            window.open(url,"_self");
    }



</script>