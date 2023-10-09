<style type="text/css">
	.datagrid-header .datagrid-cell{
		line-height:normal;
		/* height:auto; */
	    white-space: normal;
	}
</style>
    
    <!--- DATA GRID ------------------------------------------------------------------------->
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/scdTrMonitor/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
                    fitColumns:false,
                    pagination:true,
                    pageSize:50,
                    showFooter: true,
                    nowrap:false,
                    singleSelect:true,
                    ">
        <thead>
            <tr>
                <th field="CRTTS" halign="center" data-options="sortable:false,width:200,align:'left' " formatter=""><b>CRTTS</b></th>
                <th field="CRTBY" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>CRTBY</b></th>
                <!-- <th field="UPDTS" halign="center" data-options="sortable:false,width:60,align:'left' " formatter=""><b>UPDTS</b></th>
                <th field="UPDBY" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>UPDBY</b></th> -->
                <!-- <th field="TRM" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>TRM</b></th> -->
                <!-- <th field="UTC_MW" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>UTC_MW</b></th>
                <th field="UTC_MTU" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>UTC_MTU</b></th> -->
                <th field="SVRDT" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>SVRDT</b></th>
                <th field="POSTDT" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>POSTDT</b></th>
                <th field="ORG_ID" halign="center" data-options="sortable:false,width:60,align:'left' " formatter=""><b>ORG_ID</b></th>
                <th field="ORG_CODE" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>ORG_CODE</b></th>
                <th field="ORG_CODE_PR" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>ORG_CODE_PR</b></th>
                <th field="DT_ID" halign="center" data-options="sortable:false,width:200,align:'left' " formatter=""><b>DT_ID</b></th>
                <th field="DT_UEP" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>DT_UEP</b></th>
                <th field="DT_DIV" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>DT_DIV</b></th>
                <th field="DT_ADD" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>DT_ADD</b></th>
                <th field="DT_VAL" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>DT_VAL</b></th>
                <th field="DT_TYPE" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>DT_TYPE</b></th>
                <th field="TDATETIME" halign="center" data-options="sortable:false,width:200,align:'left' " formatter=""><b>TDATETIME</b></th>
            </tr>
        </thead>
    </table>

    <div id="tb-pv" class="pb-1 pt-1">        
        <div class='col-xl-12 col-lg-12 col-md-12 row'>
            <div class="col-xl-9 col-lg-9 col-md-9 row">
                <input id="dt-tdate" name="TDATE" class="easyui-datebox" style="width: 200px;"  data-options="required:true">
                <input id="cb-dt_div" name="DT_DIV" class="" style="width:200px;" >
                <!-- <div class="col-xl-3 col-lg-3 col-md-3 row"> -->
                    <!-- <input id="tb-Year" name="YEARNUMBER" class="easyui-numberbox " style="width: 100px;"  data-options="required:true" prompt="Year"> -->
                    <!-- <input id="cg-MonthNumber" name="MONTHNUMBER" class="easyui-combogrid" style="width: 200px;"  data-options="required:true" prompt="Month"> -->
                    
                <!-- </div> -->
            </div>
            
            <div class=" col-xl-3 col-lg-3 col-md-3  text-right">
                <button id="btn-search" class="btn btn-primary" style="width: 75px;"  onclick="doSearch()"><i class="fas fa-search"></i> Search</button>
                &nbsp;
                <button id="btn-searchReset" class="btn btn-danger" style="width: 75px;"  onclick="doSearchReset()"><i class="fas fa-eraser"></i> Clear</button>
                &nbsp;
                <button id="btn-print" class="btn btn-success" style="width: 75px;" onclick="exportDataExcel()" ><i class="fas fa-print"></i> .Xlsx</button>
            </div>
        </div>

    </div>
    <!-- </form> -->


    <script type="text/javascript">
        $(document).ready(function() {

            settingCalendarTDATE();            

            $('#cb-dt_div').combobox({
                valueField: 'id',
		        textField: 'text',
                prompt:"DT_DIV",
                data :[
                    {
                        "id": '1',
                        "text": '1'
                    },
                    {
                        "id": '2',
                        "text": '2'
                    },
                    {
                        "id": '3',
                        "text": '3'
                    },
                    {
                        "id": '4',
                        "text": '4'
                    },
                    {
                        "id": '5',
                        "text": '5'
                    },
                ]
            });


        });

        function getMonthName(monthNumber) {
            const date = new Date();
            date.setMonth(monthNumber - 1);

            return date.toLocaleString('en-US', { month: 'short' });
        }

        function settingCalendarTDATE(){

            var d = new Date();
            var enddate = d.setDate(d.getDate() - 1);

            var newD = new Date(enddate);
            // alert(newD.getDate());


            $('#dt-tdate').datebox({
                value :  newD.getDate() + "-"+getMonthName(newD.getMonth()+1) + "-"+newD.getFullYear(),
                // onSelect: function(date){
                // var p_date = date.getDate()+"-"+(date.getMonth()+1) +"-"+date.getFullYear();
                // }
            });

            $('#dt-tdate').datebox().datebox('calendar').calendar('moveTo', new Date(enddate));

            $('#dt-tdate').datebox().datebox('calendar').calendar({
                validator: function(date){
                    var d = new Date();
                    var d2 = d.setDate(d.getDate() - 1);
                    return date <= d2;
                }
            });
        }

        // JS Searching and Reset
        function doSearch() {

            $('#dg').datagrid('load', {
                TDATE: $('#dt-tdate').datebox('getValue'),
                DT_DIV: $('#cb-dt_div').combobox('getValue'),
            });
        }



        function doSearchReset() {
            $('#dt-tdate').datebox('reset');
            $('#cb-dt_div').combobox('reset');

        }

        function formatNumberColumnCostum(val,row){
            // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var returnVal ='';
            if(val != null){
                returnVal = parseFloat(val).format(2, 3, ',', '.');
            } 
            return  returnVal;
        }


        function exportDataExcel() {
            var dateParam = $('#dt-tdate').datebox('getValue');
            var dtDivParam =  $('#cb-dt_div').combobox('getValue');

        var url = "<?php  echo site_url() . '/../Content/scdTrMonitor/exportExcelFile?TDATE='; ?>"+dateParam+"&DT_DIV="+dtDivParam;
        window.open(url, "_blank");
    }

    </script>   
