<style type="text/css">
	.datagrid-header .datagrid-cell{
		line-height:normal;
		/* height:auto; */
	    white-space: normal;
	}
</style>
    
    <!--- DATA GRID ------------------------------------------------------------------------->
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/LogSheet/logSheetSterilizer/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
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
                <th field="STZID" halign="center" data-options="sortable:false,width:80,align:'left' " formatter="" rowspan="2"><b>Sterilizer</b></th>
                <th colspan="3"><b>Buah Masuk</b></th>
                <!-- <th field="STZIN_MN" halign="center" data-options="sortable:false,width:80,align:'center' " formatter="" rowspan="2"><b>Waktu</b></th> -->
                <th colspan="3"><b>Merebus</b></th>
                <!-- <th field="STZPRO_MN" halign="center" data-options="sortable:false,width:80,align:'center' " formatter="" rowspan="2"><b>Waktu</b></th> -->
                <th colspan="3"><b>Keluar Buah</b></th>
                <!-- <th field="STZOUT_MN" halign="center" data-options="sortable:false,width:80,align:'center' " formatter="" rowspan="2"><b>Waktu</b></th> -->
                <th field="STZTM_TOT" halign="center" data-options="sortable:false,width:100,align:'center' " formatter="" rowspan="2"><b>Total Waktu</b></th>
                <!-- <th field="STZACC" halign="center" data-options="sortable:false,width:100,align:'left' " formatter="" rowspan="2"><b>Paraf Mandor</b></th> -->
                <!-- <th field="STZNOTE" halign="center" data-options="sortable:false,width:200,align:'left' " formatter="" rowspan="2"><b>Keterangan</b></th> -->
            </tr>
            <tr>
                <th field="STZIN_ST_TIME" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>Start</b></th>
                <th field="STZIN_ED_TIME" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>Stop</b></th>
                <th field="STZIN_MN" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>Waktu</b></th>
                <th field="STZPRO_ST_TIME" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>Start</b></th>
                <th field="STZPRO_ED_TIME" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>Stop</b></th>
                <th field="STZPRO_MN" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>Waktu</b></th>
                <th field="STZOUT_ST_TIME" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>Start</b></th>
                <th field="STZOUT_ED_TIME" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>Stop</b></th>
                <th field="STZOUT_MN" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>Waktu</b></th>
            </tr>
        </thead>
    </table>

    <div id="tb-pv" class="pb-1 pt-1">        
        <div class='col-xl-12 col-lg-12 col-md-12 row'>
            <div class="col row">
                <input id="dt-tdate" name="TDATE" class="easyui-datebox" style="width: 150px;"  data-options="required:true">
                <input id="cb-dt_div" name="DT_DIV" class="" style="width:100px;" >
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
                <button id="btn-print" class="btn btn-success" style="width: 75px;" onclick="exportDataExcel()" ><i class="fas fa-print"></i> .Xlsx</button>
                &nbsp;
                <button id="btn-print" class="btn btn-warning" style="width: 75px;" onclick="exportDataPDF()" ><i class="fas fa-print"></i> .Pdf</button>
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
                        "text": '1',
                        "selected":true
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

           
            var paramDate = "<?php if(isset($_GET['POSTDT'])) { echo $_GET['POSTDT'];}  ?>";

            if(paramDate != ''){    
                doSearch();
                console.log('POSTDATE not null');
            } 

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

            // console.log(paramDate);

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
            // var yearNumber =  $('#tb-Year').numberbox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                alert('"Tanggal" Harus Di Isi Dahulu');
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            // if( yearNumber.trim() == '' || yearNumber.trim() == null ){
            //     alert('"Year" Harus Di Isi Dahulu');
            //     $('#tb-Year').textbox('textbox').focus();
            //     exit;   
            // } 

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

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                alert('"Tanggal" Harus Di Isi Dahulu');
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            var url = "<?php  echo site_url() . '/../Content/LogSheet/logSheetSterilizer/exportExcelFile?TDATE='; ?>"+dateParam+"&DT_DIV="+dtDivParam;
            window.open(url, "_blank");
        }

        function exportDataPDF() {
        
            var dateParam = $('#dt-tdate').datebox('getValue');
            var dtDivParam =  $('#cb-dt_div').combobox('getValue');

            if( dateParam.trim() == '' || dateParam.trim() == null ){
                alert('"Tanggal" Harus Di Isi Dahulu');
                $('#dt-tdate').datebox('textbox').focus();
                exit;   
            } 

            var url = "<?php  echo site_url() . '/../Content/LogSheet/logSheetSterilizer/exportPDFFile?TDATE='; ?>"+dateParam+"&DT_DIV="+dtDivParam;
            window.open(url, "_blank");
    }

    </script>   
