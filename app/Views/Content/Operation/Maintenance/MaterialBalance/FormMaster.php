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

<div id="dlg-master" class="easyui-dialog" title="Asset Master" fit="false" style="width:50%;">

  <form id="fm-master" method="post" novalidate>
    <div class="easyui-panel" title="" headerCls="headcls" style="width:100%;">
      
      <div id="csslayout" class="easyui-layout" fit="true" style="width:100%;">
     

        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Kode</span>
          <input id="master-parametercode" name="PARAMETERCODE" class="easyui-textbox" style="width:79.5%" data-options="required:true">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Nama</span>
          <input id="master-parametername" name="PARAMETERNAME" class="easyui-textbox" style="width:79.5%;" data-options="required:true,readonly:false">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Value</span>
          <input id="master-value" name="MASTER_VALUE"  class="easyui-numberbox" style="width:50%" data-options="required:true,min:0,precision:1">
        </div>
        <div class="input-group sm-12" style="padding-bottom:3px;">
          <span class="input-group-text" style="width:20%">Parent Node</span>
          <input id="master-parentcode" name="PARENTCODE" class="easyui-combogrid" style="width:20%" data-options="required:false">
          <text style="width:0.5%"></text>
          <input id="master-parentname" class="easyui-textbox" style="width:59%;" data-options="readonly:true">
        </div>
        

      </div>

    </div>
  </form>
</div>

<script>
$(function () {
  $('#button-savemaster').hide();
  $('#button-updatemaster').hide();
  // MasterParentTree();
  generateParentNode ();
})

$(document).ready(function(){

});
</script>

<script>

  function generateParentNode (){
    
    $('#master-parentcode').combogrid({
        panelWidth:550,
        url: "<?php echo current_url().'/getParentNode'; ?>",
        idField: 'PARAMETERCODE',
        textField: 'PARAMETERCODE',
        mode: 'remote',
        loadMsg: 'Loading',
        pagination: true,
        fitColumns: true,
        multiple: false,
        rownumbers:true,
        columns: [
          [{
            field: 'PARAMETERCODE',
            title: 'Kode',
            width: 100
          },
          {
            field: 'PARAMETERNAME',
            title: 'Deskripsi',
            width: 300
          },
        ]
      ],
        onSelect : function(index,row){
          $("#master-parentname").textbox('setValue',row.PARAMETERNAME);
        }
      });
  }

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

</script>


<script type="text/javascript">
  function saveMaster() {
    $('#fm-master').form('submit', {
      url: "<?php echo site_url().'/../content/operation/maintenance/MaterialBalance/saveData'; ?>",
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
          // SearchMaster();
          $('#dlg-master').dialog('close');
          $('#tg-materialbalance').treegrid('reload'); // reload the user data
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
  function updateMaster() {
    $('#fm-master').form('submit', {
      url: "<?php echo site_url().'/../content/operation/maintenance/MaterialBalance/updateData'; ?>",
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
          // SearchMaster();
          $('#dlg-master').dialog('close');
          $('#tg-materialbalance').treegrid('reload'); // reload the user data
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
