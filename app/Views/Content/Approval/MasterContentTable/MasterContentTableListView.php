<style type="text/css">
	.datagrid-header .datagrid-cell{
		line-height:normal;
		/* height:auto; */
	    white-space: normal;
	}
</style>
    
    <!--- DATA GRID ------------------------------------------------------------------------->
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/Approval/MasterContentTable/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
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
                <!-- <th field="ID" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>ID</b></th> -->
                <!-- <th field="IDMODULE" halign="center" data-options="sortable:false,width:100,align:'center' " formatter=""><b>IDMODULE</b></th> -->
                <!-- <th field="INACTIVEDATE" halign="center" data-options="sortable:false,width:150,align:'center' " formatter=""><b>INACTIVEDATE</b></th> -->
                <!-- <th field="INACTIVEDATE2" halign="center" data-options="sortable:false,width:150,align:'center' " formatter=""><b>INACTIVEDATE2</b></th> -->
                <!-- <th field="ID_MODULE" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>ID_MODULE</b></th> -->
                <!-- <th field="NAMA_MODULE" halign="center" data-options="sortable:false,width:200,align:'' " formatter=""><b>NAMA_MODULE</b></th> -->
                <th field="JUDUL_MODULE" halign="center" data-options="sortable:false,width:250,align:'' " formatter=""><b>Log Sheet</b></th>
                <!-- <th field="DESKRIPSI" halign="center" data-options="sortable:false,width:150,align:'' " formatter=""><b>DESKRIPSI</b></th> -->
                <th field="TABLECONTENT" halign="center" data-options="sortable:false,width:150,align:'' " formatter=""><b>Content Table</b></th>
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

        //JS addData
        function addData(){

        url = "<?php echo site_url().'/../Content/Approval/MasterContentTable/addForm'; ?>" ;
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
                        url: "<?php echo site_url().'/../Content/Approval/MasterContentTable/deleteData' ; ?>",
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
