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
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/LogSheet/logSheetDigester/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
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
                <th colspan="18"><b>RUNNING HOUR</b></th>
            </tr>
            <tr>
                <th colspan="2"><b>DIGESTER NO.1</b></th>
                <th colspan="2"><b>DIGESTER NO.2</b></th>
                <th colspan="2"><b>DIGESTER NO.3</b></th>
                <th colspan="2"><b>DIGESTER NO.4</b></th>
                <th colspan="2"><b>DIGESTER NO.5</b></th>
                <th colspan="2"><b>DIGESTER NO.6</b></th>
                <th colspan="2"><b>CBC NO.1</b></th>
                <th colspan="2"><b>CBC NO.2</b></th>
                <th colspan="2"><b>CBC NO.3</b></th>
            </tr>
            <tr>
                <th field="PRSDG_SRT1_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>START</b></th>
                <th field="PRSDG_END1_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="basedOnStart_DG1END"><b>STOP</b></th>
                <th field="PRSDG_SRT2_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>START</b></th>
                <th field="PRSDG_END2_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="basedOnStart_DG2END"><b>STOP</b></th>
                <th field="PRSDG_SRT3_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>START</b></th>
                <th field="PRSDG_END3_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="basedOnStart_DG3END"><b>STOP</b></th>
                <th field="PRSDG_SRT4_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>START</b></th>
                <th field="PRSDG_END4_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="basedOnStart_DG4END"><b>STOP</b></th>
                <th field="PRSDG_SRT5_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>START</b></th>
                <th field="PRSDG_END5_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="basedOnStart_DG5END"><b>STOP</b></th>
                <th field="PRSDG_SRT6_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>START</b></th>
                <th field="PRSDG_END6_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="basedOnStart_DG6END"><b>STOP</b></th>
                <th field="PRSCB_SRT1_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>START</b></th>
                <th field="PRSCB_END1_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="basedOnStart_CB1END"><b>STOP</b></th>
                <th field="PRSCB_SRT2_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>START</b></th>
                <th field="PRSCB_END2_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="basedOnStart_CB2END"><b>STOP</b></th>
                <th field="PRSCB_SRT3_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>START</b></th>
                <th field="PRSCB_END3_DISP" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="basedOnStart_CB3END"><b>STOP</b></th>
            </tr>
        </thead>
    </table>

    <div id="tb-pv" class="pb-1 pt-1">        
        <div class='col-xl-12 col-lg-12 col-md-12 row'>
            <div class="col row">
                <input id="dt-tdate" name="TDATE" class="easyui-datebox" style="width: 150px;"  data-options="required:true">
                <!-- <input id="cb-prsid" name="PRSID" class="" style="width:100px;" > -->
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

            // $('#cb-prsid').combobox({
            //     valueField: 'ID',
            //     textField: 'DESCRIPTION',
            //     prompt:"Press ID",
            //     required:true,
            //     value:"1",
            //     url: "<?php // echo site_url() . '/../Content/LogSheet/logSheetDigester/getPress'; ?>",
            // });

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

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                // alert('"Tanggal" Harus Di Isi Dahulu');
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Tanggal Harus Di Isi Dahulu ! '
                });
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            $('#dg').datagrid('load', {
                TDATE: $('#dt-tdate').datebox('getValue'),
            });
        }

        function doSearchReset() {
            $('#dt-tdate').datebox('reset');

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

        function basedOnStart_DG1END(val,row,lol){

            var startTime = row.PRSDG_SRT1_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_DG2END(val,row,lol){

            var startTime = row.PRSDG_SRT2_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_DG3END(val,row,lol){

            var startTime = row.PRSDG_SRT3_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_DG4END(val,row,lol){

            var startTime = row.PRSDG_SRT4_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_DG5END(val,row,lol){

            var startTime = row.PRSDG_SRT5_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_DG6END(val,row,lol){

            var startTime = row.PRSDG_SRT6_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_CB1END(val,row,lol){

            var startTime = row.PRSCB_SRT1_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_CB2END(val,row,lol){

            var startTime = row.PRSCB_SRT2_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_CB3END(val,row,lol){

            var startTime = row.PRSCB_SRT3_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnPrevRow_DG1ST(val,row,lol){

            var startTime = row.PRSDG_SRT1_DISP;
            var stopTime = row.PRSDG_END1_DISP;

            if( startTime != null && stopTime !=null ){

                var rowPrev = $('#dg').datagrid('getRows')[lol-1];
                var result = rowPrev.PRSDG_END1_DISP;
            } else {
                var result = val;
            }
            return  result;
        }


        function exportDataExcel() {
        
            var dateParam = $('#dt-tdate').datebox('getValue');
            // var idParam =  $('#cb-prsid').combobox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Tanggal Harus Di Isi Dahulu ! '
                });
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            // if( idParam.trim() == '' || idParam.trim() == null ){
            //     $.messager.alert({    
            //         title: 'Info',
            //         msg: 'Pilih Press ID Dahulu ! '
            //     });
            //     $('#cb-prsid').combobox('textbox').focus();
            //     exit;   
            // } 

            var url = "<?php  echo site_url() . '/../Content/LogSheet/logSheetDigester/exportExcelFile?TDATE='; ?>"+dateParam;
            // var url = "<?php  echo site_url() . '/../Content/LogSheet/logSheetDigester/exportExcelFile?TDATE='; ?>"+dateParam+"&PRSID="+idParam;
            window.open(url, "_blank");
        }

        function exportDataPDF() {
        
            var dateParam = $('#dt-tdate').datebox('getValue');
            // var idParam =  $('#cb-prsid').combobox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Tanggal Harus Di Isi Dahulu ! '
                });
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            // if( idParam.trim() == '' || idParam.trim() == null ){
            //     $.messager.alert({    
            //         title: 'Info',
            //         msg: 'Pilih Press ID Dahulu ! '
            //     });
            //     $('#cb-prsid').combobox('textbox').focus();
            //     exit;   
            // } 

             var url = "<?php  echo site_url() . '/../Content/LogSheet/logSheetDigester/exportPDFFile?TDATE='; ?>"+dateParam;
            // var url = "<?php // echo site_url() . '/../Content/LogSheet/logSheetDigester/cekPdfView?TDATE='; ?>"+dateParam+"&PRSID="+idParam;
            window.open(url, "_blank");
    }

    </script>   
