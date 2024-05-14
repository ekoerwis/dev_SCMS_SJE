<style>
#csslayout{padding-left:5px;padding-top:5px;padding-right: 5px;margin-right:0px;margin-bottom:0px;}
</style>

<meta name="viewport" content="width=device-width,initial-scale=1.0">

<div id="button-savemaintenancegroup">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="saveMaintenanceGroup()" style="width:70px;">Save</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg-maintenancegroup').dialog('close')" style="width:70px;">Close</a>
</div>

<div id="button-updatemaintenancegroup">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="updateMaintenanceGroup()" style="width:70px;">Update</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg-maintenancegroup').dialog('close')" style="width:70px;">Close</a>
</div>

<div id="dlg-maintenancegroup" class="easyui-dialog" title="Asset Maintenace Group" fit="false" style="width:50%;height:300px;">

  <form id="fm-maintenancegroup" method="post" novalidate>
    <div class="easyui-panel" title="" headerCls="headcls" style="width:100%;">
      <!-- <header style="height:40px" data-options="closable:false,collapsible:true">
        <div class="panel-title f-full">
          <span style="display:inline-block;line-height:30px">&nbsp;&nbsp;Asset Maintenance Group
          </div>
          &nbsp;<a href="#" class="easyui-linkbutton" id="saveBtnFm" iconCls="icon-save" onclick="saveData()" style="width:70px;height:30px">Save</a>
          &nbsp;<a href="<php echo site_url() . '/../content/operation/asset'; ?>" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:70px;height:30px">Cancel</a>
        </span>
      </header> -->

      <div id="csslayout" class="easyui-layout" fit="true" style="width:100%;">

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Asset Group ID</span>
          <input id="group-assetid" name="ASSET_GROUP_ID" class="easyui-textbox" style="width:20%" data-options="required:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Asset Group Name</span>
          <input id="group-assetname" name="DESCRIPTION" class="easyui-textbox" style="width:79.5%;" data-options="required:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Parent Group ID</span>
          <input id="group-parentcode" name="PARENT_ASSET_GROUP_ID" class="easyui-combogrid" style="width:20%" data-options="required:false">
          <text style="width:0.5%"></text>
          <input id="group-parentname" name="PARENTNAME" class="easyui-textbox" style="width:59%;" data-options="readonly:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Seq. Number</span>
          <input name="SEQ" class="easyui-numberbox" style="width:20%" data-options="required:false">
        </div>

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Fixed Asset Group</span>
          <input id="group-facode" name="FIXED_ASSET_GROUP" class="easyui-combogrid" style="width:20%" data-options="required:false">
          <text style="width:0.5%"></text>
          <input id="group-faname" name="FAGROUPNAME" class="easyui-textbox" style="width:59%;" data-options="readonly:true">
        </div>

        <div class="input-group sm-12" style="padding-bottom:5px;">
          <span class="input-group-text" style="width:20%">Inactive Date</span>
          <text style="width:0.5%"></text>
          <input id="group-inactive" class="easyui-checkbox">
          <text style="width:0.5%"></text>
          <input id="group-inactivedate" name="INACTIVEDATE" class="easyui-datebox" style="width:16.2%" data-options="readonly:true">
        </div>

      </div>

    </div>
  </form>
</div>

<script>
$(function () {
  $('#button-savemaintenancegroup').hide();
  $('#button-updatemaintenancegroup').hide();
  MaintenanceGroupParentTree();
})
$(document).ready(function(){
  $('#group-inactive').checkbox({
    onChange:function(value){
      var currentDate = new Date();
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      var sysdate = currentDate.getDate() + "-" + months[currentDate.getMonth()] + "-" + currentDate.getFullYear();

      if (value == true) {
        $('#group-inactivedate').datebox('setValue', sysdate);
      } else {
        $('#group-inactivedate').datebox('clear');
      }
    }
  });
});
</script>

