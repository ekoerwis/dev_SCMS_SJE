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
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/Report/HMMachine/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
                    fitColumns:false,
                    pagination:true,
                    pageSize:50,
                    showFooter: true,
                    nowrap:false,
                    singleSelect:true,
                    rownumbers: true,
                    view:groupview,
                    groupField:'MONTHYEAR',
                    groupFormatter:function(value,rows){
                        return value + '  (' + rows.length + ' Tanggal)';
                    },
                    frozenColumns:[[
                        {field:'LHPDT',title:'TANGGAL',width:80,align:'center'},
                    ]],
                    ">
        <thead>
            <tr>
                <!-- <th rowspan="2" field="DATENUMBER" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>DATE NUMBER</b></th> -->
                <!-- <th rowspan="2" field="MONTHNUMBER" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>MONTH NUMBER</b></th> -->
                <!-- <th rowspan="2" field="YEARNUMBER" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>YEAR NUMBER</b></th> -->
                <th colspan="4" ><b>LOADING RAMP STATION</b></th>
                <th colspan="4" ><b>STERILIZER</b></th>
                <th colspan="12" ><b>THRESER STATION</b></th>
                <th colspan="12" ><b>PRESS STATION</b></th>
                <th colspan="6" ><b>CLARIFICATION</b></th>
                <th colspan="10" ><b>KERNEL</b></th>
            </tr>
            <tr>
                <th field="LDRCVR11" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>CONV. 1.1</b></th>
                <th field="LDRCVR12" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>CONV.1.2</b></th>
                <th field="LDRCVR21" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>CONV.2.1</b></th>
                <th field="LDRBSP11" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>BSP</b></th>

                <th field="STZFDC01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>FDC</b></th>
                <th field="STZSFC01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>SFC</b></th>
                <th field="STZCPMP1" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>CPM1</b></th>
                <th field="STZCPMP2" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>CPM2</b></th>

                <th field="THRTHR01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>THR1</b></th>
                <th field="THRTHR02" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>THR2</b></th>
                <th field="THRTHR03" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>THR3</b></th>
                <th field="THRTHR04" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>THR4</b></th>
                <th field="THRCRC01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>CSV1</b></th>
                <th field="THRCRC02" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>CSV2</b></th>
                <th field="THRBNC01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>BNC1</b></th>
                <th field="THRBNP01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>BNP1</b></th>
                <th field="THRBNP02" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>BNP2</b></th>
                <th field="THRSTC01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>STC</b></th>
                <th field="THRPMP01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>PMP1</b></th>
                <th field="THRPMP02" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>PMP2</b></th>

                <th field="PRSDIG01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>DGT1</b></th>
                <th field="PRSDIG02" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>DGT2</b></th>
                <th field="PRSDIG03" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>DGT3</b></th>
                <th field="PRSDIG04" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>DGT4</b></th>
                <th field="PRSDIG05" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>DGT5</b></th>
                <th field="PRSPRS01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>SCP1</b></th>
                <th field="PRSPRS02" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>SCP2</b></th>
                <th field="PRSPRS03" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>SCP3</b></th>
                <th field="PRSPRS04" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>SCP4</b></th>
                <th field="PRSPRS05" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>SCP5</b></th>
                <th field="PRSCBC01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>CBC1</b></th>
                <th field="PRSCBC02" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>CBC2</b></th>

                <th field="CLRDCT01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>DCT1</b></th>
                <th field="CLRDCT02" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>DCT2</b></th>
                <th field="CLRDSR01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>DSR1</b></th>
                <th field="CLRDSR02" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>DSR2</b></th>
                <th field="CLRTST01" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>TST1</b></th>
                <th field="CLRSPR2" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>SPR2</b></th>

                <th field="KERRPM1" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>RPM1</b></th>
                <th field="KERRPM2" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>RPM2</b></th>
                <th field="KERRPM3" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>RPM3</b></th>
                <th field="KERRPM4" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>RPM4</b></th>
                <th field="KERHDC11" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>HDS1.1</b></th>
                <th field="KERHDC12" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>HDS1.2</b></th>
                <th field="KERHDC13" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>HDS1.3</b></th>
                <th field="KERHDC21" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>HDS2.1</b></th>
                <th field="KERHDC22" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>HDS2.2</b></th>
                <th field="KERHDC23" halign="center" data-options="sortable:false,width:80,align:'right' " formatter="hmFormat"><b>HDS2.3</b></th>
            </tr>
        </thead>
    </table>

    <div id="tb-pv" class="pb-1 pt-1">        
        <div class='col-xl-12 col-lg-12 col-md-12 row'>
            <div class="col row">
                <!-- <input id="dt-tdate" name="TDATE" class="easyui-datebox" style="width: 150px;"  data-options="required:true"> -->
                <!-- <input id="cb-stationid" name="STATIONID" class="" style="width:100px;" > -->
                <!-- <div class="col-xl-3 col-lg-3 col-md-3 row"> -->
                <input id="cb-Year" name="YEARNUMBER" class="" style="width: 150px;">
                <input id="cg-MonthNumber" name="MONTHNUMBER" class="" style="width: 200px;"  data-options="required:true" prompt="Month">
                    
                <!-- </div> -->
            </div>
            
            <div class=" col-md-auto  text-right">
                <button id="btn-search" class="btn btn-primary" style="width: 75px;"  onclick="doSearch()"><i class="fas fa-search"></i> Search</button>
                &nbsp;
                <button id="btn-searchReset" class="btn btn-danger" style="width: 75px;"  onclick="doSearchReset()"><i class="fas fa-eraser"></i> Clear</button>
                &nbsp;
                <button id="btn-print" class="btn btn-success" style="width: 75px;" onclick="exportDataExcel()" ><i class="fas fa-print"></i> .Xlsx</button>
                &nbsp;
                <!-- <button id="btn-print" class="btn btn-warning" style="width: 75px;" onclick="exportDataPDF()" ><i class="fas fa-print"></i> .Pdf</button> -->
            </div>
        </div>

    </div>
    <!-- </form> -->


    <script type="text/javascript">
        $(document).ready(function() {

            // settingCalendarTDATE();            

            
            generateParamMonth();
            generateParamYear ();

            doSearch();

        });

        function generateParamMonth(){
            
            const d = new Date();
            let month = d.getMonth()+1;

            $('#cg-MonthNumber').combogrid({
                panelWidth: 400,
                // url: "<?php //echo site_url().'/../content/VHActivity/getVehicleNotInPeriod?periodrange=';?>"+$('#tb-periodrange').textbox('getValue'),
                url: "<?php echo site_url().'/../content/Report/HMMachine/getMonth';?>",
                idField:'ID',
                textField:'DESCRIPTION',
                mode:'remote',
                loadMsg:'Loading',
                pagination: true,
                rownumbers:true,
                fitColumns:true,
                multiple:false,
                value:month,
                columns: [[
                    {field:'ID',title:'Code',width:100},
                    {field:'DESCRIPTION',title:'Name',width:200},
                ]],
                onSelect: function(index,row){

                }
            });
        }

        function generateParamYear (){
            const d = new Date();
            let year = d.getFullYear();

            $('#cb-Year').combobox({
                url:"<?php echo site_url().'/../content/Report/HMMachine/getYear';?>",
                valueField:'ID',
                textField:'DESCRIPTION',
                prompt:"Tahun",
                required:true,
                value:year,
            });
        }

        function getMonthName(monthNumber) {
            const date = new Date();
            date.setMonth(monthNumber - 1);

            return date.toLocaleString('en-US', { month: 'long' });
        }


        
        // JS Searching and Reset
        function doSearch() {

            var yearParam = $('#cb-Year').combobox('getValue');
            var monthParam =  $('#cg-MonthNumber').combogrid('getValue');

            // alert(yearParam + '-'+monthParam);

            if( yearParam.trim() == '' || yearParam.trim() == null ){
                // alert('"Tanggal" Harus Di Isi Dahulu');
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Tahun Harus Di Pilih Dahulu ! '
                });
                $('#cb-Year').combobox('textbox').focus();
                exit;   
            } 

            $('#dg').datagrid('load', {
                YEAR: yearParam,
                MONTH: monthParam,
            });
        }

        function doSearchReset() {
            $('#dt-tdate').datebox('reset');
            // $('#cb-stationid').combobox('reset');

        }


        
        function exportDataPDF() {
        
            var dateParam = $('#dt-tdate').datebox('getValue');
            // var idParam =  $('#cb-stationid').combobox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                $.messager.alert({    
                    title: 'Info',
                    msg: 'Tanggal Harus Di Isi Dahulu ! '
                });
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 


             var url = "<?php  echo site_url() . '/../Content/Report/HMMachine/exportPDFFile?TDATE='; ?>"+dateParam;
            window.open(url, "_blank");
        }

        // function exportDataExcel() {
        
        //         $('#dg').datagrid('toExcel', 'datagrid.xls');
        // }

        function exportDataExcel() {
        
            var yearParam = $('#cb-Year').combobox('getValue');
            var monthParam =  $('#cg-MonthNumber').combogrid('getValue');

            if( yearParam.trim() == '' || yearParam.trim() == null ){
                alert('"Tahun" Harus Di Isi Dahulu');
                $('#cb-Year').combobox('textbox').focus();
                exit;   
            } 

            var url = "<?php  echo site_url() . '/../Content/Report/HMMachine/exportExcelFile?YEAR='; ?>"+yearParam+"&MONTH="+monthParam;
            window.open(url, "_blank");
        }

        function formatNumberColumnCostum(val,row){
            // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var returnVal ='';
            if(val != null){
                returnVal = parseFloat(val).format(2, 3, ',', '.');
            } 
            return  returnVal;
        }

        function frm_Integer(val,row){
            // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var returnVal ='';
            if(val != null){
                returnVal = parseFloat(val).format(0, 3, ',', '.');
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


                returnVal = Jam+' '+Menit+' '+Detik;
            } 
            return  returnVal;
        }

        function formatNumberColumnCostumNull(val,row){
            // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var returnVal ='';
            if(val != null){
                if(val != 0){
                    returnVal = parseFloat(val).format(0, 3, ',', '.');
                }
            } 
            return  returnVal;
        }

        function gearBoxBaik(val,row){

            var returnVal ='';
            if(  Number(val) == 1 ){
                returnVal = '<i class="fas fa-check"></i>';
            } 
            return  returnVal;
        }

        function gearBoxNormal(val,row){

            var returnVal ='';
            if( Number(val) == 2){
                returnVal = '<i class="fas fa-check"></i>';
            } 
            return  returnVal;
        }

        function gearBoxKurang(val,row){

            var returnVal ='';
            if(Number(val) == 3){
                returnVal = '<i class="fas fa-check"></i>';
            } 
            return  returnVal;
        }
        
        function imageTrueFalse(val,row){

            var returnVal ='';
            if(val > 0){
                returnVal = '<i class="fas fa-check"></i>';
            } else {
                returnVal = '<i class="fas fa-times" style="color: red;"></i>';
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

    </script>   
