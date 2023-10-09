<style type="text/css">
	.datagrid-header .datagrid-cell{
		line-height:normal;
		/* height:auto; */
	    white-space: normal;
	}
</style>
    
    <!--- DATA GRID ------------------------------------------------------------------------->
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/Approval/ApprovalListLogsheet/dataListNeedAction?MONTHNUMBER='.$MONTHNUMBER.'&YEARNUMBER='.$YEARNUMBER.'&IDMODULE='.$IDMODULE; ?>" 
    data-options="striped:true,
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
                <th colspan="3"><b><?php echo $JUDULMODULELS; ?></b></th>                
            </tr>
            <tr>
                <!-- <th field="POSTDT" halign="center" data-options="sortable:false,width:120,align:'center' " formatter=""><b>POSTDT</b></th> -->
                <th field="POSTDT2" halign="center" data-options="sortable:false,width:120,align:'center' " formatter=""><b>Tanggal</b></th>
                <th field="ID_MS_APPROVAL_DETAIL" halign="center" data-options="sortable:false,width:120,align:'center' " formatter="approveButton"><b>Approve</b></th>
                <th field="NAMA_MODULE" halign="center" data-options="sortable:false,width:120,align:'center' " formatter="goToLS"><b>Go To</b></th>
                <!-- <th field="ID_MS_APPROVAL_DETAIL" halign="center" data-options="sortable:false,width:120,align:'center' " formatter=""><b>ID_MS_APPROVAL_DETAIL</b></th> -->
                
            </tr>
        </thead>
    </table>

    <!-- </form> -->


    <script type="text/javascript">
        $(document).ready(function() {

            

        });

       


        // JS Searching and Reset
        function doSearch() {

            $('#dg').datagrid('load', {
                YEARNUMBER: '<?= $YEARNUMBER ?>',
                MONTHNUMBER: '<?= $MONTHNUMBER ?>',
                IDMODULE:'<?= $IDMODULE ?>',
            });
        }

        function formatNumberColumnCostum(val,row){
            // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var returnVal ='';
            if(val != null){
                returnVal = parseFloat(val).format(2, 3, ',', '.');
            } 
            return  returnVal;
        }

        function approveButton(value,row){
            var href = 'x';
            return '<button type="button" class="btn btn-success" onclick="action('+row.ID_MS_APPROVAL_DETAIL+',\''+row.POSTDT2+'\')"> <i class="fas fa-check"></i></button>';
        }

        function goToLS(value,row){
            var href = "<?php echo site_url(); ?>"+'/../'+value+"?POSTDT="+row.POSTDT2;
            return '<a target="_blank" href="' + href + '"> <button type="button" class="btn btn-info"> Logsheet </button></a>';
        }

        function action(ID_MS_APPROVAL_DETAIL,POSTDT2) {
            console.log(ID_MS_APPROVAL_DETAIL+" --------- "+POSTDT2);
            $.ajax({
                type: "POST",
                url: "<?php echo site_url().'/../Content/Approval/ApprovalListLogsheet/actionApprove' ; ?>",
                data: {
                    ID_MS_APPROVAL_DETAIL:ID_MS_APPROVAL_DETAIL,
                    POSTDT2:POSTDT2,
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


    </script>   