<script>
function MaintenanceGroupParentTree(){
  $('#group-parentcode').combotreegrid({
    url: "<?php echo site_url().'/../content/operation/asset/getAssetMaintenanceGroup'; ?>",
    panelWidth: 820,
    editable:true,
    idField:'ASSET_GROUP_ID',
    textField:'ASSET_GROUP_ID',
    treeField:'DESCRIPTION',
    columns: [[
      {field:'DESCRIPTION',title:'Asset Group Name',width:700},
      {field:'ASSET_GROUP_ID',title:'Asset Group ID',width:100}
    ]],
    filter: function(q, row) {
      var idMatch = row['ASSET_GROUP_ID'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
      var nameMatch = row['DESCRIPTION'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
      // Combine the conditions using AND (&&)
      return idMatch || nameMatch;
    },
    onSelect: function(row){
      $('#group-parentname').textbox('setValue',row.DESCRIPTION);
    }
  });
}

$('#group-facode').combogrid({
  panelWidth: 500,
  url: "<?php echo site_url().'/../content/operation/asset/getFaGroup'; ?>",
  idField:'GROUPID',
  textField:'GROUPID',
  mode:'remote',
  loadMsg: 'Loading',
  pagination: true,
  rownumbers:true,
  fitColumns:true,
  multiple:false,
  columns: [[
    {field:'GROUPID',title:'Group ID',width:100},
    {field:'DESCRIPTION',title:'Description',width:400}
  ]],
  onSelect: function(index,row){
    $('#group-faname').textbox('setValue',row.DESCRIPTION);
  }
});
</script>

<script type="text/javascript">
  function saveMaintenanceGroup() {
    $('#fm-maintenancegroup').form('submit', {
      url: "<?php echo site_url().'/../content/operation/asset/saveMaintenanceGroup'; ?>",
      onSubmit:function(){
        var valid =  $(this).form('validate');
        if (valid){
          loadingBar('on');
        } else {
          return valid;
        }
      },
      success: function(data_feedbacksave) {
        // tambahan substring karena aneh data hasil json ada script lain jadi json ga kebaca
        loadingBar('off');
        var feedbacksave = data_feedbacksave.substring(
          data_feedbacksave.lastIndexOf("{"),
          data_feedbacksave.lastIndexOf("}") + 1
        );

        obj = JSON.parse(feedbacksave);
        // alert(feedbacksave);
        if (obj.status == "ok") {
          $.messager.alert({
            title: 'Alert',
            msg: obj.content,
            // fn: function() {
            //   location = "<php echo $config->baseURL . $current_module['NAMA_MODULE']; ?>";
            // }
          });
          SearchMaintenanceGroup();
          $('#dlg-maintenancegroup').dialog('close');
          $('#tg-assetmaintenancegroup').treegrid('reload'); // reload the user data
        } else {
          $.messager.alert('Alert', obj.content, 'info');
        }

      },
      error: function() {
        alert('Error get data from ajax');
      }
    });
  }
</script>

<script type="text/javascript">
  function updateMaintenanceGroup() {
    $('#fm-maintenancegroup').form('submit', {
      url: "<?php echo site_url().'/../content/operation/asset/updateMaintenanceGroup'; ?>",
      onSubmit:function(){
        var valid =  $(this).form('validate');
        if (valid){
          loadingBar('on');
        } else {
          return valid;
        }
      },
      success: function(data_feedbacksave) {
        // tambahan substring karena aneh data hasil json ada script lain jadi json ga kebaca
        loadingBar('off');
        var feedbacksave = data_feedbacksave.substring(
          data_feedbacksave.lastIndexOf("{"),
          data_feedbacksave.lastIndexOf("}") + 1
        );

        obj = JSON.parse(feedbacksave);
        // alert(feedbacksave);
        if (obj.status == "ok") {
          $.messager.alert({
            title: 'Alert',
            msg: obj.content,
            // fn: function() {
            //   location = "<php echo $config->baseURL . $current_module['NAMA_MODULE']; ?>";
            // }
          });
          SearchMaintenanceGroup();
          $('#dlg-maintenancegroup').dialog('close');
          $('#tg-assetmaintenancegroup').treegrid('reload'); // reload the user data
          $('#group-assetid').combotreegrid('reload');

        } else {
          $.messager.alert('Alert', obj.content, 'info');
        }

      },
      error: function() {
        alert('Error get data from ajax');
      }
    });
  }
</script>
