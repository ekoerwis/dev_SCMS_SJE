<style>

</style>

<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<body>

<div id="" class="easyui-panel panelresize"  title="" headerCls="headcls">
    <table id="tg-materialbalance" class="easyui-treegrid"  style="width:100%;<?php echo $tinggi_dg; ?>"
        url="<?php echo current_url().'/getMaterialBalance'; ?>"  toolbar="#master-tools"
        data-options="striped:false,
        fitColumns:false,
        pagination:false,
        nowrap:true,
        rownumbers:false,
        singleSelect:true,
        collapsible: true,
        idField:'PARAMETERCODE',
        treeField:'PARAMETERNAME',
        lines:true
        ">
        <thead>
          <tr>
            <th field="PARAMETERCODE" halign="center" data-options="sortable:false,width:100"><b>Code</b></th>
            <th field="PARAMETERNAME" halign="center" data-options="sortable:false,width:450"><b>Name</b></th>
            <th field="VALUE" halign="center"  data-options="sortable:false,width:100,align:'right'"  formatter="formatNumberColumnCostum"><b>Nilai</b></th>
          </tr>
        </thead>
      </table>
</div>


    <div id="master-tools" class="col row ml-2">
        <div id="tb-pv" class="col-md-6 row"> 
            <a class="btn btn-danger" onclick="CollapseMaster()" style="color:white"><i class="fa fa-chevron-up"></i> Collapse </a>
            &nbsp;
            <a class="btn btn-warning" onclick="ExpandMaster()" style="color:white"><i class="fa fa-chevron-down"></i> Expand </a>
        </div>

        <div class="tombolaksi col-md-6 row text-right align-content-end justify-content-end">
            <?php if(strtolower($auth_tambah) == 'yes'){ ?>
                <a href="javascript:void(0)" class="btn btn-success" onclick="addFormMaster()"
                style="color:white;background: #00a300;width:80px">
                <i class="fa fa-plus" aria-hidden="true"></i> Add </a> &nbsp;&nbsp;
            <?php }?>
            <?php if(strtolower($auth_ubah) == 'all'){ ?>
                <a href="javascript:void(0)" class="btn btn-warning btndisabled" onclick="updateFormMaster()"
                style="color:white;background:#ffc40d;width:80px">
                <i class="fas fa-pencil-alt"></i> Edit </a>&nbsp;&nbsp;
            <?php }?>
            <?php if(strtolower($auth_hapus) == 'all'){ ?>
                <a href="javascript:void(0)" class="btn btn-danger btndisabled" onclick="deleteMaster()"
                style="color:white;background:#ee1111;width:80px">
                <i class="fa fa-trash" aria-hidden="true"></i> Delete </a>
            <?php }?>
        </div>
    </div>

    <?php include ('FormMaster.php'); ?> 

    <script>
    function ExpandMaster() { $('#tg-materialbalance').treegrid('expandAll'); }
    function CollapseMaster() { $('#tg-materialbalance').treegrid('collapseAll'); }
    </script>

    <script>
        

    $(document).ready(function(){
      $('#dlg-master').dialog('close');

    });
    </script>

    <script>

    $('#tg-materialbalance').treegrid({
        onLoadSuccess: function(data) {
            const dataMB = $(this).treegrid('getData');
            if (dataMB) {
                calculateAndLogValues(dataMB); // Panggil fungsi kalkulasi dan log hierarki
            } else {
                console.warn("Data tidak ditemukan");
            }
        },
      onBeforeSelect: function(row) {
        
      },
      onSelect: function (row) {
        
      },
    });
    

// Fungsi rekursif untuk menghitung total `VALUE` dan log hierarki
function calculateAndLogValues(data, level = 0) {
    data.forEach(node => {
        let totalValue = calculateTotalValue(node);
        console.log(`${' '.repeat(level * 2)}${node.PARAMETERNAME}: ${totalValue}`);

        // Memperbarui nilai total pada baris TreeGrid
        $('#tg-materialbalance').treegrid('updateRow', {
            index: node.PARAMETERCODE,  // Pastikan 'PARAMETERCODE' unik dan menjadi idField
            row: { VALUE: totalValue }  // Update kolom VALUE dengan totalValue yang dihitung
        });

        if (node.children && node.children.length) {
            calculateAndLogValues(node.children, level + 1);
        }
    });
}

// Fungsi untuk menghitung `VALUE` secara rekursif
function calculateTotalValue(node) {
    let total = parseFloat(node.VALUE) || 0;
    if (node.children && node.children.length) {
        node.children.forEach(child => {
            total += calculateTotalValue(child);
        });
    }
    return total;
}

    </script>

    <script>
    function addFormMaster(){
      $('#fm-master').form('clear');
      $('#button-savemaster').show();
      $('#button-updatemaster').hide();
      $('#dlg-master').dialog('open').dialog({
        title: 'Tambah  Material Balance',
        buttons: '#button-savemaster'
      });

    }

    function updateFormMaster(){
      var row = $('#tg-materialbalance').treegrid('getSelected');

      if (row){
            $("#master-value").numberbox('setValue',row.VALUE);
        if( row.children && row.children.length > 0 ){
            $('#master-value').textbox({
            readonly:true,
            });

        } else {
            $('#master-value').textbox({
            readonly:false,
            });
            //script form edit
        }

        $('#master-parametercode').textbox('setValue',row.PARAMETERCODE);
        $('#master-parametername').textbox('setValue',row.PARAMETERNAME);
        $('#master-parentcode').combogrid('setValue',row.PARENTCODE);
        $('#master-parentname').textbox('setValue',row.PARENTNAME);

        $('#button-savemaster').hide();
            $('#button-updatemaster').show();
            $('#dlg-master').dialog('open').dialog({
            title: 'Update Material Balance',
            buttons: '#button-updatemaster'
            });
      }
    }


    function deleteMaster(){
      var row = $('#tg-materialbalance').treegrid('getSelected');
      if (row){
        $.messager.confirm('Confirm','Hapus Kode PARAMETERCODE : '+ row.PARAMETERCODE,function(r){
          if (r){
            $.post('<?php echo current_url().'/deleteData' ; ?>',{id:row.PARAMETERCODE},
            function(result){
              $.messager.alert('Alert', 'Data Berhasil di hapus', 'info');
              $('#tg-materialbalance').treegrid('reload');
            },'json');
          }
        });
      }
    }



    function formatNumberColumnCostum(val,row){
            // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var returnVal ='';
            if(val != null){
                returnVal = parseFloat(val).format(1, 3, ',', '.');
            } 
            return  returnVal;
        }
    </script>
