<style>
#csslayout{padding-left:5px;padding-top:5px;padding-right: 5px;margin-right:0px;margin-bottom:0px;}
</style>
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<div id="button-savelocation">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="saveLocation()" style="width:70px;">Save</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg-location').dialog('close')" style="width:70px;">Close</a>
</div>

<div id="button-updatelocation">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="updateLocation()" style="width:70px;">Update</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg-location').dialog('close')" style="width:70px;">Close</a>
</div>

<div id="dlg-location" class="easyui-dialog" title="Asset Location" fit="false" style="width:50%;height:300px;">

  <form id="fm-location" method="post" novalidate>
    <div class="easyui-panel" title="" headerCls="headcls" style="width:100%;">
      <!-- <header style="height:40px" data-options="closable:false,collapsible:true">
        <div class="panel-title f-full">
          <span style="display:inline-block;line-height:30px">&nbsp;&nbsp;Asset Location
          </div>
          &nbsp;<a href="#" class="easyui-linkbutton" id="saveBtnFm" iconCls="icon-save" onclick="saveData()" style="width:70px;height:30px">Save</a>
          &nbsp;<a href="<php echo site_url() . '/../content/operation/maintenance/asset'; ?>" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:70px;height:30px">Cancel</a>
        </span>
      </header> -->

      <div id="csslayout" class="easyui-layout" fit="true" style="width:100%;">

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Location Code</span>
          <input id="location-locationcode" name="LOCATION_CODE" class="easyui-textbox" style="width:20%" data-options="required:true">

          <text style="width:0.5%"></text>
          <span class="input-group-text" style="width:20%">Inactive Date</span>
          <text style="width:0.5%"></text>
          <input id="location-inactive" class="easyui-checkbox">
          <text style="width:0.5%"></text>
          <input id="location-inactivedate" name="INACTIVEDATE" class="easyui-datebox" style="width:20%" data-options="readonly:true">

        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Location Name</span>
          <input name="DESCRIPTION" class="easyui-textbox" style="width:79.5%;" data-options="required:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Parent Location Code</span>
          <input id="location-parentcode" name="PARENT_LOCATION_CODE" class="easyui-combotreegrid" style="width:20%" data-options="required:false">
          <text style="width:0.5%"></text>
          <input id="location-parentname" name="PARENTNAME" class="easyui-textbox" style="width:59%;" data-options="readonly:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Seq. Number</span>
          <input name="SEQ" class="easyui-numberbox" style="width:20%" data-options="required:false">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Location Type </span>
          <input id="location-typecode" name="LOCATIONTYPECODE" class="easyui-combogrid" style="width:20%" data-options="required:false">
          <text style="width:0.5%"></text>
          <input id="location-typename" name="LOCATIONTYPENAME"  class="easyui-textbox" style="width:59%;" data-options="readonly:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:5px;">
          <span class="input-group-text" style="width:20%">Remarks</span>
          <input name="REMARKS" class="easyui-textbox" style="width:79.5%;" data-options="readonly:false">
        </div>

      </div>

    </div>
  </form>
</div>
<script>
$(function () {
  $('#button-savelocation').hide();
  $('#button-updatelocation').hide();
  LocationParentTree();
})

$(document).ready(function(){
  $('#location-inactive').checkbox({
    onChange:function(value){
      var currentDate = new Date();
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      var sysdate = currentDate.getDate() + "-" + months[currentDate.getMonth()] + "-" + currentDate.getFullYear();

      if (value == true) {
        $('#location-inactivedate').datebox('setValue', sysdate);
      } else {
        $('#location-inactivedate').datebox('clear');
      }
    }
  });
});
</script>

<script>
function LocationParentTree(){
  $('#location-parentcode').combotreegrid({
    url: "<?php echo site_url().'/../content/operation/maintenance/asset/getAssetLocation'; ?>",
    panelWidth: 820,
    editable:true,
    idField:'LOCATION_CODE',
    textField:'LOCATION_CODE',
    treeField:'DESCRIPTION',
    columns: [[
      {field:'DESCRIPTION',title:'Location Name',width:700},
      {field:'LOCATION_CODE',title:'Location Code',width:100}
    ]],
    filter: function(q, row) {
      var idMatch = row['LOCATION_CODE'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
      var nameMatch = row['DESCRIPTION'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
      // Combine the conditions using AND (&&)
      return idMatch || nameMatch;
    },
    onSelect: function(row){
      $('#location-parentname').textbox('setValue',row.DESCRIPTION);
    }
  });
}

$('#location-typecode').combogrid({
  panelWidth: 500,
  url: "<?php echo site_url().'/../content/operation/maintenance/asset/getLocationType'; ?>",
  idField:'LOCATIONTYPECODE',
  textField:'LOCATIONTYPECODE',
  mode:'remote',
  loadMsg: 'Loading',
  pagination: true,
  rownumbers:true,
  fitColumns:true,
  multiple:false,
  columns: [[
    {field:'LOCATIONTYPECODE',title:'Code',width:100},
    {field:'LOCATIONTYPENAME',title:'Name',width:300}
  ]],
  onSelect: function(index,row){
    $('#location-typename').textbox('setValue',row.LOCATIONTYPENAME);
  }
});
</script>

<script type="text/javascript">
  function saveLocation() {
    $('#fm-location').form('submit', {
      url: "<?php echo site_url().'/../content/operation/maintenance/asset/saveLocation'; ?>",
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
          SearchLocation();
          $('#dlg-location').dialog('close');
          $('#tg-assetlocation').treegrid('reload'); // reload the user data
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
  function updateLocation() {
    $('#fm-location').form('submit', {
      url: "<?php echo site_url().'/../content/operation/maintenance/asset/updateLocation'; ?>",
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
          SearchLocation();
          $('#dlg-location').dialog('close');
          $('#tg-assetlocation').treegrid('reload'); // reload the user data
          $('#location-locationcode').combotreegrid('reload');

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
