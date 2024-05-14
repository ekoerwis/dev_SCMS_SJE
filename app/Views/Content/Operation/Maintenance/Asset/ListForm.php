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
    <div title="Asset Master" style="padding:10px;">
      <table id="tg-assetmaster"  style="width:100%;<?php echo $tinggi_dg; ?>"
        url="<?php echo current_url().'/getAssetMasterLocation'; ?>"
        data-options="striped:false,
        fitColumns:false,
        pagination:true,
        nowrap:true,
        rownumbers:true,
        singleSelect:true,
        collapsible: true,
        idField:'ASSET_ID',
        treeField:'ASSETNAME',
        lines:true
        ">
        <thead frozen="true">
          <tr>
            <th field="ASSETNAME" halign="center" data-options="sortable:false,width:380"><b>Asset Name</b></th>
            <th field="ASSET_ID" halign="center" data-options="sortable:false,width:80"><b>Asset ID</b></th>
            <th field="PARENT_ASET_ID" halign="center" data-options="sortable:false,width:80"><b>Parent ID</b></th>
            <th field="SEQ" halign="center" align="center" data-options="sortable:false,width:50"><b>Seq</b></th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th field="FIXEDASSETCODE" halign="center" data-options="sortable:false,width:200"><b>Fixed Asset Code</b></th>
            <th field="SPESIFICATION" halign="center" data-options="sortable:false,width:250"><b>Specification</b></th>
            <th field="BRAND" halign="center" data-options="sortable:false,width:200"><b>Brand</b></th>
            <th field="MADEIN" halign="center" data-options="sortable:false,width:200"><b>Made In</b></th>
            <th field="SERIALPRODNUMBER" halign="center" data-options="sortable:false,width:200"><b>Seraial Number</b></th>
            <th field="ASSETLOCATION_CODE" halign="center" data-options="sortable:false,width:80"><b>Loc. Code</b></th>
            <th field="LOCATIONNAME" halign="center" data-options="sortable:false,width:300"><b>Loc. Name</b></th>
            <th field="SUPPLIER_CODE" halign="center" data-options="sortable:false,width:100"><b>Supplier Code</b></th>
            <th field="SUPPLIER_NAME" halign="center" data-options="sortable:false,width:200"><b>Supplier Name</b></th>
            <th field="INSTALLDATE" halign="center" data-options="sortable:false,width:100"><b>Install Date</b></th>
            <th field="DATEO_ON_OPERATION" halign="center" data-options="sortable:false,width:100"><b>Date On Oper.</b></th>
            <th field="REMARKS" halign="center" data-options="sortable:false,width:300"><b>Remarks</b></th>
            <th field="INACTIVEDATE" halign="center" data-options="sortable:false,width:100"><b>Inactive Date</b></th>
          </tr>
        </thead>
      </table>
    </div>

    <div title="Asset Location" style="padding:10px;">
      <table id="tg-assetlocation" style="width:100%;<?php echo $tinggi_dg; ?>"
        url="<?php echo current_url().'/getAssetLocation'; ?>"
        data-options="striped:false,
        fitColumns:false,
        pagination:true,
        nowrap:true,
        rownumbers:true,
        singleSelect:true,
        collapsible: true,
        idField:'LOCATION_CODE',
        treeField:'DESCRIPTION',
        lines:true
        ">
        <thead frozen="true">
          <tr>
            <th field="DESCRIPTION" halign="center" data-options="sortable:false,width:350"><b>Location Name</b></th>
            <th field="LOCATION_CODE" halign="center" data-options="sortable:false,width:80"><b>Loc. Code</b></th>
            <th field="PARENT_LOCATION_CODE" halign="center" data-options="sortable:false,width:80"><b>Parent Code</b></th>
            <th field="SEQ" halign="center" align="center" data-options="sortable:false,width:50"><b>Seq</b></th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th field="LOCATIONTYPECODE" halign="center" data-options="sortable:false,width:100"><b>Loc. Type Code</b></th>
            <th field="REMARKS" halign="center" data-options="sortable:false,width:300"><b>Remarks</b></th>
            <th field="INACTIVEDATE" halign="center" data-options="sortable:false,width:100"><b>Inactive Date</b></th>
          </tr>
        </thead>
      </table>
    </div>

    <div title="Asset Maintenance Group" style="padding:10px;">
      <table id="tg-assetmaintenancegroup" style="width:100%;<?php echo $tinggi_dg; ?>"
        url="<?php echo current_url().'/getAssetMaintenanceGroup'; ?>"
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
            <th field="DESCRIPTION" halign="center" data-options="sortable:false,width:350"><b>Group Name</b></th>
            <th field="ASSET_GROUP_ID" halign="center" data-options="sortable:false,width:80"><b>Group ID</b></th>
            <th field="PARENT_ASSET_GROUP_ID" halign="center" data-options="sortable:false,width:80"><b>Parent Group ID</b></th>
            <th field="SEQ" halign="center" align="center" data-options="sortable:false,width:50"><b>Seq</b></th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th field="FIXED_ASSET_GROUP" halign="center" data-options="sortable:false,width:80"><b>Fa Group ID</b></th>
            <th field="FAGROUPNAME" halign="center" data-options="sortable:false,width:250"><b>Fa Group Name</b></th>
            <th field="INACTIVEDATE" halign="center" data-options="sortable:false,width:100"><b>Inactive Date</b></th>
          </tr>
        </thead>
      </table>
    </div>

  </div>
