<style type="text/css">
	.datagrid-header .datagrid-cell{
		line-height:normal;
		/* height:auto; */
	    white-space: normal;
	}
    .datagrid-cell-group{
		line-height:normal;
		height:auto;
	    white-space: normal;
	}
</style>
    
    <!--- DATA GRID ------------------------------------------------------------------------->
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/LogSheet/logSheetCPOStorageTank/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
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
                <th rowspan="3" field="TIME_DISP"halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>JAM</b></th>
                <th colspan="6"><b>STANDARD</b></th>
                <th colspan="12"><b>DATA SAMPLING</b></th>
            </tr>
            <tr>
                <th rowspan="2" field="STGLVCM" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>LEVEL cm</b></th>
                <th rowspan="2" field="STGLVMM" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>LEVEL mm</b></th>
                <th rowspan="2" field="STGTMPINTAVG" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>SUHU</b></th>
                <th rowspan="2" field="BJ" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>BERAT JENIS</b></th>
                <th rowspan="2" field="CORECTIONF" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>MUAI RUANG</b></th>
                <th rowspan="2" field="WEIGHT" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostumBilanganBulat"><b>BERAT (Kg)</b></th>
                <th rowspan="2" field="SUMSTGID_UEP_TIME" halign="center" data-options="sortable:false,width:150,align:'center' " ><b>WAKTU</b></th>
                <th colspan="6"><b>SUHU INTERNAL</b></th>
                <th colspan="5"><b>SUHU EXTERNAL</b></th>
            </tr>
            <tr>
                <th field="STGTMPINT1" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>1</b></th>
                <th field="STGTMPINT2" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>2</b></th>
                <th field="STGTMPINT3" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>3</b></th>
                <th field="STGTMPINT4" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>4</b></th>
                <th field="STGTMPINT5" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>5</b></th>
                <th field="STGTMPINTAVG" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>AVG</b></th>
                <th field="STGTMPEXT1" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>1</b></th>
                <th field="STGTMPEXT2" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>2</b></th>
                <th field="STGTMPEXT3" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>3</b></th>
                <th field="STGTMPEXTF" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>SCALA</b></th>
                <th field="STGTMPEXTAVG" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>AVG</b></th>
            </tr>
        </thead>
    </table>

    <div id="tb-pv" class="pb-1 pt-1">        
        <div class='col-xl-12 col-lg-12 col-md-12 row'>
            <div class="col row">
                <input id="dt-tdate" name="TDATE" class="easyui-datebox" style="width: 150px;"  data-options="required:true">
                <input id="cb-stg_id" name="STG_ID" class="" style="width:100px;" >
                <!-- <div class="col-xl-3 col-lg-3 col-md-3 row"> -->
                    <!-- <input id="tb-Year" name="YEARNUMBER" class="easyui-numberbox " style="width: 100px;"  data-options="required:true" prompt="Year"> -->
                    <!-- <input id="cg-MonthNumber" name="MONTHNUMBER" class="easyui-combogrid" style="width: 200px;"  data-options="required:true" prompt="Month"> -->
                    
                <!-- </div> -->
            </div>
            
            <div class=" col-md-auto  text-right">
                <button id="btn-search" class="btn btn-primary" style="width: 75px;"  onclick="doSearch()"><i class="fas fa-search"></i> Search</button>
                &nbsp;
                <button id="btn-searchReset" class="btn btn-danger" style="width: 75px;"  onclick="doSearchReset()"><i class="fas fa-eraser"></i> Clear</button>
                <!-- &nbsp; -->
                <!-- <button id="btn-print" class="btn btn-success" style="width: 75px;" onclick="exportDataExcel()" ><i class="fas fa-print"></i> .Xlsx</button> -->
                &nbsp;
                <button id="btn-print" class="btn btn-warning" style="width: 75px;" onclick="exportDataPDF()" ><i class="fas fa-print"></i> .Pdf</button>
            </div>
        </div>

    </div>
    <!-- </form> -->


    <script type="text/javascript">
        $(document).ready(function() {

            settingCalendarTDATE();            

            $('#cb-stg_id').combobox({
                valueField: 'ID',
                textField: 'DESCRIPTION',
                prompt:"Storage ID",
                required:true,
                url: "<?php echo site_url() . '/../Content/LogSheet/LogSheetCPOStorageTank/getStg'; ?>",
            });

            // doSearch();

        });

        function getMonthName(monthNumber) {
            const date = new Date();
            date.setMonth(monthNumber - 1);

            return date.toLocaleString('en-US', { month: 'short' });
        }


        function settingCalendarTDATE(){

            var d = new Date();
            var enddate = d.setDate(d.getDate() - 1);

            var paramDate = "<?php if(isset($_GET['POSTDT'])) { echo $_GET['POSTDT'];}  ?>";

            console.log(paramDate);

            if(paramDate != ''){    
                var newD = new Date(paramDate);
                enddate = newD;
                
            } else {
                var newD = new Date(enddate);
            }

            // var newD = new Date(enddate);
            // alert(newD.getDate());


            $('#dt-tdate').datebox({
                value :  newD.getDate() + "-"+getMonthName(newD.getMonth()+1) + "-"+newD.getFullYear(),
                // onSelect: function(date){
                // var p_date = date.getDate()+"-"+(date.getMonth()+1) +"-"+date.getFullYear();
                // }
            });

            $('#dt-tdate').datebox().datebox('calendar').calendar('moveTo', new Date(enddate));

            // $('#dt-tdate').datebox().datebox('calendar').calendar({
            //     validator: function(date){
            //         var d = new Date();
            //         var d2 = d.setDate(d.getDate() - 1);
            //         return date <= d2;
            //     }
            // });
        }


        // JS Searching and Reset
        function doSearch() {

            var dateParam = $('#dt-tdate').datebox('getValue');
            var stgIdParam =  $('#cb-stg_id').combobox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                alert('"Tanggal" Harus Di Isi Dahulu');
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            if( stgIdParam.trim() == '' || stgIdParam.trim() == null ){
                alert('"Storage" Harus Di Isi Dahulu');
                $('#cb-stg_id').combobox('textbox').focus();
                exit;   
            } 

            $('#dg').datagrid('load', {
                TDATE: $('#dt-tdate').datebox('getValue'),
                STG_ID: $('#cb-stg_id').combobox('getValue'),
            });
        }

        function doSearchReset() {
            $('#dt-tdate').datebox('reset');
            $('#cb-stg_id').combobox('reset');

        }

        function formatNumberColumnCostum(val,row){
            // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var returnVal ='';
            if(val != null){
                returnVal = parseFloat(val).format(2, 3, ',', '.');
            } 
            return  returnVal;
        }

        function formatNumberColumnCostumBilanganBulat(val,row){
            // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var returnVal ='';
            if(val != null){
                returnVal = parseFloat(val).format(0, 3, ',', '.');
            } 
            return  returnVal;
        }


        function exportDataExcel() {
        
            var dateParam = $('#dt-tdate').datebox('getValue');
            var stgIdParam =  $('#cb-stg_id').combobox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                alert('"Tanggal" Harus Di Isi Dahulu');
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            if( stgIdParam.trim() == '' || stgIdParam.trim() == null ){
                alert('"Storage" Harus Di Isi Dahulu');
                $('#cb-stg_id').combobox('textbox').focus();
                exit;   
            } 

            var url = "<?php  echo site_url() . '/../Content/LogSheet/logSheetCPOStorageTank/exportExcelFile?TDATE='; ?>"+dateParam+"&STG_ID="+stgIdParam;
            window.open(url, "_blank");
        }

        function exportDataPDF() {
        
            var dateParam = $('#dt-tdate').datebox('getValue');
            var stgIdParam =  $('#cb-stg_id').combobox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                alert('"Tanggal" Harus Di Isi Dahulu');
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            if( stgIdParam.trim() == '' || stgIdParam.trim() == null ){
                alert('"Storage" Harus Di Isi Dahulu');
                $('#cb-stg_id').combobox('textbox').focus();
                exit;   
            } 

            var url = "<?php  echo site_url() . '/../Content/LogSheet/logSheetCPOStorageTank/exportPDFFile?TDATE='; ?>"+dateParam+"&STG_ID="+stgIdParam;
            // var url = "<?php // echo site_url() . '/../Content/LogSheet/logSheetCPOStorageTank/cekPdfView?TDATE='; ?>"+dateParam+"&STG_ID="+stgIdParam;
            window.open(url, "_blank");
    }

    </script>   
