<style>
#csslayout{padding-left:5px;padding-top:5px;padding-right: 5px;margin-right:0px;margin-bottom:0px;}
.checkbox {margin-top:5px}
</style>
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<div id="button-savemaster">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="saveMaster()" style="width:70px;">Save</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg-master').dialog('close')" style="width:70px;">Close</a>
</div>

<div id="button-updatemaster">
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="updateMaster()" style="width:70px;">Update</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg-master').dialog('close')" style="width:70px;">Close</a>
</div>

<div id="dlg-master" class="easyui-dialog" title="Asset Master" fit="false" style="width:50%;height:489px">

  <form id="fm-master" method="post" novalidate>
    <div class="easyui-panel" title="" headerCls="headcls" style="width:100%;">
      <!-- <header style="height:40px" data-options="closable:false,collapsible:true">
        <div class="panel-title f-full">
          <span style="display:inline-block;line-height:30px">&nbsp;&nbsp;Asset Master
          </div>
          &nbsp;<a href="#" class="easyui-linkbutton" id="saveBtnFm" iconCls="icon-save" onclick="saveData()" style="width:70px;height:30px">Save</a>
          &nbsp;<a href="<php echo site_url() . '/../content/operation/maintenance/asset'; ?>" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:70px;height:30px">Cancel</a>
        </span>
      </header> -->

      <div id="csslayout" class="easyui-layout" fit="true" style="width:100%;">
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Asset ID</span>
          <input id="master-assetid" name="ASSET_ID" class="easyui-textbox" style="width:20%" data-options="required:true">
          <text style="width:0.5%"></text>
          <span class="input-group-text" style="width:20%">Inactive Date</span>
          <text style="width:0.5%"></text>
          <input id="master-inactive" class="easyui-checkbox">
          <text style="width:0.5%"></text>
          <input id="master-inactivedate" name="INACTIVEDATE" class="easyui-datebox" style="width:20%" data-options="readonly:true">
        </div>

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Asset Name</span>
          <input name="ASSETNAME" class="easyui-textbox" style="width:79.5%;" data-options="required:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Parent Asset ID</span>
          <input id="master-parentid" name="PARENT_ASET_ID" class="easyui-combotreegrid" style="width:20%" data-options="required:false">
          <text style="width:0.5%"></text>
          <input id="master-parentname" name="PARENTNAME" class="easyui-textbox" style="width:59%;" data-options="readonly:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Seq. Number</span>
          <input name="SEQ" class="easyui-numberbox" style="width:20%" data-options="required:false">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Asset Location</span>
          <input id="master-assetlocationcode" name="ASSETLOCATION_CODE" class="easyui-combotreegrid" style="width:20%" data-options="required:true">
          <text style="width:0.5%"></text>
          <input id="master-assetlocationname" class="easyui-textbox" style="width:59%;" data-options="readonly:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Fixed Asset Code</span>
          <input id="master-fixedassetcode" name="FIXEDASSETCODE" class="easyui-combogrid" style="width:79.5%;" data-options="required:false">
          <!-- <text style="width:0.5%"></text>
          <input class="easyui-textbox" style="width:30%;" data-options="readonly:true"> -->
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Specification</span>
          <input id="master-spesification" name="SPESIFICATION" class="easyui-textbox" style="width:79.5%;" data-options="readonly:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Brand</span>
          <input id="master-brand" name="BRAND" class="easyui-textbox" style="width:29.5%;" data-options="readonly:true">
          <text style="width:0.5%"></text>
          <span class="input-group-text" style="width:20%">Made IN</span>
          <input id="master-madein" name="MADEIN" class="easyui-textbox" style="width:29.5%;" data-options="readonly:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Serial Number</span>
          <input id="master-serialnumber" name="SERIALPRODNUMBER" class="easyui-textbox" style="width:79.5%;" data-options="readonly:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Supplier</span>
          <input id="master-suppliercode" name="SUPPLIER_CODE" class="easyui-combogrid" style="width:20%" data-options="required:false">
          <text style="width:0.5%"></text>
          <input id="master-suppliername" name="SUPPLIER_NAME" class="easyui-textbox" style="width:59%;" data-options="readonly:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Install Date</span>
          <input name="INSTALLDATE" class="easyui-datebox" style="width:20%" data-options="required:false"> <text style="width:0.5%"></text>
          <span class="input-group-text" style="width:20%">Operation Start Date</span>
          <input name="DATEO_ON_OPERATION" class="easyui-datebox" style="width:20%" data-options="required:false">
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
  $('#button-savemaster').hide();
  $('#button-updatemaster').hide();
  MasterParentTree();
})

