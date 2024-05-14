<style>
/* Hide Icon Tree For use Font Awesome */
/* .tree-icon {
  background: url('images/tree_icons.png') no-repeat -224px 0;
}

.tree-folder, .tree-file {
  line-height: 18px;
} */
/* End Hide Icon */
</style>

<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<body>

<div id="" class="easyui-panel panelresize"  title="" headerCls="headcls">
  <div id="tt" class="easyui-tabs" tabWidth="165" data-options="tools:'#tab-tools'" style="width:100%">
    <div title="Material" style="padding:10px;">
      <table id="tg-material"  style="width:100%;<?php echo $tinggi_dg; ?>"
        url="<?php echo current_url().'/getMaterialList'; ?>"
        data-options="striped:false,
        fitColumns:false,
        pagination:true,
        nowrap:true,
        rownumbers:true,
        singleSelect:true,
        collapsible: true,
        idField:'ITEMCODE',
        treeField:'ITEMDESCRIPTION',
        lines:true
        ">
        <thead frozen="true">
          <tr>
            <th field="ITEMDESCRIPTION" halign="center" data-options="sortable:false,width:450"><b>Item Description</b></th>
            <th field="ITEMCODE" halign="center" align="center" data-options="sortable:false,width:85"><b>Item Code</b></th>
            <th field="GROUPCODE" halign="center" align="center" data-options="sortable:false,width:80"><b>Group Code</b></th>
            <th field="UOMCODE" halign="center" align="center" data-options="sortable:false,width:50"><b>UoM</b></th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th field="BRAND" halign="center" data-options="sortable:false,width:200"><b>Brand</b></th>
            <th field="PARTNO" halign="center" data-options="sortable:false,width:200"><b>Part No.</b></th>
            <th field="SPESIFICATION" halign="center" data-options="sortable:false,width:200"><b>Specification</b></th>
            <th field="GRADE" halign="center" data-options="sortable:false,width:80"><b>Grade</b></th>
            <th field="LIFETIME" halign="center" data-options="sortable:false,width:80"><b>Life Time</b></th>
            <th field="INACTIVEDATE" halign="center" data-options="sortable:false,width:100"><b>Inactive Date</b></th>
          </tr>
        </thead>
      </table>
    </div>

    <div title="Material Group" style="padding:10px;">
      <table id="tg-materialgroup" style="width:100%;<?php echo $tinggi_dg; ?>"
        url="<?php echo current_url().'/getMaterialGroup'; ?>"
        data-options="striped:false,
        fitColumns:true,
        pagination:true,
        nowrap:true,
        rownumbers:true,
        singleSelect:true,
        collapsible: true,
        idField:'GROUPCODE',
        treeField:'GROUPNAME',
        lines:true
        ">
        <thead>
          <tr>
            <th field="GROUPNAME" halign="center" data-options="sortable:false,width:300"><b>Group Name</b></th>
            <th field="GROUPCODE" halign="center" align="center" data-options="sortable:false,width:80"><b>Group Code</b></th>
            <th field="PARENT_GROUP_CODE" halign="center" align="center" data-options="sortable:false,width:80"><b>Parent Group Code</b></th>
            <th field="SEQ" halign="center" align="center" data-options="sortable:false,width:50"><b>Seq</b></th>
            <th field="INACTIVEDATE" halign="center" data-options="sortable:false,width:100"><b>Inactive Date</b></th>
          </tr>
        </thead>
      </table>
    </div>

    <div title="Stock Material" style="padding:10px;">
      <table id="tg-stockmaterial" style="width:100%;<?php echo $tinggi_dg; ?>"
        url="<?php echo current_url().'/getStockMaterial'; ?>"
        data-options="striped:false,
        fitColumns:true,
        pagination:true,
        nowrap:true,
        rownumbers:true,
        singleSelect:true,
        collapsible: true,
        idField:'ASSET_GROUP_ID',
        treeField:'DESCRIPTION',
        lines:true
        ">
        <thead frozen="true">
          <tr>
            <th field="GROUPCODE" halign="center" data-options="sortable:false,width:350"><b>Group Code</b></th>
            <th field="GROUPNAME" halign="center" data-options="sortable:false,width:80"><b>Group Name</b></th>
            <th field="ITEMCODE" halign="center" data-options="sortable:false,width:80"><b>Item Code</b></th>
            <th field="ITEMNAME" halign="center" align="center" data-options="sortable:false,width:50"><b>Item Name</b></th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th field="UOM" halign="center" data-options="sortable:false,width:80"><b>Uom</b></th>
            <th field="QTYONHAND" halign="center" data-options="sortable:false,width:250"><b>Qty On Hand</b></th>
            <th field="QTYONREQUEST" halign="center" data-options="sortable:false,width:100"><b>Qty On Request</b></th>
          </tr>
        </thead>
      </table>
    </div>

  </div>
