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
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/LogSheet/logSheetClarification/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
                    fitColumns:false,
                    pagination:true,
                    pageSize:50,
                    showFooter: true,
                    nowrap:false,
                    singleSelect:true,
                    rownumbers: true,
                    frozenColumns:[[
                        {field:'TIME_DISP',title:'JAM',width:60,align:'center'},
                    ]],
                    ">
        <thead>
            <tr>
                <th colspan="2" rowspan="2"><b>TEMP ( <span>&#176;</span>C )</b></th>
                <th rowspan="2"><b>VACUUM 1</b></th>
                <th rowspan="2"><b>VACUUM 2</b></th>
                <th colspan="6"><b>CONTINOUS SETTING TANK</b></th>
                <th colspan="2"><b>SLUDGE TANK</b></th>
                <th colspan="3" rowspan="2"><b>DECANTER IN OPERATION</b></th>
                <th rowspan="2"><b>PROCESS HOT WATER</b></th>
                <th colspan="2"><b>DESANDING</b></th>
                <th colspan="2"><b>PURRIFIER</b></th>
                <th colspan="6"><b>DECANTER RUNNING HOURS</b></th>
                <!-- <th rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:60,align:'center' " ><b>PARAF MANDOR</b></th> -->
                <!-- <th rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:160,align:'center' " ><b>KETERANGAN</b></th> -->
            </tr>
            <tr>
                <th colspan="3" ><b>TEMP ( <span>&#176;</span>C )</b></th>
                <th colspan="3" ><b>OIL LAYER (CM)</b></th>
                <th colspan="2" ><b>TEMP ( <span>&#176;</span>C )</b></th>
                <th colspan="2" ><b>RECLAIM OIL TANK</b></th>
                <th colspan="2" ><b>RUNNING HOURS</b></th>
                <th colspan="2" ><b>DECANTER NO 1</b></th>
                <th colspan="2" ><b>DECANTER NO 2</b></th>
                <th colspan="2" ><b>DECANTER NO 3</b></th>
            </tr>
            <tr>
                <th field="TMP1" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>DCO</b></th>
                <th field="TMP2" halign="center" data-options="sortable:false,width:100,align:'center' " formatter="formatNumberColumnCostum"><b>PURE OIL TANK</b></th>
                <th field="VCM1" halign="center" data-options="sortable:false,width:100,align:'center' " formatter="formatNumberColumnCostum"><b>BAR</b></th>
                <th field="VCM2" halign="center" data-options="sortable:false,width:100,align:'center' " formatter="formatNumberColumnCostum"><b>BAR</b></th>
                <th field="CSTTMP1" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.1</b></th>
                <th field="CSTTMP2" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.2</b></th>
                <th field="CSTTMP3" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.3</b></th>
                <th field="CSTTMP4" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.1</b></th>
                <th field="CSTTMP5" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.2</b></th>
                <th field="CSTTMP6" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.3</b></th>
                <th field="CSTOLY1" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.1</b></th>
                <th field="CSTOLY2" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.2</b></th>
                <th field="CSTOLY3" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.1</b></th>
                <th field="CSTOLY4" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.2</b></th>
                <th field="CSTOLY5" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.3</b></th>
                <th field="CSTOLY6" halign="center" data-options="sortable:false,width:100,align:'center' " formatter="formatNumberColumnCostum"><b>TEMP (<span>&#176;</span>C)</b></th>
                <th field="SDTTMP1" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>YES</b></th>
                <th field="SDTTMP2" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO</b></th>
                <th field="SDTTMP3" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>START</b></th>
                <th field="SDTTMP4" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>STOP</b></th>
                <th field="SDTTMP5" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>START</b></th>
                <th field="SDTTMP6" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>STOP</b></th>
                <th field="SSPTMP1" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>START</b></th>
                <th field="SSPTMP2" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>STOP</b></th>
                <th field="SSPTMP3" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>START</b></th>
                <th field="SSPTMP4" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>STOP</b></th>
            </tr>
        </thead>
    </table>

    <div id="tb-pv" class="pb-1 pt-1">        
        <div class='col-xl-12 col-lg-12 col-md-12 row'>
            <div class="col row">
                <input id="dt-tdate" name="TDATE" class="easyui-datebox" style="width: 150px;"  data-options="required:true">
                <input id="cb-stationid" name="STATIONID" class="" style="width:100px;" >
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

            $('#cb-stationid').combobox({
                valueField: 'ID',
                textField: 'DESCRIPTION',
                prompt:"Press ID",
                required:true,
                value:"1",
                url: "<?php  echo site_url() . '/../Content/LogSheet/logsheetclarification/getStationID'; ?>",
            });

            doSearch();

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
            var idParam =  $('#cb-stationid').combobox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                // alert('"Tanggal" Harus Di Isi Dahulu');
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Tanggal Harus Di Isi Dahulu ! '
                });
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            if( idParam.trim() == '' || idParam.trim() == null ){
                // alert('"Storage" Harus Di Isi Dahulu');
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Pilih Press ID Dahulu ! '
                });
                $('#cb-stationid').combobox('textbox').focus();
                exit;   
            } 

            $('#dg').datagrid('load', {
                TDATE: $('#dt-tdate').datebox('getValue'),
                STATIONID: $('#cb-stationid').combobox('getValue'),
            });
        }

        function doSearchReset() {
            $('#dt-tdate').datebox('reset');
            $('#cb-stationid').combobox('reset');

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

        function imageTrue(val,row){

            var returnVal ='';
            if(val > 0){
                returnVal = '<i class="fas fa-check"></i>';
            } 
            return  returnVal;
        }

        function imageFalse(val,row){

            var returnVal ='';
            if(val < 1){
                returnVal = '<i class="fas fa-times"></i>';
            } 
            return  returnVal;
        }


        function exportDataExcel() {
        
            var dateParam = $('#dt-tdate').datebox('getValue');
            var idParam =  $('#cb-stationid').combobox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Tanggal Harus Di Isi Dahulu ! '
                });
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            if( idParam.trim() == '' || idParam.trim() == null ){
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Pilih Press ID Dahulu ! '
                });
                $('#cb-stationid').combobox('textbox').focus();
                exit;   
            } 

            var url = "<?php  echo site_url() . '/../Content/LogSheet/logSheetClarification/exportExcelFile?TDATE='; ?>"+dateParam+"&STATIONID="+idParam;
            window.open(url, "_blank");
        }

        function exportDataPDF() {
        
            var dateParam = $('#dt-tdate').datebox('getValue');
            var idParam =  $('#cb-stationid').combobox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Tanggal Harus Di Isi Dahulu ! '
                });
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            if( idParam.trim() == '' || idParam.trim() == null ){
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Pilih Press ID Dahulu ! '
                });
                $('#cb-stationid').combobox('textbox').focus();
                exit;   
            } 

             var url = "<?php  echo site_url() . '/../Content/LogSheet/logSheetClarification/exportPDFFile?TDATE='; ?>"+dateParam+"&STATIONID="+idParam;
            // var url = "<?php // echo site_url() . '/../Content/LogSheet/logSheetClarification/cekPdfView?TDATE='; ?>"+dateParam+"&STATIONID="+idParam;
            window.open(url, "_blank");
    }

    </script>   
