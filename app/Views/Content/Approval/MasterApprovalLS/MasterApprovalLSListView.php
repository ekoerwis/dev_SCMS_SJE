<style type="text/css">
	.datagrid-header .datagrid-cell{
		line-height:normal;
		/* height:auto; */
	    white-space: normal;
	}
</style>
    
    <!--- DATA GRID ------------------------------------------------------------------------->
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/Approval/MasterApprovalLS/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
                    fitColumns:false,
                    pagination:true,
                    pageSize:50,
                    showFooter: true,
                    nowrap:false,
                    singleSelect:true,
                    rownumbers: true,
                    ">
        <thead>
            <tr>
                <!-- <th field="ID" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>ID</b></th> -->
                <!-- <th field="IDCONTENT" halign="center" data-options="sortable:false,width:100,align:'center' " formatter=""><b>IDCONTENT</b></th> -->
                <!-- <th field="INACTIVEDATE" halign="center" data-options="sortable:false,width:150,align:'center' " formatter=""><b>INACTIVEDATE</b></th> -->
                <!-- <th field="IDMODULE" halign="center" data-options="sortable:false,width:80,align:'' " formatter=""><b>IDMODULE</b></th> -->
                <!-- <th field="TABLECONTENT" halign="center" data-options="sortable:false,width:150,align:'' " formatter=""><b>TABLECONTENT</b></th> -->
                <!-- <th field="ID_MODULE" halign="center" data-options="sortable:false,width:100,align:'' " formatter=""><b>ID_MODULE</b></th> -->
                <!-- <th field="NAMA_MODULE" halign="center" data-options="sortable:false,width:100,align:'' " formatter=""><b>NAMA_MODULE</b></th> -->
                <th field="JUDUL_MODULE" halign="center" data-options="sortable:false,width:250,align:'' " formatter=""><b>Log Sheet</b></th>
                <!-- <th field="DESKRIPSI" halign="center" data-options="sortable:false,width:150,align:'' " formatter=""><b>DESKRIPSI</b></th> -->
                <th field="MAXLEVEL" halign="center" data-options="sortable:false,width:100,align:'center' " formatter=""><b>Max Level</b></th>
                <th field="REMARKS" halign="center" data-options="sortable:false,width:250,align:'center' " formatter=""><b>Keterangan</b></th>
            </tr>
        </thead>
    </table>

    <div id="tb-pv" class="pb-1 pt-1 ">        
        <div class='col-xl-12 col-lg-12 col-md-12 row'>
            <div class="col row">
                <?php if(strtolower($auth_tambah) == 'yes'){ ?>
                    <button type="button" style="width: 75px;"  class="btn btn-success" onclick="addData()"> <i class="fas fa-plus"> Add</i></button> &nbsp;
                <?php }?>
                <?php if(strtolower($auth_ubah) == 'all'){ ?>
                    <button type="button" style="width: 75px;"  class="btn btn-warning" onclick="updateData()"> <i class="fas fa-edit"> Edit</i></button> &nbsp;
                <?php }?>
                <?php if(strtolower($auth_hapus) == 'all'){ ?>
                    <button type="button" style="width: 75px;"  class="btn btn-danger" onclick="deleteData()"> <i class="fas fa-minus"> Delete</i></button> &nbsp;

                <?php }?>
            </div>
            
            <div class=" col-md-auto  text-right">
                <!-- <button id="btn-search" class="btn btn-primary" style="width: 75px;"  onclick="doSearch()"><i class="fas fa-search"></i> Search</button> -->
                &nbsp;
                <!-- <button id="btn-searchReset" class="btn btn-danger" style="width: 75px;"  onclick="doSearchReset()"><i class="fas fa-eraser"></i> Clear</button> -->
            </div>
        </div>

    </div>
    <!-- </form> -->


    <script type="text/javascript">
        $(document).ready(function() {

        });


            
    $(function() {
        $('#dg').datagrid({
            view: detailview,
            detailFormatter: function(rowIndex, rowData) {
                var tableReturn =" ";
                tableReturn += "<table class='table table-striped' style='margin-top:5px; margin-bottom:5px;'> ";
                tableReturn += '<thead style="text-align:center; display: block; ">';
                tableReturn += "<tr style='text-align:center;'>";
                // tableReturn += "<th style='padding:3px 3px; width:50px;'>No</th>";
                tableReturn += "<th style='padding:3px 3px; width:60px;'>Level</th>";
                tableReturn += "<th style='padding:3px 3px; width:150px;'>Role</th>";
                tableReturn += "</tr>";
                tableReturn += '</thead>';
                tableReturn += "<tbody style='display: block; overflow-y: auto;  max-height: 250px;'>";

                var jmlDetail=0;
                var jmlDetail =rowData.dataDetail.length;
                var totalAmount = 0;
                if (jmlDetail == 0) {
                    tableReturn += '<tr> <td colspan="2" style="text-align:center;padding:3px 3px; width:260px;"> Tidak Ada Detail</td> </tr>';
                } 
                else {                        
                    for(var j = 0 ; j<jmlDetail ; j++){

                        if (rowData.dataDetail[j].ID == null) { ID = 0; } else { ID = rowData.dataDetail[j].ID; }
                        if (rowData.dataDetail[j].IDHEADER == null) { IDHEADER = 0; } else { IDHEADER = rowData.dataDetail[j].IDHEADER; }
                        if (rowData.dataDetail[j].LVL == null) { LVL = 0; } else { LVL = rowData.dataDetail[j].LVL; }
                        if (rowData.dataDetail[j].IDROLE == null) { IDROLE = 0; } else { IDROLE = rowData.dataDetail[j].IDROLE; }
                        if (rowData.dataDetail[j].NAMA_ROLE == null) { NAMA_ROLE = ''; } else { NAMA_ROLE = rowData.dataDetail[j].NAMA_ROLE; }
                        if (rowData.dataDetail[j].JUDUL_ROLE == null) { JUDUL_ROLE = ''; } else { JUDUL_ROLE = rowData.dataDetail[j].JUDUL_ROLE; }
                        if (rowData.dataDetail[j].KETERANGAN == null) { KETERANGAN = ''; } else { KETERANGAN = rowData.dataDetail[j].KETERANGAN; }

                        
                        tableReturn += '<tr>';
                        // tableReturn += ' <td style="text-align:center;padding:3px 3px; width:50px;"> '+ (j+1) +'</td> ';
                        // tableReturn += ' <td style="padding:3px 3px; width:150px; text-align:center"> '+parseInt(ID).format(0, 3, ',', '.')+'</td> ';
                        // tableReturn += ' <td style="padding:3px 3px; width:150px; text-align:center"> '+parseInt(IDHEADER).format(0, 3, ',', '.')+'</td> ';
                        tableReturn += ' <td style="padding:3px 3px; width:60px; text-align:center"> '+parseInt(LVL).format(0, 3, ',', '.')+'</td> ';
                        // tableReturn += ' <td style="padding:3px 3px; width:150px; text-align:center"> '+parseInt(IDROLE).format(0, 3, ',', '.')+'</td> ';
                        // tableReturn += ' <td style="padding:3px 3px; width:60px; word-break:break-all;"> '+ NAMA_ROLE +'</td> ';
                        tableReturn += ' <td style="padding:3px 3px; width:150px; word-break:break-all;"> '+ JUDUL_ROLE +'</td> ';
                        // tableReturn += ' <td style="padding:3px 3px; width:80px; word-break:break-all;"> '+ KETERANGAN +'</td> ';
                        tableReturn += '</tr>';

                        // totalAmount = Number(totalAmount)+Number(AMOUNT);
                    }
                }
                tableReturn += '</tbody>';
                // tableReturn += "<tfoot style='display: block; '>";
                // tableReturn += "<tr>";
                // tableReturn += "<th colspan='10' style='text-align:right;padding:3px 3px; width:1100px;'> Total : </th>";
                // tableReturn += "<th style='text-align:right;padding:3px 3px; width:150px;'>"+parseFloat(totalAmount).format(2, 3, ',', '.')+"</th> ";
                // tableReturn += "<th colspan='2' style='text-align:right;padding:3px 3px; width:400px;'>  </th>";
                // tableReturn += "</tr></tfoot>";
                tableReturn += "</table>";

                return tableReturn;

                // return '<div class="ddv" style="max-height:300px;">'+tableReturn+'</div>';
            }
        });
    });


        //JS addData
        function addData(){

        url = "<?php echo site_url().'/../Content/Approval/MasterApprovalLS/addForm'; ?>" ;
            window.open(url,"_self");
        }

        
    // JS Delete
    function deleteData(){
        var row = $('#dg').datagrid('getSelected');
        if (row){
            $.messager.confirm('Confirm','Hapus Data: '+ row.JUDUL_MODULE +' ?' ,function(r){
                if (r){
                $.ajax({
                        type: "POST",
                        url: "<?php echo site_url().'/../Content/Approval/MasterApprovalLS/deleteData' ; ?>",
                        data: {
                        id:row.ID,
                        },
                        success: function (result) {
                            console.log(result);
                            obj = JSON.parse(result);
                            $.messager.alert({
                                title: 'Alert',
                                msg: obj.msg.content,
                            });

                            $('#dg').datagrid('reload');
                            
                        },
                        error: function (result, status) {
                            console.log(result);
                            $.messager.show({    // show error message
                                title: 'Error',
                                msg: 'Error Proses Post, Hubungi Administrator !'
                            });


                        }
                    });
                }
            });
        }
    }

    </script>   