</div>

  <div id="tab-tools">
    <div id="material-tools" >
      <a class="btn btn-danger" onclick="CollapseMaterial()" style="color:white"><i class="fa fa-chevron-up"></i> </a>
      <a class="btn btn-warning" onclick="ExpandMaterial()" style="color:white"><i class="fa fa-chevron-down"></i> </a>
      <input id="SearchMaterial" style="width:300px" class="easyui-combotreegrid" data-options="prompt:'Material'">&nbsp;

      <?php if(strtolower($auth_tambah) == 'yes'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="addFormMaterial()"
        style="color:white;background: #00a300;width:30px">
        <i class="fa fa-plus" aria-hidden="true"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_ubah) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="updateFormMaterial()"
        style="color:white;background:#ffc40d;width:30px">
        <i class="fas fa-pencil-alt"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_hapus) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton btndisabled" onclick="deleteMaterial()"
        style="color:white;background:#ee1111;width:30px">
        <i class="fa fa-trash" aria-hidden="true"></i> </a>
      <?php }?>
    </div>

    <div id="materialgroup-tools" >
      <a class="btn btn-danger" onclick="CollapseMaterialGroup()" style="color:white"><i class="fa fa-chevron-up"></i> </a>
      <a class="btn btn-warning" onclick="ExpandMaterialGroup()" style="color:white"><i class="fa fa-chevron-down"></i> </a>
      <input id="SearchMaterialGroup" style="width:300px" class="easyui-combogrid" data-options="prompt:'Material Group'">&nbsp;

      <?php if(strtolower($auth_tambah) == 'yes'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="addFormMaterialGroup()"
        style="color:white;background: #00a300;width:30px">
        <i class="fa fa-plus" aria-hidden="true"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_ubah) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="updateFormMaterialGroup()"
        style="color:white;background:#ffc40d;width:30px">
        <i class="fas fa-pencil-alt"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_hapus) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton btndisabled" onclick="deleteMaterialGroup()"
        style="color:white;background:#ee1111;width:30px">
        <i class="fa fa-trash" aria-hidden="true"></i> </a>
      <?php }?>
    </div>

    <div id="stockmaterial-tools" >
      <a class="btn btn-danger" onclick="CollapseStockMaterial()" style="color:white"><i class="fa fa-chevron-up"></i> </a>
      <a class="btn btn-warning" onclick="ExpandStockMaterial()" style="color:white"><i class="fa fa-chevron-down"></i> </a>
      <input id="SearchMaintenanceGroup" style="width:300px" class="easyui-combogrid" data-options="prompt:'Stock Material'">&nbsp;

      <?php if(strtolower($auth_tambah) == 'yes'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="addFormStockMaterial()"
        style="color:white;background: #00a300;width:30px">
        <i class="fa fa-plus" aria-hidden="true"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_ubah) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="updateFormStockMaterial()"
        style="color:white;background:#ffc40d;width:30px">
        <i class="fas fa-pencil-alt"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_hapus) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton btndisabled" onclick="deleteStockMaterial()"
        style="color:white;background:#ee1111;width:30px">
        <i class="fa fa-trash" aria-hidden="true"></i> </a>
      <?php }?>
    </div>

    </div>

    <?php include ('FormMaterial.php'); ?>
    <?php include ('FormMaterialGroup.php'); ?>

    <script>
    function ExpandMaterial() { $('#tg-material').treegrid('expandAll'); }
    function CollapseMaterial() { $('#tg-material').treegrid('collapseAll'); }
    function ExpandMaterialGroup() { $('#tg-materialgroup').treegrid('expandAll'); }
    function CollapseMaterialGroup() { $('#tg-materialgroup').treegrid('collapseAll'); }
    function ExpandStockMaterial() { $('#tg-stockmaterial').treegrid('expandAll'); }
    function CollapseStockMaterial() { $('#tg-stockmaterial').treegrid('collapseAll'); }
    </script>

    <script>
    // Change Icon Tree use font-awesome
    // $('#tg-material').treegrid({
    //   onLoadSuccess: function(row, data) {
    //     $('.tree-folder').addClass('fa fa-clipboard-list');
    //     $('.tree-file').addClass('fas fa-angle-double-right');
    //   }
    // });

    $(document).ready(function(){
      $('#materialgroup-tools').hide();
      $('#stockmaterial-tools').hide();
      $('#dlg-material').dialog('close');
      $('#dlg-materialgroup').dialog('close');
      $('#dlg-stockmaterial').dialog('close');

      $('#tt').tabs({
        onSelect: function(title, index){
          // Handle the onclick event for tabs here
          if (index == 0){
            $('#material-tools').show();
            $('#materialgroup-tools').hide();
            $('#stockmaterial-tools').hide();
            SearchMaterial();
          }
          if (index == 1){
            $('#material-tools').hide();
            $('#materialgroup-tools').show();
            $('#stockmaterial-tools').hide();
            SearchMaterialGroup();
          }
          if (index == 2){
            $('#material-tools').hide();
            $('#materialgroup-tools').hide();
            $('#stockmaterial-tools').show();
            SearchStockMaterial();
          }
        }
      });
    });
    </script>

    <script>
    $(function(){
      // $('#tt').tabs('select', 1);
    })
    SearchMaterial();

    $('#tg-material').treegrid({
      onBeforeSelect: function(row) {
        // var level = $(this).treegrid('getLevel', row.ITEMCODE);
        // return level > 4;
        if (row.LEVELNAME) {
          return false;
        }
      },
      onSelect: function (row) {
        if ($('#tg-material').treegrid('isLeaf', row.ITEMCODE)) {
          $('.btndisabled').linkbutton('enable');
        } else {
          $('.btndisabled').linkbutton('disable');
        }
      },
    });

    function SearchMaterial(){
      $('#SearchMaterial').combotreegrid({
        url: "<?php echo site_url().'/../content/operation/maintenance/material/getMaterialList'; ?>",
        panelWidth: 820,
        editable:true,
        idField:'ITEMCODE',
        textField:'ITEMDESCRIPTION',
        treeField:'ITEMDESCRIPTION',
        columns: [[
          {field:'ITEMDESCRIPTION',title:'Description',width:700},
          {field:'ITEMCODE',title:'Code',width:100}
        ]],
        filter: function(q, row) {
          var idMatch = row['ITEMCODE'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
          var nameMatch = row['ITEMDESCRIPTION'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
          // Combine the conditions using AND (&&)
          return idMatch || nameMatch;
        },
        icons: [{
          iconCls: 'icon-reload',
          handler: function (e) {
            $(e.data.target).combotreegrid('clear');
            $('#tg-material').treegrid('load', {});
          }
        }, {
          iconCls: 'icon-search',
          handler: function (e) {
            $('#tg-material').treegrid('load', {
              q: $('#SearchMaterial').combotreegrid('getValue'),
            });
          }
        }],
        onSelect: function(row){

        }
      });
    }
    //------------------------------------------
    $('#tg-materialgroup').treegrid({
      onSelect: function (row) {
        if ($('#tg-materialgroup').treegrid('isLeaf', row.GROUPCODE)) {
          $('.btndisabled').linkbutton('enable');
        } else {
          $('.btndisabled').linkbutton('disable');
        }
      },
    });

    function SearchMaterialGroup(){
      $('#SearchMaterialGroup').combotreegrid({
        url: "<?php echo site_url().'/../content/operation/maintenance/material/getMaterialGroup'; ?>",
        panelWidth: 720,
        editable:true,
        idField:'GROUPCODE',
        textField:'GROUPNAME',
        treeField:'GROUPNAME',
        columns: [[
          {field:'GROUPNAME',title:'Group Name',width:600},
          {field:'GROUPCODE',title:'Group Code',width:100}
        ]],
        filter: function(q, row) {
          var idMatch = row['GROUPCODE'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
          var nameMatch = row['GROUPNAME'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
          // Combine the conditions using AND (&&)
          return idMatch || nameMatch;
        },
        icons: [{
          iconCls: 'icon-reload',
          handler: function (e) {
            $(e.data.target).combotreegrid('clear');
            $('#tg-materialgroup').treegrid('load', {});
          }
        }, {
          iconCls: 'icon-search',
          handler: function (e) {
            $('#tg-materialgroup').treegrid('load', {
              q: $('#SearchMaterialGroup').combotreegrid('getValue'),
            });
          }
        }],
        onSelect: function(row){

        }
      });
    }
    //------------------------------------------
    $('#tg-stockmaterial').treegrid({
      onSelect: function (row) {
        if ($('#tg-stockmaterial').treegrid('isLeaf', row.XXX)) {
          $('.btndisabled').linkbutton('enable');
        } else {
          $('.btndisabled').linkbutton('disable');
        }
      },
    });

    function SearchStockMaterial(){
      $('#SearchStockMaterial').combotreegrid({
        url: "<?php echo site_url().'/../content/operation/maintenance/material/getStockMaterial'; ?>",
        panelWidth: 720,
        editable:true,
        idField:'ASSET_GROUP_ID',
        textField:'DESCRIPTION',
        treeField:'DESCRIPTION',
        columns: [[
          {field:'DESCRIPTION',title:'Asset Group Name',width:600},
          {field:'ASSET_GROUP_ID',title:'Asset Group ID',width:100}
        ]],
        filter: function(q, row) {
          var idMatch = row['ASSET_GROUP_ID'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
          var nameMatch = row['DESCRIPTION'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
          // Combine the conditions using AND (&&)
          return idMatch || nameMatch;
        },
        icons: [{
          iconCls: 'icon-reload',
          handler: function (e) {
            $(e.data.target).combotreegrid('clear');
            $('#tg-material').treegrid('load', {});
          }
        }, {
          iconCls: 'icon-search',
          handler: function (e) {
            $('#tg-stockmaterial').treegrid('load', {
              q: $('#SearchStockMaterial').combotreegrid('getValue'),
            });
          }
        }],
        onSelect: function(row){

        }
      });
    }
    </script>

    <script>
    function addFormMaterial(){
      // MasterParentTree();
      $('#fm-material').form('clear');
      $('#button-savematerial').show();
      $('#button-updatematerial').hide();
      $('#dlg-material').dialog('open').dialog({
        title: 'Tambah Material',
        buttons: '#button-savematerial'
      });

      $('#material-itemcode').textbox({
        readonly:false,
        validType: 'remote["<?php echo site_url().'/../content/operation/maintenance/material/checkUniqueMaterial'; ?>","q"]',
      });

      $('#fm-material input[type="text"]').on('input', function () {
        // Convert the input value to uppercase
        $(this).val($(this).val().toUpperCase());
      });

    }

    function updateFormMaterial(){
      var row = $('#tg-material').treegrid('getSelected');
      if (row){
        $('#button-savematerial').hide();
        $('#button-updatematerial').show();
        $('#dlg-material').dialog('open').dialog({
          title: 'Update Material',
          buttons: '#button-updatematerial'
        });

        $('#material-itemcode').textbox({
          readonly:true,
          validType: '',
        });

        $('#fm-material').form('load', row);

        $('#fm-material input[type="text"]').on('input', function () {
          // Convert the input value to uppercase
          $(this).val($(this).val().toUpperCase());
        });

        var inactivedate = $('#material-inactivedate').datebox('getValue');
        if (inactivedate) {
          $('#material-inactive').checkbox({checked:true});
        } else {
          $('#material-inactive').checkbox({checked:false});
        }

      }
    }


    function addFormMaterialGroup(){
      MaterialGroupTree();
      $('#fm-materialgroup').form('clear');
      $('#button-savematerialgroup').show();
      $('#button-updatematerialgroup').hide();
      $('#dlg-materialgroup').dialog('open').dialog({
        title: 'Tambah Material Group',
        buttons: '#button-savematerialgroup'
      });

      $('#materialgroup-code').textbox({
        readonly:false,
        validType: 'remote["<?php echo site_url().'/../content/operation/maintenance/material/checkUniqueMaterialGroup'; ?>","q"]',
      });

      $('#fm-materialgroup input[type="text"]').on('input', function () {
        // Convert the input value to uppercase
        $(this).val($(this).val().toUpperCase());
      });

    }

    function updateFormMaterialGroup(){
      var row = $('#tg-materialgroup').treegrid('getSelected');
      if (row){
        $('#button-savematerialgroup').hide();
        $('#button-updatematerialgroup').show();
        $('#dlg-materialgroup').dialog('open').dialog({
          title: 'Update Material Group',
          buttons: '#button-updatematerialgroup'
        });

        $('#materialgroup-code').textbox({
          readonly:true,
          validType: '',
        });

        $('#fm-materialgroup').form('load', row);

        $('#fm-materialgroup input[type="text"]').on('input', function () {
          // Convert the input value to uppercase
          $(this).val($(this).val().toUpperCase());
        });

        var inactivedate = $('#materialgroup-inactivedate').datebox('getValue');
        if (inactivedate) {
          $('#materialgroup-inactive').checkbox({checked:true});
        } else {
          $('#materialgroup-inactive').checkbox({checked:false});
        }

      }
    }

    function addFormMaintenanceGroup(){
      MaintenanceGroupParentTree();
      $('#fm-maintenancegroup').form('clear');
      $('#button-savemaintenancegroup').show();
      $('#button-updatemaintenancegroup').hide();
      $('#dlg-maintenancegroup').dialog('open').dialog({
        title: 'Tambah Asset Maintenance Group',
        buttons: '#button-savemaintenancegroup'
      });

      $('#group-assetid').textbox({
        readonly:false,
        validType: 'remote["<?php echo site_url().'/../content/operation/maintenance/material/checkMaintenanceGroup'; ?>","q"]',
      });

      $('#fm-maintenancegroup input[type="text"]').on('input', function () {
        // Convert the input value to uppercase
        $(this).val($(this).val().toUpperCase());
      });
    }


    function updateFormMaintenanceGroup(){
      var row = $('#tg-assetmaintenancegroup').treegrid('getSelected');
      if (row){
        $('#button-savemaintenancegroup').hide();
        $('#button-updatemaintenancegroup').show();
        $('#dlg-maintenancegroup').dialog('open').dialog({
          title: 'Update Asset Maintenance Group',
          buttons: '#button-updatemaintenancegroup'
        });

        $('#group-assetid').textbox({
          readonly:true,
          validType: '',
        });

        $('#fm-maintenancegroup').form('load', row);

        $('#fm-maintenancegroup input[type="text"]').on('input', function () {
          // Convert the input value to uppercase
          $(this).val($(this).val().toUpperCase());
        });

      }
    }

    function deleteMaterial(){
      var row = $('#tg-material').treegrid('getSelected');
      if (row){
        $.messager.confirm('Confirm','Hapus Kode Material : '+ row.ITEMCODE,function(r){
          if (r){
            $.post('<?php echo current_url().'/deleteMaterial' ; ?>',{id:row.ITEMCODE},
            function(result){
              $.messager.alert('Alert', 'Data Berhasil di hapus', 'info');
              $('#tg-material').treegrid('reload');
            },'json');
          }
        });
      }
    }

    function deleteMaterialGroup(){
      var row = $('#tg-materialgroup').treegrid('getSelected');
      if (row){
        $.messager.confirm('Confirm','Hapus Kode Material Group : '+ row.GROUPCODE,function(r){
          if (r){
            $.post('<?php echo current_url().'/deleteMaterialGroup' ; ?>',{id:row.GROUPCODE},
            function(result){
              $.messager.alert('Alert', 'Data Berhasil di hapus', 'info');
              $('#tg-materialgroup').treegrid('reload');
            },'json');
          }
        });
      }
    }

    function deleteMaintenanceGroup(){
      var row = $('#tg-assetmaintenancegroup').treegrid('getSelected');
      if (row){
        $.messager.confirm('Confirm','Hapus Kode Asset Group ID : '+ row.ASSET_GROUP_ID,function(r){
          if (r){
            $.post('<?php echo current_url().'/deleteMaintenanceGroup' ; ?>',{id:row.ASSET_GROUP_ID},
            function(result){
              $.messager.alert('Alert', 'Data Berhasil di hapus', 'info');
              $('#tg-assetmaintenancegroup').treegrid('reload');
            },'json');
          }
        });
      }
    }

    </script>
