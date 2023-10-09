<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<body>
	<!--- DATA GRID ------------------------------------------------------------------------->
  <table id="dg" title="" class="easyui-datagrid" style="<?php echo $tinggi_dg ; ?>"
      url="<?php echo site_url().'/../Content/Form/noteUser/dataList'; ?>"
      toolbar="#tb-pv"
      data-options="striped:true,
                    fitColumns:false,
                    pagination:true,
                    nowrap:false,
                    pageSize:50,
                    rownumbers:true,
                    singleSelect:true,
                    frozenColumns:[[
                        {field:'POSTDT2',title:'Tanggal',width:100,align:'',halign:'center',sortable:true},
                    ]],
                    ">
                    
                    <!-- frozenColumns:[[
                        {field:'JVNO',title:'No. JV',width:180,align:'',halign:'center'},
                    ]], -->
  <thead>
    <tr>
        <!-- <th field="CRTTS" halign="center" data-options="sortable:false,width:200,align:'' " formatter=""><b>Tanggal Buat</b></th>
        <th field="CRTBY" halign="center" data-options="sortable:false,width:200,align:'' " formatter=""><b>Dibuat Oleh</b></th>
        <th field="UPDTS" halign="center" data-options="sortable:false,width:200 " formatter=""><b>Tanggal Ubah</b></th>
        <th field="UPDBY" halign="center" data-options="sortable:false,width:250 " formatter=""><b>Diubah Oleh</b></th> -->
        <!-- <th field="POSTDT" halign="center" data-options="sortable:false,width:80,align:'' " formatter=""><b>Tanggal</b></th> -->
        <!-- <th field="POSTDT2" halign="center" data-options="sortable:false,width:80 " formatter=""><b>Tanggal</b></th> -->
        <th field="USERID" halign="center" data-options="sortable:false,width:80,align:'' " formatter=""><b>User</b></th>
        <th field="STATIONID" halign="center" data-options="sortable:false,width:80 " formatter=""><b>Station ID</b></th>
        <th field="ULGNOTE" halign="center" data-options="sortable:false,width:200 " formatter=""><b>Note</b></th>
    </tr>
  </thead>
</table>
<!--- END GRID ------------------------------------------------------------------------->
<!--- BUTTON TAMBAH EDIT DELETE GRID ---------------------------------------------------------->
<div id="tb-pv" style="height:35px;">
  <div class='cols-crud cols-crud-tabp cols-crud-tabl cols-crud-mobp cols-crud-mobl'>
    <?php if(strtolower($auth_tambah) == 'yes'){ ?>
      <a href="javascript:void(0)"
        class="easyui-linkbutton icon-crud icon-crud-tabp icon-crud-tabl icon-crud-mobp icon-crud-mobl"
        iconCls="icon-add" plain="true"  onclick="addData()"
		style="height:25px;line-height:25px;color:white;background: #00a300;">
        <b class="texthidden-tabp texthidden-mobp">Add</b></a>
      <?php }?>
      <?php if(strtolower($auth_ubah) == 'all'){ ?>
        <a href="javascript:void(0)"
        class="easyui-linkbutton icon-crud icon-crud-tabp icon-crud-tabl icon-crud-mobp icon-crud-mobl"
        iconCls="icon-edit" plain="true" onclick="updateData()"
        style="height:25px;line-height:25px;color:white;background:#ffc40d;">
        <b class="texthidden-tabp texthidden-mobp">Edit</b></a>
      <?php }?>
      <?php if(strtolower($auth_hapus) == 'all'){ ?>
        <a href="javascript:void(0)"
        class="easyui-linkbutton btndisabled icon-crud icon-crud-tabp icon-crud-tabl icon-crud-mobp icon-crud-mobl"
        iconCls="icon-remove" plain="true" onclick="deleteData()"
        style="height:25px;line-height:25px;color:white;background:#ee1111;">
        <b class="texthidden-tabp texthidden-mobp">Delete</b></a>
      <?php }?>
  </div>
  <div class='cols-search cols-search-tabp cols-search-tabl cols-search-mobp cols-search-mobl'>
    <div class="cg-search cg-search-tabp cg-search-tabl cg-search-mobp cg-search-mobl">
      <div class="row" style="height:25px;width:100%; padding: 0px 0px 0px 15px;">
        <input id="p_cgrid" class="easyui-textbox" style="height:25px;width:90%;" prompt="Cari Keyword Station / Note"></input> 
      </div>
    </div>
    <div class="icon-cari icon-cari-tabp icon-cari-tabl icon-cari-mobp icon-cari-mobl">
      <a href="#" class="easyui-linkbutton" plain="true" iconCls="icon-search" onclick="doSearch()"
      style="width:45%;height:25px;line-height:25px;background:#99b433;"></a>
      <a href="#" class="easyui-linkbutton" plain="true" iconCls="icon-reload" onclick="doSearchReset()"
      style="width:45%;height:25px;line-height:25px;background:#99b433;"></a>
    </div>
  </div>
