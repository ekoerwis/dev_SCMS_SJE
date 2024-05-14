<style>
#csslayout{padding-left:5px;padding-top:5px;padding-right: 5px;margin-right:0px;margin-bottom:0px;}
.checkbox {margin-top:5px}
</style>
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<div id="button-savematerial">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="saveMaterial()" style="width:70px;">Save</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg-material').dialog('close')" style="width:70px;">Close</a>
</div>

<div id="button-updatematerial">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="updateMaterial()" style="width:70px;">Update</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg-material').dialog('close')" style="width:70px;">Close</a>
</div>

<div id="dlg-material" class="easyui-dialog" title="Material" fit="false" style="width:50%;height:389px">

  <form id="fm-material" method="post" novalidate>
    <div class="easyui-panel" title="" headerCls="headcls" style="width:100%;">

      <div id="csslayout" class="easyui-layout" fit="true" style="width:100%;">
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Material Code</span>
          <input id="material-itemcode" name="ITEMCODE" class="easyui-textbox" style="width:20%" data-options="required:true">
          <text style="width:0.5%"></text>
          <span class="input-group-text" style="width:20%">Inactive Date</span>
          <text style="width:0.5%"></text>
          <input id="material-inactive" class="easyui-checkbox">
          <text style="width:0.5%"></text>
          <input id="material-inactivedate" name="INACTIVEDATE" class="easyui-datebox" style="width:20%" data-options="readonly:true">
        </div>

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Description</span>
          <input name="ITEMDESCRIPTION" class="easyui-textbox" style="width:79.5%;" data-options="required:true">
        </div>

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Group Code</span>
          <input id="material-groupcode" name="GROUPCODE" class="easyui-combotreegrid" style="width:20%" data-options="required:true">
          <text style="width:0.5%"></text>
          <input id="material-groupname" name="GROUPNAME" class="easyui-textbox" style="width:59%;" data-options="readonly:true">
        </div>

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Uom</span>
          <input id="material-uom" name="UOMCODE" class="easyui-combogrid" style="width:20%" data-options="required:false">
        </div>

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Brand</span>
          <input id="material-brand" name="BRAND" class="easyui-textbox" style="width:79.5%;" data-options="readonly:false">
        </div>

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Part No.</span>
          <input id="material-partno" name="PARTNO" class="easyui-textbox" style="width:79.5%;" data-options="readonly:false">
        </div>

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Specification</span>
          <input id="material-spesification" name="SPECIFICATION" class="easyui-textbox" style="width:79.5%;" data-options="readonly:false">
        </div>

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Grade</span>
          <input id="material-grade" name="GRADE" class="easyui-textbox" style="width:20%;" data-options="readonly:false">
        </div>

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Life Time</span>
          <input id="material-lifetime" name="LIFETIME" class="easyui-numberbox" style="width:20%;" data-options="readonly:false">
        </div>

      </div>

    </div>
  </form>
</div>

<script>
$(function () {
  $('#button-savematerial').hide();
  $('#button-updatematerial').hide();
  // MasterParentTree();
})

$(document).ready(function(){
  $('#material-inactive').checkbox({
    onChange:function(value){
      var currentDate = new Date();
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      var sysdate = currentDate.getDate() + "-" + months[currentDate.getMonth()] + "-" + currentDate.getFullYear();

      if (value == true) {
        $('#material-inactivedate').datebox('setValue', sysdate);
      } else {
        $('#material-inactivedate').datebox('clear');
      }
    }
  });
});
</script>

<script>
$.extend($.fn.validatebox.defaults.rules, {
	remote:{
		validator: function(value,param){
			var target = this;
			var opts = $(this).validatebox('options');
			var data = {};
			data[param[1]] = value;
			if (!opts.notValidate){
				$.ajax({
					url: param[0],
					dataType: 'text',
					data: data,
					type: 'post',
					success: function(data){
						if (data == 'true'){
							opts.result = true;
						} else {
							opts.result = false;
						}
						opts.notValidate = true;
						$(target).validatebox('validate');
						opts.notValidate = false;
					}
				});
			}
			return opts.result!=undefined ? opts.result : true;
		},
		message:'Code Sudah Ada !'
	}
});


// function MasterParentTree(){
//   $('#master-parentid').combotreegrid({
//     url: "<?php echo site_url().'/../content/operation/maintenance/material/getMaterialGroup'; ?>",
//     panelWidth: 820,
//     editable:true,
//     idField:'ASSET_ID',
//     textField:'ASSET_ID',
//     treeField:'ASSETNAME',
//     columns: [[
//       {field:'ASSETNAME',title:'Asset Name',width:700},
//       {field:'ASSET_ID',title:'Asset ID',width:100}
//     ]],
//     filter: function(q, row) {
//       var idMatch = row['ASSET_ID'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
//       var nameMatch = row['ASSETNAME'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
//       // Combine the conditions using AND (&&)
//       return idMatch || nameMatch;
//     },
//     onSelect: function(row){
//       $('#master-parentname').textbox('setValue',row.ASSETNAME);
//     }
//   });
// }

$('#material-groupcode').combotreegrid({
  url: "<?php echo site_url().'/../content/operation/maintenance/material/getMaterialGroup'; ?>",
  panelWidth: 820,
  editable:true,
  idField:'GROUPCODE',
  textField:'GROUPCODE',
  treeField:'GROUPNAME',
  columns: [[
    {field:'GROUPNAME',title:'Group Code',width:700},
    {field:'GROUPCODE',title:'Group Name',width:100}
  ]],
  filter: function(q, row) {
    var idMatch = row['GROUPCODE'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
    var nameMatch = row['GROUPNAME'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
    // Combine the conditions using AND (&&)
    return idMatch || nameMatch;
  },
  onBeforeSelect: function (node) {
    if (!node.children || node.children.length === 0) {
      return true;
    } else {
      $('#material-groupcode').combotreegrid('clear');
      $('#material-groupname').textbox('clear');
      return false;
    }
  },
  onSelect: function(row){
    $('#material-groupname').textbox('setValue',row.GROUPNAME);
  }
});

$('#material-uom').combogrid({
  panelWidth: 600,
  pageSize:50,
  url: "<?php echo site_url().'/../content/operation/maintenance/material/getUOM'; ?>",
  idField:'UNITOFMEASURECODE',
  textField:'UNITOFMEASURECODE',
  mode:'remote',
  loadMsg: 'Loading',
  pagination: true,
  rownumbers:true,
  fitColumns:true,
  multiple:false,
  columns: [[
    {field:'UNITOFMEASURECODE',title:'UNITOFMEASURECODE',width:300},
    {field:'UNITOFMEASUREDESC',title:'UNITOFMEASUREDESC',width:300}
  ]],
  onSelect: function(index,row){

  },
});
</script>


<script type="text/javascript">
  function saveMaterial() {
    $('#fm-material').form('submit', {
      url: "<?php echo site_url().'/../content/operation/maintenance/material/saveMaterial'; ?>",
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
          SearchMaterial();
          $('#dlg-material').dialog('close');
          $('#tg-material').treegrid('reload'); // reload the user data
          // $('#master-parentid').combotreegrid('reload');
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
  function updateMaterial() {
    $('#fm-material').form('submit', {
      url: "<?php echo site_url().'/../content/operation/maintenance/material/updateMaterial'; ?>",
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
          SearchMaterial();
          $('#dlg-material').dialog('close');
          $('#tg-material').treegrid('reload'); // reload the user data
          // $('#master-parentid').combotreegrid('reload');

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