</div>

  <div id="tab-tools">
    <div id="master-tools" >
      <a class="btn btn-danger" onclick="CollapseMaster()" style="color:white"><i class="fa fa-chevron-up"></i> </a>
      <a class="btn btn-warning" onclick="ExpandMaster()" style="color:white"><i class="fa fa-chevron-down"></i> </a>
      <input id="SearchMaster" style="width:300px" class="easyui-combotreegrid" data-options="prompt:'Master'">&nbsp;

      <?php if(strtolower($auth_tambah) == 'yes'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="addFormMaster()"
        style="color:white;background: #00a300;width:30px">
        <i class="fa fa-plus" aria-hidden="true"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_ubah) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="updateFormMaster()"
        style="color:white;background:#ffc40d;width:30px">
        <i class="fas fa-pencil-alt"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_hapus) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton btndisabled" onclick="deleteMaster()"
        style="color:white;background:#ee1111;width:30px">
        <i class="fa fa-trash" aria-hidden="true"></i> </a>
      <?php }?>
    </div>

    <div id="location-tools" >
      <a class="btn btn-danger" onclick="CollapseLocation()" style="color:white"><i class="fa fa-chevron-up"></i> </a>
      <a class="btn btn-warning" onclick="ExpandLocation()" style="color:white"><i class="fa fa-chevron-down"></i> </a>
      <input id="SearchLocation" style="width:300px" class="easyui-combogrid" data-options="prompt:'Location'">&nbsp;

      <?php if(strtolower($auth_tambah) == 'yes'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="addFormLocation()"
        style="color:white;background: #00a300;width:30px">
        <i class="fa fa-plus" aria-hidden="true"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_ubah) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="updateFormLocation()"
        style="color:white;background:#ffc40d;width:30px">
        <i class="fas fa-pencil-alt"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_hapus) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton btndisabled" onclick="deleteLocation()"
        style="color:white;background:#ee1111;width:30px">
        <i class="fa fa-trash" aria-hidden="true"></i> </a>
      <?php }?>
    </div>

    <div id="maintenancegroup-tools" >
      <a class="btn btn-danger" onclick="CollapseMaintenanceGroup()" style="color:white"><i class="fa fa-chevron-up"></i> </a>
      <a class="btn btn-warning" onclick="ExpandMaintenanceGroup()" style="color:white"><i class="fa fa-chevron-down"></i> </a>
      <input id="SearchMaintenanceGroup" style="width:300px" class="easyui-combogrid" data-options="prompt:'Maintenance Group'">&nbsp;

      <?php if(strtolower($auth_tambah) == 'yes'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="addFormMaintenanceGroup()"
        style="color:white;background: #00a300;width:30px">
        <i class="fa fa-plus" aria-hidden="true"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_ubah) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="updateFormMaintenanceGroup()"
        style="color:white;background:#ffc40d;width:30px">
        <i class="fas fa-pencil-alt"></i> </a>
      <?php }?>
      <?php if(strtolower($auth_hapus) == 'all'){ ?>
        <a href="javascript:void(0)" class="easyui-linkbutton btndisabled" onclick="deleteMaintenanceGroup()"
        style="color:white;background:#ee1111;width:30px">
        <i class="fa fa-trash" aria-hidden="true"></i> </a>
      <?php }?>
    </div>

    </div>

    <?php include ('FormMaster.php'); ?>
    <?php include ('FormLocation.php'); ?>
    <?php include ('FormMaintenanceGroup.php'); ?>

    <script>
    function ExpandMaster() { $('#tg-assetmaster').treegrid('expandAll'); }
    function CollapseMaster() { $('#tg-assetmaster').treegrid('collapseAll'); }
    function ExpandLocation() { $('#tg-assetlocation').treegrid('expandAll'); }
    function CollapseLocation() { $('#tg-assetlocation').treegrid('collapseAll'); }
    function ExpandMaintenanceGroup() { $('#tg-assetmaintenancegroup').treegrid('expandAll'); }
    function CollapseMaintenanceGroup() { $('#tg-assetmaintenancegroup').treegrid('collapseAll'); }
    </script>

    <script>
    // Change Icon Tree use font-awesome
    // $('#tg-assetmaster').treegrid({
    //   onLoadSuccess: function(row, data) {
    //     $('.tree-folder').addClass('fa fa-clipboard-list');
    //     $('.tree-file').addClass('fas fa-angle-double-right');
    //   }
    // });

    $(document).ready(function(){
      $('#location-tools').hide();
      $('#maintenancegroup-tools').hide();
      $('#dlg-master').dialog('close');
      $('#dlg-location').dialog('close');
      $('#dlg-maintenancegroup').dialog('close');

      $('#tt').tabs({
        onSelect: function(title, index){
          // Handle the onclick event for tabs here
          if (index == 0){
            $('#master-tools').show();
            $('#location-tools').hide();
            $('#maintenancegroup-tools').hide();
            SearchMaster();
          }
          if (index == 1){
            $('#master-tools').hide();
            $('#location-tools').show();
            $('#maintenancegroup-tools').hide();
            SearchLocation();
          }
          if (index == 2){
            $('#master-tools').hide();
            $('#location-tools').hide();
            $('#maintenancegroup-tools').show();
            SearchMaintenanceGroup();
          }
        }
      });
    });
    </script>

    <script>
    // $(function(){
    //   $('#tt').tabs('select', 1);
    // })
    SearchMaster();

    $('#tg-assetmaster').treegrid({
      onBeforeSelect: function(row) {
        // var level = $(this).treegrid('getLevel', row.ASSET_ID);
        // return level > 3;
        if (row.LEVELNAME) {
          return false;
        }
      },
      onSelect: function (row) {
        if ($('#tg-assetmaster').treegrid('isLeaf', row.ASSET_ID)) {
          $('.btndisabled').linkbutton('enable');
        } else {
          $('.btndisabled').linkbutton('disable');
        }
      },
    });

    function SearchMaster(){
      $('#SearchMaster').combotreegrid({
        url: "<?php echo site_url().'/../content/operation/maintenance/asset/getAssetMasterLocation'; ?>",
        panelWidth: 820,
        editable:true,
        idField:'ASSET_ID',
        textField:'ASSETNAME',
        treeField:'ASSETNAME',
        columns: [[
          {field:'ASSETNAME',title:'Asset Name',width:700},
          {field:'ASSET_ID',title:'Asset ID',width:100}
        ]],
        filter: function(q, row) {
          var idMatch = row['ASSET_ID'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
          var nameMatch = row['ASSETNAME'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
          // Combine the conditions using AND (&&)
          return idMatch || nameMatch;
        },
        icons: [{
          iconCls: 'icon-reload',
          handler: function (e) {
            $(e.data.target).combotreegrid('clear');
            $('#tg-assetmaster').treegrid('load', {});
          }
        }, {
          iconCls: 'icon-search',
          handler: function (e) {
            $('#tg-assetmaster').treegrid('load', {
              q: $('#SearchMaster').combotreegrid('getValue'),
            });
          }
        }],
        onSelect: function(row){

        }
      });
    }
    //------------------------------------------
    $('#tg-assetlocation').treegrid({
      onSelect: function (row) {
        if ($('#tg-assetlocation').treegrid('isLeaf', row.LOCATION_CODE)) {
          $('.btndisabled').linkbutton('enable');
        } else {
          $('.btndisabled').linkbutton('disable');
        }
      },
    });

    function SearchLocation(){
      $('#SearchLocation').combotreegrid({
        url: "<?php echo site_url().'/../content/operation/maintenance/asset/getAssetLocation'; ?>",
        panelWidth: 720,
        editable:true,
        idField:'LOCATION_CODE',
        textField:'DESCRIPTION',
        treeField:'DESCRIPTION',
        columns: [[
          {field:'DESCRIPTION',title:'Location Name',width:600},
          {field:'LOCATION_CODE',title:'Location Code',width:100}
        ]],
        filter: function(q, row) {
          var idMatch = row['LOCATION_CODE'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
          var nameMatch = row['DESCRIPTION'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
          // Combine the conditions using AND (&&)
          return idMatch || nameMatch;
        },
        icons: [{
          iconCls: 'icon-reload',
          handler: function (e) {
            $(e.data.target).combotreegrid('clear');
            $('#tg-assetlocation').treegrid('load', {});
          }
        }, {
          iconCls: 'icon-search',
          handler: function (e) {
            $('#tg-assetlocation').treegrid('load', {
              q: $('#SearchLocation').combotreegrid('getValue'),
            });
          }
        }],
        onSelect: function(row){

        }
      });
    }
    //------------------------------------------
    $('#tg-assetmaintenancegroup').treegrid({
      onSelect: function (row) {
        if ($('#tg-assetmaintenancegroup').treegrid('isLeaf', row.ASSET_GROUP_ID)) {
          $('.btndisabled').linkbutton('enable');
        } else {
          $('.btndisabled').linkbutton('disable');
        }
      },
    });

    function SearchMaintenanceGroup(){
      $('#SearchMaintenanceGroup').combotreegrid({
        url: "<?php echo site_url().'/../content/operation/maintenance/asset/getAssetMaintenanceGroup'; ?>",
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
            $('#tg-assetmaster').treegrid('load', {});
          }
        }, {
          iconCls: 'icon-search',
          handler: function (e) {
            $('#tg-assetmaintenancegroup').treegrid('load', {
              q: $('#SearchMaintenanceGroup').combotreegrid('getValue'),
            });
          }
        }],
        onSelect: function(row){

        }
      });
    }
    </script>

    <script>
    function addFormMaster(){
      MasterParentTree();
      $('#fm-master').form('clear');
      $('#button-savemaster').show();
      $('#button-updatemaster').hide();
      $('#dlg-master').dialog('open').dialog({
        title: 'Tambah Asset Master',
        buttons: '#button-savemaster'
      });

      $('#master-assetid').textbox({
        readonly:false,
        validType: 'remote["<?php echo site_url().'/../content/operation/maintenance/asset/checkAssetMaster'; ?>","q"]',
      });

      $('#fm-master input[type="text"]').on('input', function () {
        // Convert the input value to uppercase
        $(this).val($(this).val().toUpperCase());
      });

    }

    function addFormLocation(){
      LocationParentTree();
      $('#fm-location').form('clear');
      $('#button-savelocation').show();
      $('#button-updatelocation').hide();
      $('#dlg-location').dialog('open').dialog({
        title: 'Tambah Asset Location',
        buttons: '#button-savelocation'
      });

      $('#location-locationcode').textbox({
        readonly:false,
        validType: 'remote["<?php echo site_url().'/../content/operation/maintenance/asset/checkLocation'; ?>","q"]',
      });

      $('#fm-location input[type="text"]').on('input', function () {
        // Convert the input value to uppercase
        $(this).val($(this).val().toUpperCase());
      });
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
        validType: 'remote["<?php echo site_url().'/../content/operation/maintenance/asset/checkMaintenanceGroup'; ?>","q"]',
      });

      $('#fm-maintenancegroup input[type="text"]').on('input', function () {
        // Convert the input value to uppercase
        $(this).val($(this).val().toUpperCase());
      });
    }

    function updateFormMaster(){
      var row = $('#tg-assetmaster').treegrid('getSelected');
      if (row){
        $('#button-savemaster').hide();
        $('#button-updatemaster').show();
        $('#dlg-master').dialog('open').dialog({
          title: 'Update Asset Master',
          buttons: '#button-updatemaster'
        });

        $('#master-assetid').textbox({
          readonly:true,
          validType: '',
        });

        $('#fm-master').form('load', row);

        $('#fm-master input[type="text"]').on('input', function () {
          // Convert the input value to uppercase
          $(this).val($(this).val().toUpperCase());
        });

        var inactivedate = $('#master-inactivedate').datebox('getValue');

        if (inactivedate) {
          $('#master-inactive').checkbox({checked:true});
        } else {
          $('#master-inactive').checkbox({checked:false});
        }

      }
    }

    function updateFormLocation(){
      var row = $('#tg-assetlocation').treegrid('getSelected');
      if (row){
        $('#button-savelocation').hide();
        $('#button-updatelocation').show();
        $('#dlg-location').dialog('open').dialog({
          title: 'Update Asset Location',
          buttons: '#button-updatelocation'
        });

        $('#location-locationcode').textbox({
          readonly:true,
          validType: '',
        });

        $('#fm-location').form('load', row);

        $('#fm-location input[type="text"]').on('input', function () {
          // Convert the input value to uppercase
          $(this).val($(this).val().toUpperCase());
        });

        var inactivedate = $('#location-inactivedate').datebox('getValue');
        if (inactivedate) {
          $('#location-inactive').checkbox({checked:true});
        } else {
          $('#location-inactive').checkbox({checked:false});
        }

      }
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

        var inactivedate = $('#maintenancegroup-inactivedate').datebox('getValue');
        if (inactivedate) {
          $('#maintenancegroup-inactive').checkbox({checked:true});
        } else {
          $('#maintenancegroup-inactive').checkbox({checked:false});
        }

      }
    }

    function deleteMaster(){
      var row = $('#tg-assetmaster').treegrid('getSelected');
      if (row){
        $.messager.confirm('Confirm','Hapus Kode Asset ID : '+ row.ASSET_ID,function(r){
          if (r){
            $.post('<?php echo current_url().'/deleteMaster' ; ?>',{id:row.ASSET_ID},
            function(result){
              $.messager.alert('Alert', 'Data Berhasil di hapus', 'info');
              $('#tg-assetmaster').treegrid('reload');
            },'json');
          }
        });
      }
    }

    function deleteLocation(){
      var row = $('#tg-assetlocation').treegrid('getSelected');
      if (row){
        $.messager.confirm('Confirm','Hapus Kode Location : '+ row.LOCATION_CODE,function(r){
          if (r){
            $.post('<?php echo current_url().'/deleteLocation' ; ?>',{id:row.LOCATION_CODE},
            function(result){
              $.messager.alert('Alert', 'Data Berhasil di hapus', 'info');
              $('#tg-assetlocation').treegrid('reload');
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