</div>

<script type="text/javascript">

$(document).ready(function(){


});


// JS Searching and Reset
function doSearch(){
    
    $('#dg').datagrid('load',{
            SEARCH_KEYWORD: $('#p_cgrid').textbox('getValue'),
            });
    
}

function doSearchReset(){
  
    $('#p_cgrid').textbox('reset'),


  doSearch();
  
}


//JS addData
function addData(){

    url = "<?php echo site_url().'/../Content/Form/noteUser/addForm'; ?>" ;
        window.open(url,"_self");
}

//JS Update
function updateData(){

    $.messager.alert({
        title: 'Info',
        msg: 'Modul Ini Tidak DiIzinkan Melakukan Proses Ubah',
    });
    
    
    // fitur dimatikan tp script dibawah ini jalan, jika proses Ubah ingin dibuka , matikan script atas dan hidupkan yang bawah

    // var row = $('#dg').datagrid('getSelected');
    //     if (row){
    //         url = "<?php //echo site_url().'/../Content/Portal/ReportMaster/editForm?id='; ?>" +row.ID;
    //         window.open(url,"_self");        
    //     }
}

// JS Delete
function deleteData(){
    $.messager.alert({
        title: 'Info',
        msg: 'Modul Ini Tidak DiIzinkan Melakukan Proses Delete',
    });
    
    
    // fitur dimatikan tp script dibawah ini jalan, jika proses delete ingin dibuka , matikan script atas dan hidupkan yang bawah
    // var row = $('#dg').datagrid('getSelected');
    // if (row){
        
    //       $.messager.confirm('Confirm','Hapus Data: '+ row.KODE_REPORT + ' : ' +row.NAMA_REPORT +' ?' ,function(r){
    //           if (r){
    //           $.ajax({
    //                   type: "POST",
    //                   url: "<?php //echo site_url().'/../Content/Portal/ReportMaster/deleteData' ; ?>",
    //                   data: {
    //                   id:row.ID,
    //                   },
    //                   success: function (result) {
    //                       console.log(result);
    //                       obj = JSON.parse(result);
    //                       $.messager.alert({
    //                           title: 'Alert',
    //                           msg: obj.msg.content,
    //                       });

    //                       $('#dg').datagrid('reload');
                          
    //                   },
    //                   error: function (result, status) {
    //                       console.log(result);
    //                       $.messager.show({    // show error message
    //                           title: 'Error',
    //                           msg: 'Error Proses Post, Hubungi Administrator !'
    //                       });


    //                   }
    //               });
    //           }
    //       });
    // }
}

// END JS Delete


function formatNumberColumnCostum(val,row){
  // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  var returnVal ='';
  if(val != null){
      returnVal = parseFloat(val).format(0, 3, ',', '.');
  } 
  return  returnVal;
}

function reversedImage(val,row){

  var returnVal ='';
  if(val > 0){
      returnVal = '<i class="fas fa-check"></i>';
  } 
  return  returnVal;
}

function formatterReferTo(val,row){
  // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  returnVal = '';
  if(Number(val) > 0){
    returnVal = val+' Documents';
  } 
  
  return  returnVal;
}



// $('#dg').datagrid({
//   onDblClickRow:function(){
//      viewDataSelected();
//   }
// });

// JS View Selected
// function viewDataSelected(){
//     var row = $('#dg').datagrid('getSelected');
//     if (row){
//         url = "<?php // echo site_url().'/../Content/Portal/ReportMaster/viewData?id='; ?>" +row.JVNO;
//         window.open(url,"_self");
//     }
// }

</script>
</body>


