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
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/LogSheet/logSheetPressStation/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
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
                <th colspan="5" rowspan="2"><b>DIGESTER MASS TEMP ( <span>&#176;</span>C )</b></th>
                <th colspan="5" rowspan="2"><b>DIGESTER LOAD (AMP)</b></th>
                <th colspan="5" rowspan="2"><b>PRESS LOAD (AMP)</b></th>
                <th colspan="5" rowspan="2"><b>POWER PACK PRESSURE (BAR)</b></th>
                <th rowspan="2"><b>DILUTION TANK</b></th>
                <th colspan="24"><b>RUNNING HOUR</b></th>
            </tr>
            <tr>
                <!-- <th rowspan="2" field="TIME_DISP"halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>JAM</b></th> -->
                <!-- <th colspan="5"><b>DIGESTER MASS TEMP ( <span>&#176;</span>C )</b></th>
                <th colspan="5"><b>DIGESTER LOAD (AMP)</b></th>
                <th colspan="5"><b>PRESS CONE PRESSURE (BAR)</b></th> -->
                <th colspan="2"><b>PRESS NO.1</b></th>
                <th colspan="2"><b>PRESS NO.2</b></th>
                <th colspan="2"><b>PRESS NO.3</b></th>
                <th colspan="2"><b>PRESS NO.4</b></th>
                <th colspan="2"><b>PRESS NO.5</b></th>
                <!-- <th colspan="2"><b>PRESS NO.6</b></th> -->
                <th colspan="2"><b>DIGESTER NO.1</b></th>
                <th colspan="2"><b>DIGESTER NO.2</b></th>
                <th colspan="2"><b>DIGESTER NO.3</b></th>
                <th colspan="2"><b>DIGESTER NO.4</b></th>
                <th colspan="2"><b>DIGESTER NO.5</b></th>
                <th colspan="2"><b>CBC NO.1</b></th>
                <th colspan="2"><b>CBC NO.2</b></th>
            </tr>
            <tr>
                <th field="PRSDG_TMP1" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.1</b></th>
                <th field="PRSDG_TMP2" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.2</b></th>
                <th field="PRSDG_TMP3" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.3</b></th>
                <th field="PRSDG_TMP4" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.4</b></th>
                <th field="PRSDG_TMP5" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.5</b></th>
                <!-- <th field="PRSDG_TMP6" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.6</b></th> -->
                
                <th field="PRSDG_AMP1" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.1</b></th>
                <th field="PRSDG_AMP2" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.2</b></th>
                <th field="PRSDG_AMP3" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.3</b></th>
                <th field="PRSDG_AMP4" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.4</b></th>
                <th field="PRSDG_AMP5" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.5</b></th>

                <!-- <th field="PRSDG_TMP_AVG" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>AVG</b></th> -->
                <th field="PRSLD_AMP1" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.1</b></th>
                <th field="PRSLD_AMP2" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.2</b></th>
                <th field="PRSLD_AMP3" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.3</b></th>
                <th field="PRSLD_AMP4" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.4</b></th>
                <th field="PRSLD_AMP5" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.5</b></th>
                <!-- <th field="PRSDG_AMP6" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.6</b></th> -->
                <th field="PRSSP_CNP1" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.1</b></th>
                <th field="PRSSP_CNP2" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.2</b></th>
                <th field="PRSSP_CNP3" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.3</b></th>
                <th field="PRSSP_CNP4" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.4</b></th>
                <th field="PRSSP_CNP5" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.5</b></th> 


                <th field="DLTN_TEMP" halign="center" data-options="sortable:false,width:120,align:'center' " formatter="formatNumberColumnCostum"><b>Temp ( <span>&#176;</span>C )</b></th>

                <!-- <th field="PRSSP_CNP6" halign="center" data-options="sortable:false,width:60,align:'center' " formatter="formatNumberColumnCostum"><b>NO.6</b></th> -->
                <th field="PRSSP_HMS1" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSSP_HME1" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>
                <th field="PRSSP_HMS2" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSSP_HME2" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>
                <th field="PRSSP_HMS3" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSSP_HME3" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>
                <th field="PRSSP_HMS4" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSSP_HME4" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>
                <th field="PRSSP_HMS5" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSSP_HME5" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>

                <th field="PRSDG_HMS1" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSDG_HME1" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>
                <th field="PRSDG_HMS2" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSDG_HME2" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>
                <th field="PRSDG_HMS3" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSDG_HME3" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>
                <th field="PRSDG_HMS4" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSDG_HME4" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>
                <th field="PRSDG_HMS5" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSDG_HME5" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>

                <th field="PRSCB_HMS1" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSCB_HME1" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>
                <th field="PRSCB_HMS2" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>START</b></th>
                <th field="PRSCB_HME2" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="hmFormat"><b>STOP</b></th>
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
                &nbsp;
                <button id="btn-print" class="btn btn-warning" style="width: 75px;" onclick="exportDataPDF()" ><i class="fas fa-print"></i> .Pdf</button>
                &nbsp;
                <button id="btn-print" class="btn btn-success" style="width: 75px;" onclick="exportDataExcel()" ><i class="fas fa-print"></i> .Xlsx</button>
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
            //     url: "<?php // echo site_url() . '/../Content/LogSheet/logsheetpressstation/getPress'; ?>",
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
            // var idParam =  $('#cb-prsid').combobox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                // alert('"Tanggal" Harus Di Isi Dahulu');
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Tanggal Harus Di Isi Dahulu ! '
                });
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            // if( idParam.trim() == '' || idParam.trim() == null ){
            //     // alert('"Storage" Harus Di Isi Dahulu');
            //     $.messager.alert({    
            //         title: 'Info',
            //         msg: 'Pilih Press ID Dahulu ! '
            //     });
            //     $('#cb-prsid').combobox('textbox').focus();
            //     exit;   
            // } 

            $('#dg').datagrid('load', {
                TDATE: $('#dt-tdate').datebox('getValue'),
                // PRSID: $('#cb-prsid').combobox('getValue'),
            });
        }

        function doSearchReset() {
            $('#dt-tdate').datebox('reset');
            // $('#cb-stg_id').combobox('reset');

        }

        function basedOnStart_SP1END(val,row,lol){

            var startTime = row.PRSSP_SRT1_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_SP2END(val,row,lol){

            var startTime = row.PRSSP_SRT2_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_SP3END(val,row,lol){

            var startTime = row.PRSSP_SRT3_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_SP4END(val,row,lol){

            var startTime = row.PRSSP_SRT4_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_SP5END(val,row,lol){

            var startTime = row.PRSSP_SRT5_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
        }

        function basedOnStart_SP6END(val,row,lol){

            var startTime = row.PRSSP_SRT6_DISP;
            if( startTime != null){
                var result = '';
            } else {
                var result = val;
            }
            return  result;
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
        

        function hmFormat(val,row){

            var returnVal ='';
            var lengthVal = val.length;

            if(val != null){
                var Jam = val.substr(0,lengthVal-4);
                var Menit = val.substr(lengthVal-4,2);
                var Detik = val.substr(lengthVal-2,2);


                returnVal = Jam+'.'+Menit+'.'+Detik;
            } 
            return  returnVal;
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

            var url = "<?php  echo site_url() . '/../Content/LogSheet/logSheetPressStation/exportExcelFile?TDATE='; ?>"+dateParam;
            // var url = "<?php  //echo site_url() . '/../Content/LogSheet/logSheetPressStation/exportExcelFile?TDATE='; ?>"+dateParam+"&PRSID="+idParam;
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

             var url = "<?php  echo site_url() . '/../Content/LogSheet/logSheetPressStation/exportPDFFile?TDATE='; ?>"+dateParam;
            // var url = "<?php // echo site_url() . '/../Content/LogSheet/logSheetPressStation/cekPdfView?TDATE='; ?>"+dateParam+"&PRSID="+idParam;
            window.open(url, "_blank");
    }

    </script>   
