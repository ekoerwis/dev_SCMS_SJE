<style>
#csslayout{padding-left:5px;padding-top:5px;padding-right: 5px;margin-right:0px;margin-bottom:0px;}
</style>
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<div id="button-savematerialgroup">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="saveMaterialGroup()" style="width:70px;">Save</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg-materialgroup').dialog('close')" style="width:70px;">Close</a>
</div>

<div id="button-updatematerialgroup">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="updateMaterialGroup()" style="width:70px;">Update</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg-materialgroup').dialog('close')" style="width:70px;">Close</a>
</div>

<div id="dlg-materialgroup" class="easyui-dialog" title="Material Group" fit="false" style="width:50%;height:225px;">

  <form id="fm-materialgroup" method="post" novalidate>
    <div class="easyui-panel" title="" headerCls="headcls" style="width:100%;">

      <div id="csslayout" class="easyui-layout" fit="true" style="width:100%;">

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Group Code</span>
          <input id="materialgroup-code" name="GROUPCODE" class="easyui-textbox" style="width:20%" data-options="required:true">

          <text style="width:0.5%"></text>
          <span class="input-group-text" style="width:20%">Inactive Date</span>
          <text style="width:0.5%"></text>
          <input id="materialgroup-inactive" class="easyui-checkbox">
          <text style="width:0.5%"></text>
          <input id="materialgroup-inactivedate" name="INACTIVEDATE" class="easyui-datebox" style="width:20%" data-options="readonly:true">

        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Group Name</span>
          <input name="GROUPNAME" class="easyui-textbox" style="width:79.5%;" data-options="required:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Parent Group Code</span>
          <input id="materialgroup-parentcode" name="PARENT_GROUP_CODE" class="easyui-combotreegrid" style="width:20%" data-options="required:false">
          <text style="width:0.5%"></text>
          <input id="materialgroup-parentname" name="PARENTNAME" class="easyui-textbox" style="width:59%;" data-options="readonly:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Seq. Number</span>
          <input name="SEQ" class="easyui-numberbox" style="width:20%" data-options="required:false">
        </div>
      </div>

    </div>
  </form>
</div>
<script>
$(function () {
  $('#button-savematerialgroup').hide();
  $('#button-updatematerialgroup').hide();
  MaterialGroupTree();
})

$(document).ready(function(){
  $('#materialgroup-inactive').checkbox({
    onChange:function(value){
      var currentDate = new Date();
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      var sysdate = currentDate.getDate() + "-" + months[currentDate.getMonth()] + "-" + currentDate.getFullYear();

      if (value == true) {
        $('#materialgroup-inactivedate').datebox('setValue', sysdate);
      } else {
        $('#materialgroup-inactivedate').datebox('clear');
      }
    }
  });
});
</script>

<script>
function MaterialGroupTree(){
  $('#materialgroup-parentcode').combotreegrid({
    url: "<?php echo site_url().'/../content/operation/maintenance/material/getMaterialGroup'; ?>",
    panelWidth: 820,
    editable:true,
    idField:'GROUPCODE',
    textField:'GROUPCODE',
    treeField:'GROUPNAME',
    columns: [[
      {field:'GROUPNAME',title:'Group Name',width:700},
      {field:'GROUPCODE',title:'Group Code',width:100}
    ]],
    filter: function(q, row) {
      var idMatch = row['GROUPCODE'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
      var nameMatch = row['GROUPNAME'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
      // Combine the conditions using AND (&&)
      return idMatch || nameMatch;
    },
    onSelect: function(row){
      $('#materialgroup-parentname').textbox('setValue',row.GROUPNAME);
    }
  });
}
</script>

<script type="text/javascript">
  function saveMaterialGroup() {
    $('#fm-materialgroup').form('submit', {
      url: "<?php echo site_url().'/../content/operation/maintenance/material/saveMaterialGroup'; ?>",
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
          SearchMaterialGroup();
          $('#dlg-materialgroup').dialog('close');
          $('#tg-materialgroup').treegrid('reload'); // reload the user data
          $('#materialgroup-parentcode').combotreegrid('reload');
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
  function updateMaterialGroup() {
    $('#fm-materialgroup').form('submit', {
      url: "<?php echo site_url().'/../content/operation/maintenance/material/updateMaterialGroup'; ?>",
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
          SearchMaterialGroup();
          $('#dlg-materialgroup').dialog('close');
          $('#tg-materialgroup').treegrid('reload'); // reload the user data
          $('#materialgroup-parentcode').combotreegrid('reload');

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