$(document).ready(function(){
  $('#master-inactive').checkbox({
    onChange:function(value){
      var currentDate = new Date();
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      var sysdate = currentDate.getDate() + "-" + months[currentDate.getMonth()] + "-" + currentDate.getFullYear();

      if (value == true) {
        $('#master-inactivedate').datebox('setValue', sysdate);
      } else {
        $('#master-inactivedate').datebox('clear');
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

// $(function () {
//   $('#master-assetid').textbox({
//     validType: 'remote["<php echo site_url().'/../content/operation/maintenance/asset/checkAssetMaster'; ?>","q"]'
//   });
// });
function MasterParentTree(){
  $('#master-parentid').combotreegrid({
    url: "<?php echo site_url().'/../content/operation/maintenance/asset/getAssetMaster'; ?>",
    panelWidth: 820,
    editable:true,
    idField:'ASSET_ID',
    textField:'ASSET_ID',
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
    onChange: function(value){
      if (value == ''){
        $('#master-parentname').textbox('clear');
        $('#master-assetlocationcode').textbox({readonly:false});
        $('#master-assetlocationcode').textbox('clear');
        $('#master-assetlocationname').textbox('clear');
      }
    },
    onSelect: function(row){
      $('#master-parentname').textbox('setValue',row.ASSETNAME);
      $('#master-assetlocationcode').textbox('setValue',row.ASSETLOCATION_CODE);
      $('#master-assetlocationcode').textbox({readonly:true});
      $('#master-assetlocationname').textbox('setValue',row.LOCATIONNAME);
    }
  });

  parentid = $('#master-parentid').textbox('getValue');
  // alert(parentid)
  if (parentid == ''){
    $('#master-assetlocationcode').textbox({readonly:false});
  }

}

$('#master-assetlocationcode').combotreegrid({
  url: "<?php echo site_url().'/../content/operation/maintenance/asset/getAssetLocation'; ?>",
  panelWidth: 820,
  editable:true,
  idField:'LOCATION_CODE',
  textField:'LOCATION_CODE',
  treeField:'DESCRIPTION',
  columns: [[
    {field:'DESCRIPTION',title:'Asset Name',width:700},
    {field:'LOCATION_CODE',title:'Asset ID',width:100}
  ]],
  filter: function(q, row) {
    var idMatch = row['LOCATION_CODE'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
    var nameMatch = row['DESCRIPTION'].toLowerCase().indexOf(q.toLowerCase()) >= 0;
    // Combine the conditions using AND (&&)
    return idMatch || nameMatch;
  },
  onBeforeSelect: function (node) {
    if (!node.children || node.children.length === 0) {
      return true;
    } else {
      $('#master-assetlocationcode').combotreegrid('clear');
      $('#master-assetlocationname').textbox('clear');
      return false;
    }
  },
  onSelect: function(row){
    $('#master-assetlocationname').textbox('setValue',row.DESCRIPTION);
  }
});

$('#master-fixedassetcode').combogrid({
  panelWidth: 1100,
  url: "<?php echo site_url().'/../content/operation/maintenance/asset/getFaFixedAsset'; ?>",
  idField:'FIXEDASSETCODE',
  textField:'myfield',
  mode:'remote',
  loadMsg: 'Loading',
  pagination: true,
  rownumbers:true,
  fitColumns:true,
  multiple:false,
  columns: [[
    {field:'FIXEDASSETCODE',title:'FIXEDASSETCODE',width:200},
    {field:'ASSETNAME',title:'ASSETNAME',width:300},
    {field:'SPESIFICATION',title:'SPESIFICATION',width:300},
    {field:'BRAND',title:'BRAND',width:100},
    {field:'MADEIN',title:'MADEIN',width:100},
    {field:'SERIALPRODNUMBER',title:'SERIALPRODNUMBER',width:100}
  ]],
  onSelect: function(index,row){
    $('#master-spesification').textbox('setValue',row.SPESIFICATION);
    $('#master-brand').textbox('setValue',row.BRAND);
    $('#master-madein').textbox('setValue',row.MADEIN);
    $('#master-serialnumber').textbox('setValue',row.SERIALPRODNUMBER);
  },
  loadFilter: function(data){
    if ($.isArray(data)){
      data = {total:data.length,rows:data};
    }
    $.map(data.rows, function(row){
      row.myfield = row.FIXEDASSETCODE +' - '+row.ASSETNAME;
    });
    return data;
  },
});

$('#master-suppliercode').combogrid({
  panelWidth: 500,
  url: "<?php echo site_url().'/../content/operation/maintenance/asset/getSupplier'; ?>",
  idField:'SUPPLIERCODE',
  textField:'SUPPLIERCODE',
  mode:'remote',
  loadMsg: 'Loading',
  pagination: true,
  rownumbers:true,
  fitColumns:true,
  multiple:false,
  columns: [[
    {field:'SUPPLIERCODE',title:'SUPPLIERCODE',width:150},
    {field:'SUPPLIERNAME',title:'SUPPLIERNAME',width:350}
  ]],
  onSelect: function(index,row){
    $('#master-suppliername').textbox('setValue',row.SUPPLIERNAME);
  }
});
</script>


<script type="text/javascript">
  function saveMaster() {
    $('#fm-master').form('submit', {
      url: "<?php echo site_url().'/../content/operation/maintenance/asset/saveMaster'; ?>",
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
          SearchMaster();
          $('#dlg-master').dialog('close');
          $('#tg-assetmaster').treegrid('reload'); // reload the user data
          $('#master-parentid').combotreegrid('reload');
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
  function updateMaster() {
    $('#fm-master').form('submit', {
      url: "<?php echo site_url().'/../content/operation/maintenance/asset/updateMaster'; ?>",
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
          SearchMaster();
          $('#dlg-master').dialog('close');
          $('#tg-assetmaster').treegrid('reload'); // reload the user data
          $('#master-parentid').combotreegrid('reload');

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
