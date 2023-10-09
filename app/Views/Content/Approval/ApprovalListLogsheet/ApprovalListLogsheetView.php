<style type="text/css">
	.datagrid-header .datagrid-cell{
		line-height:normal;
		/* height:auto; */
	    white-space: normal;
	}
</style>
    
    <!--- DATA GRID ------------------------------------------------------------------------->
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/Approval/ApprovalListLogsheet/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
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
                <!-- <th field="MONTHNUMBER" halign="center" data-options="sortable:false,width:120,align:'center' " formatter=""><b>MONTHNUMBER</b></th>
                <th field="YEARNUMBER" halign="center" data-options="sortable:false,width:120,align:'center' " formatter=""><b>YEARNUMBER</b></th>
                <th field="ID" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>ID</b></th>
                <th field="IDHEADER" halign="center" data-options="sortable:false,width:100,align:'center' " formatter=""><b>IDHEADER</b></th>
                <th field="LVL" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>LVL</b></th>
                <th field="IDROLE" halign="center" data-options="sortable:false,width:60,align:'center' " formatter=""><b>IDROLE</b></th>
                <th field="IDCONTENT" halign="center" data-options="sortable:false,width:80,align:'center' " formatter=""><b>IDCONTENT</b></th>
                <th field="REMARKS" halign="center" data-options="sortable:false,width:80,align:'' " formatter=""><b>REMARKS</b></th>
                <th field="MAXLEVEL" halign="center" data-options="sortable:false,width:80,align:'' " formatter=""><b>MAXLEVEL</b></th>
                <th field="IDMODULE" halign="center" data-options="sortable:false,width:80,align:'' " formatter=""><b>IDMODULE</b></th>
                <th field="TABLECONTENT" halign="center" data-options="sortable:false,width:150,align:'' " formatter=""><b>TABLECONTENT</b></th>
                <th field="NAMA_MODULE" halign="center" data-options="sortable:false,width:150,align:'' " formatter=""><b>NAMA_MODULE</b></th> -->
                <th field="JUDUL_MODULE" halign="center" data-options="sortable:false,width:150,align:'' " formatter=""><b>Log Sheet</b></th>
                <!-- <th field="DESKRIPSI" halign="center" data-options="sortable:false,width:150,align:'' " formatter=""><b>DESKRIPSI</b></th> -->
                <th field="TOTALLSMONTH" halign="center" data-options="sortable:false,width:100,align:'center' " formatter="goToLogsheetPage"><b>Total</b></th>
                <th field="COUNTFINISHLS" halign="center" data-options="sortable:false,width:100,align:'center' " formatter=""><b>Finish</b></th>
                <th field="UNFINISHLS" halign="center" data-options="sortable:false,width:100,align:'center' " formatter=""><b>On Progress</b></th>
                <th field="COUNTNEEDACTION" halign="center" data-options="sortable:false,width:100,align:'center' " formatter="goToNeedActionPage"><b>Need Action</b></th>
            </tr>
        </thead>
    </table>

    <div id="tb-pv" class="pb-1 pt-1">        
        <div class='col-xl-12 col-lg-12 col-md-12 row'>
            <div class="col row">
                <input id="nb-year" name="YEARNUMBER" class="easyui-numberbox" style="width: 150px;"  data-options="required:true">
                <input id="cb-month" name="MONTHNUMBER" class="" style="width:150px;" >
                <!-- <div class="col-xl-3 col-lg-3 col-md-3 row"> -->
                    <!-- <input id="tb-Year" name="YEARNUMBER" class="easyui-numberbox " style="width: 100px;"  data-options="required:true" prompt="Year"> -->
                    <!-- <input id="cg-MonthNumber" name="MONTHNUMBER" class="easyui-combogrid" style="width: 200px;"  data-options="required:true" prompt="Month"> -->
                    
                <!-- </div> -->
            </div>
            
            <div class=" col-md-auto  text-right">
                <button id="btn-search" class="btn btn-primary" style="width: 75px;"  onclick="doSearch()"><i class="fas fa-search"></i> Search</button>
                &nbsp;
                <button id="btn-searchReset" class="btn btn-danger" style="width: 75px;"  onclick="doSearchReset()"><i class="fas fa-eraser"></i> Clear</button>
                <!-- &nbsp;
                <button id="btn-print" class="btn btn-success" style="width: 75px;" onclick="exportDataExcel()" ><i class="fas fa-print"></i> .Xlsx</button>
                &nbsp;
                <button id="btn-print" class="btn btn-warning" style="width: 75px;" onclick="exportDataPDF()" ><i class="fas fa-print"></i> .Pdf</button> -->
            </div>
        </div>

    </div>
    <!-- </form> -->


    <script type="text/javascript">
        $(document).ready(function() {

            
            $('#cb-month').combobox({
                valueField: 'id',
                textField: 'text',
                prompt:"MONTH",
                data : optionMonth
            });
            
            settingCalendarTDATE();

            doSearch();

        });

        optionMonth = [
                    {
                        "id": '1',
                        "text": 'Januari',
                    },
                    {
                        "id": '2',
                        "text": 'Febuari'
                    },
                    {
                        "id": '3',
                        "text": 'Maret'
                    },
                    {
                        "id": '4',
                        "text": 'April'
                    },
                    {
                        "id": '5',
                        "text": 'Mei'
                    },
                    {
                        "id": '6',
                        "text": 'Juni'
                    },
                    {
                        "id": '7',
                        "text": 'Juli'
                    },
                    {
                        "id": '8',
                        "text": 'Agustus'
                    },
                    {
                        "id": '9',
                        "text": 'September'
                    },
                    {
                        "id": '10',
                        "text": 'Oktober'
                    },
                    {
                        "id": '11',
                        "text": 'November'
                    },
                    {
                        "id": '12',
                        "text": 'Desember'
                    },
                ];

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


            $('#nb-year').numberbox({
                value :  newD.getFullYear(),
            });

            $('#cb-month').combobox({
                value :  newD.getMonth()+1,
                onSelect:function(data){
                    // console.log(data.id);
                }
            });

        }


        // JS Searching and Reset
        function doSearch() {

            var yearParam = $('#nb-year').numberbox('getValue');
            // var yearNumber =  $('#tb-Year').numberbox('getValue');

            if( yearParam.trim() == '' || yearParam.trim() == null ){
                alert('"Tahun" Harus Di Isi Dahulu');
                $('#nb-year').numberbox('textbox').focus();
                exit;   
            } 

            // if( yearNumber.trim() == '' || yearNumber.trim() == null ){
            //     alert('"Year" Harus Di Isi Dahulu');
            //     $('#tb-Year').textbox('textbox').focus();
            //     exit;   
            // } 

            // console.log($('#nb-year').numberbox('getValue')+" - "+$('#cb-month').combobox('getValue'));

            $('#dg').datagrid('load', {
                YEARNUMBER: $('#nb-year').numberbox('getValue'),
                MONTHNUMBER: $('#cb-month').combobox('getValue'),
            });
        }

        function doSearchReset() {
            $('#nb-year').numberbox('reset');
            $('#cb-month').combobox('reset');

        }

        function formatNumberColumnCostum(val,row){
            // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var returnVal ='';
            if(val != null){
                returnVal = parseFloat(val).format(2, 3, ',', '.');
            } 
            return  returnVal;
        }

        function goToLogsheetPage(value,row){
            var href = '../Approval/ApprovalListLogsheet/goToStatusPage?MONTHNUMBER='+row.MONTHNUMBER+'&YEARNUMBER='+row.YEARNUMBER+'&IDMODULE='+row.IDMODULE;
            return '<a target="_blank" href="' + href + '"> <button type="button" class="btn btn-primary"> '+value+'</button></a>';
        }

        function goToFinishLSPage(value,row){
            var href = '../Approval/ApprovalListLogsheet/goToStatusPage?MONTHNUMBER='+row.MONTHNUMBER+'&YEARNUMBER='+row.YEARNUMBER+'&IDMODULE='+row.IDMODULE;
            return '<a target="_blank" href="' + href + '"> <button type="button" class="btn btn-success"> '+value+'</button></a>';
        }

        function goToUnfinishLSPage(value,row){
            var href = '../Approval/ApprovalListLogsheet/goToStatusPage?MONTHNUMBER='+row.MONTHNUMBER+'&YEARNUMBER='+row.YEARNUMBER+'&IDMODULE='+row.IDMODULE;
            return '<a target="_blank" href="' + href + '"> <button type="button" class="btn btn-info"> '+value+'</button></a>';
        }

        function goToNeedActionPage(value,row){
            var href = '../Approval/ApprovalListLogsheet/goToNeedActionPage?MONTHNUMBER='+row.MONTHNUMBER+'&YEARNUMBER='+row.YEARNUMBER+'&IDMODULE='+row.IDMODULE;
            return '<a target="_blank" href="' + href + '"> <button type="button" class="btn btn-warning"> '+value+'</button></a>';
        }


    </script>   
