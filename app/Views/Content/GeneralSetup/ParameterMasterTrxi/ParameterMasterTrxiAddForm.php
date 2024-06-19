<style>
#csslayout{padding-left:5px;padding-top:5px;padding-right: 5px;margin-right:0px;margin-bottom:0px;}

/* .datagrid-header-row, .datagrid-row {
  height:22px;
} */

.radiobutton,
.textbox-label {
  margin-top: 5px;
  margin-left: 10px;
}

.panel-title {
  background: #39c2c6;
  color:white;
  font-size: 14px;
  height: 24px;
  line-height: 24px;
}
</style>
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<form id="fm" method="post" novalidate>
    <div class="easyui-layout " fit="false" style="width:100%;">
        <div class="easyui-panel " title="" headerCls="headcls" style="width:100%;padding:10px 50px;"
            data-options="closable:false,collapsible:true,tools:'#tt'">
            <header style="height:40px" data-options="closable:false,collapsible:true">
                <div class="panel-title f-full">
                    <span style="display:inline-block;line-height:30px">&nbsp;Parameter Master</span>
                </div>
                &nbsp;<a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveData()"
                    style="width:70px;height:30px">Save</a>
                &nbsp;<a href="<?php echo site_url() . '/../content/GeneralSetup/ParameterMasterTrxi'; ?>"
                    class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')"
                    style="width:70px;height:30px">Cancel</a>
                </span>
            </header>

            <div class="form-group row">

                <div class="form-group col-sm-7">
                    <div class="row col-sm-12 divbottom">
                        <label class="col-sm-3 col-form-label"> Parameter Code </label>
                        <div class="col-sm-9">
                            <input name="PARAMETERCODE" class="easyui-textbox col-sm-4" data-options="required:true"
                                validType="remote['<?php echo site_url() . '/../content/GeneralSetup/ParameterMasterTrxi/checkUniqueCode'; ?>','PARAMETERCODE']"
                                invalidMessage="Kode Harus Unik" prompt="Parameter Code"></input>
                            <input name="PARAMETERNAME" class="easyui-textbox col-sm-7" data-options="required:true"
                                prompt="Parameter Name"></input>
                        </div>
                    </div>

                    <div class="row col-sm-12 divbottom">
                        <label class="col-sm-3 col-form-label"> Control System </label>
                        <div class="col-sm-9">
                            <input name="CONTROLSYSTEM" class="easyui-textbox col-sm-4" data-options="required:true"
                                prompt="Control System"></input>
                        </div>
                    </div>

                    <div class="row col-sm-12 divbottom" hidden>
                        <label class="col-sm-3 col-form-label"> UOM </label>
                        <div class="col-sm-9">
                            <input id="cg-uom" name="UOM" class="easyui-combogrid col-sm-4"
                                data-options="required:false" prompt="UOM / Satuan"></input>
                            <input id="tb-uomdesc" name="UOMDESC" class="easyui-textbox col-sm-7"
                                data-options="required:false, readonly:true" prompt="UOM Desc"></input>
                        </div>

                        <script>
                            // $(document).ready(function(){
                            $('#cg-uom').combogrid({
                                panelWidth: 400,
                                pageSize: 50,
                                url: "<?php echo site_url() . '/../content/GeneralSetup/ParameterMasterTrxi/getUOM'; ?>",
                                idField: 'UNITOFMEASURECODE',
                                textField: 'UNITOFMEASURECODE',
                                mode: 'remote',
                                loadMsg: 'Loading',
                                pagination: true,
                                rownumbers: true,
                                fitColumns: true,
                                multiple: false,
                                columns: [[
                                    { field: 'UNITOFMEASURECODE', title: 'UOM', width: 200 },
                                    { field: 'UNITOFMEASUREDESC', title: 'Name', width: 200 }

                                ]],
                                onSelect: function (index, row) {
                                    var desc = row.UNITOFMEASUREDESC;
                                    $('#tb-uomdesc').textbox('setValue', desc);
                                }
                            });
                        </script>
                    </div>

                    <div class="row col-sm-12 divbottom">
                        <label class="col-sm-3 col-form-label"> Value </label>
                        <div class="col-sm-9">
                            <input name="VALUE1" class="easyui-numberbox col-sm-3" data-options="required:false"
                                prompt="Value 1"></input>
                            <input name="VALUE2" class="easyui-numberbox col-sm-3" data-options="required:false"
                                prompt="Value 2"></input>
                            <input name="VALUE3" class="easyui-numberbox col-sm-3" data-options="required:false"
                                prompt="Value 3"></input>
                        </div>
                    </div>

                    <div class="row col-sm-12 divbottom">
                        <label class="col-sm-3 col-form-label"> Inactive Date </label>
                        <div class="col-sm-9">
                            <input id="checkInactive" type="checkbox">&nbsp;
                            <input id="ChangeInactive" name="INACTIVE" type="textbox" value="0" hidden>
                            <input id="checkDate" name="INACTIVEDATE" class="easyui-textbox col-sm-6"
                                data-options="readonly:true"></input>
                            <script type="text/javascript">
                                $(function () {
                                    $('#checkInactive').change(function () {
                                        if ($(this).is(':checked')) {
                                            // Do something...
                                            var checkin = "1";
                                            $('#ChangeInactive').val(checkin);
                                            var today = new Date();
                                            var dd = String(today.getDate()).padStart(2, '0');
                                            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                                            var yyyy = today.getFullYear();

                                            today = dd + '-' + mm + '-' + yyyy;
                                            $('#checkDate').textbox('setValue', today);
                                        } else {
                                            var uncheckin = "0";
                                            $('#ChangeInactive').val(uncheckin);
                                            empty = '';
                                            $('#checkDate').textbox('setValue', empty)
                                        };
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    <!-- End Div From Group -->
                </div>
            </div>


        </div>
    </div>

    <!-- <div class="easyui-layout " fit="false" style="width:100%;">
        <div class="easyui-panel " title="" headerCls="headcls" style="width:100%;padding:10px 50px;"
            data-options="closable:false,collapsible:true,tools:'#tt'">
            <header style="height:40px" data-options="closable:false,collapsible:true">
                <div class="panel-title f-full">
                    <span style="display:inline-block;line-height:30px">&nbsp;Parameter Master Detail </span>
                </div>
            </header>
        </div>
    </div> -->

    <div data-options="region:'center',split:true" title="">
        <table id="dg" title="&nbsp;Parameter Detail "
            style="width:100%;min-height:<?php echo '400px;';//$tinggiDetail; ?>" data-options="footer:'#ft'">
        </table>
        <div id="ft" style="padding:2px 5px;">
            <a id="click" href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true"
                onclick="addRow(this)"></a>
        </div>
    </div>

</form>

<!-- SCRIPT DETAIL -->

<script>
$(function() {
  $('#dg').edatagrid({
    url:'',
    // iconCls:'icon-edit',
    singleSelect: true,
    fitColumns: false,
    rownumbers: true,
    pagination: false,
    loadMsg: 'Loading',
    // autoSave:true,
    // dblclickToEdit:false,
    onLoadSuccess:function(value){
      // alert(value);
        // document.getElementById('click').click();
      //   addRow('');
    },
    frozenColumns:[[
        {
            field: 'ACTION', halign: 'center', title: 'Action', width: 80, align: 'center',
            formatter: function (value, row, index) {
                var d = '<a href="javascript:void(0)" onclick="deleterow(this)">Delete</a>';
                return d;
            }
        },
        { field: 'PARAMETERVALUECODE', halign: 'center', align: 'left', title: 'Code', width: 100, editor: { type: 'textbox', options: { required: true } } },
        { field: 'PARAMETERVALUE', halign: 'center', align: 'left', title: 'Value', width: 200, editor: { type: 'textbox', options: { required: true } } },
    ]],
    columns:[[
        // {
            // field: 'UOM_D', halign: 'center', title: 'UOM', width: 100, editor: {
            //     type: 'combogrid',
            //     options: {
            //         panelWidth: 400,
            //         pageSize: 50,
            //         url: "<?php //echo site_url() . '/../content/GeneralSetup/ParameterMasterTrxi/getUOM'; ?>",
            //         idField: 'UNITOFMEASURECODE',
            //         textField: 'UNITOFMEASURECODE',
            //         required: false,
            //         editable: true,
            //         pagination: true,
            //         rownumbers: true,
            //         fitColumns: true,
            //         loadMsg: 'Loading',
            //         mode: 'remote',
            //         columns: [[
            //             { field: 'UNITOFMEASURECODE', title: 'UOM', width: 50 },
            //             { field: 'UNITOFMEASUREDESC', title: 'DESC', width: 100 }
            //         ]],
            //     }
            // }
        // },
        { field: 'UOM_D', halign: 'center', title: 'UOM', width: 75, editor: { type: 'textbox', options: {} } },
        { field: 'MIN_D',  halign: 'center', align: 'right', title: 'Min', width: 75, editor: { type: 'numberbox', options: { required: false, precision: 2, groupSeparator: ',', decimalSeparator: '.' } } },
        { field: 'MAX_D',  halign: 'center', align: 'right', title: 'Max', width: 75, editor: { type: 'numberbox', options: { required: false, precision: 2, groupSeparator: ',', decimalSeparator: '.' } } },
        { field: 'SEQ_NO_D',  halign: 'center', align: 'right', title: 'Seq', width: 75, editor: { type: 'numberbox', options: { required: false, precision: 0, groupSeparator: ',', decimalSeparator: '.' } } },
        { field: 'VALUE1_D',  halign: 'center', align: 'right', title: 'Value 1', width: 75, editor: { type: 'numberbox', options: { required: false, precision: 2, groupSeparator: ',', decimalSeparator: '.' } } },
        { field: 'VALUE2_D',  halign: 'center', align: 'right', title: 'Value 2', width: 75, editor: { type: 'numberbox', options: { required: false, precision: 2, groupSeparator: ',', decimalSeparator: '.' } } },
        { field: 'VALUE_TEXT_D', halign: 'center', title: 'Value Text', width: 300, editor: { type: 'textbox', options: {} } },
      
      
    ]
    ],
    onBeginEdit: function(index, row){
        var x = index;

        var parametervaluecode = $(this).datagrid('getEditor', { index: index, field: 'PARAMETERVALUECODE' });
        var parametervalue = $(this).datagrid('getEditor', { index: index, field: 'PARAMETERVALUE' });
        var uom = $(this).datagrid('getEditor', { index: index, field: 'UOM_D' });
        var min = $(this).datagrid('getEditor', { index: index, field: 'MIN_D' });
        var max = $(this).datagrid('getEditor', { index: index, field: 'MAX_D' });
        var seq_no = $(this).datagrid('getEditor', { index: index, field: 'SEQ_NO_D' });
        var value1 = $(this).datagrid('getEditor', { index: index, field: 'VALUE1_D' });
        var value2 = $(this).datagrid('getEditor', { index: index, field: 'VALUE2_D' });
        var value_text = $(this).datagrid('getEditor', { index: index, field: 'VALUE_TEXT_D' });

    },
    onEndEdit:function(index,row){
      var ed = $(this).datagrid('getEditor', {
        index: index,
        field: 'PARAMETERVALUECODE'
      });
    },
    onBeforeEdit:function(index,row){
      row.editing = true;
      $(this).datagrid('refreshRow', index);

    },
    onAfterEdit:function(index,row){
      row.editing = false;
      $(this).datagrid('refreshRow', index);
    },
    onCancelEdit:function(index,row){
      row.editing = false;
      $(this).datagrid('refreshRow', index);
    },
  })
})


function getRowIndex(target){
  var tr = $(target).closest('tr.datagrid-row');
  return parseInt(tr.attr('datagrid-row-index'));
}
function editrow(target){
  $('#dg').datagrid('beginEdit', getRowIndex(target));
}
function deleterow(target){
  $.messager.confirm('Confirm','Are you sure?',function(r){
    if (r){
      $('#dg').datagrid('deleteRow', getRowIndex(target));
    }
  });
}

function addRow(target){
  $('#dg').edatagrid('addRow');
  var data = $('#dg').datagrid('getRows');
  for (var i = 0; i < data.length; i++) {
    $('#dg').datagrid('beginEdit', i);
  }
}

function saverow(target){
  $('#dg').datagrid('endEdit', getRowIndex(target));
}
function cancelrow(target){
  $('#dg').datagrid('cancelEdit', getRowIndex(target));
}
</script>

<!-- BATAS SCRIPT DETAIL -->


<script>
    // $(document).ready(function () {
    //     $('#uniqueCode').textbox({
    //         inputEvents: $.extend({}, $.fn.textbox.defaults.inputEvents, {
    //             keyup: function (e) {
    //                 checkcode($('#uniqueCode').textbox('getText'));
    //             }
    //         })
    //     });
    // });
</script>

<!-- save tambah data -->
<script type="text/javascript">
    function saveData() {
        $('#fm').form('submit', {
            url: '<?php echo site_url() . '/../content/GeneralSetup/ParameterMasterTrxi/saveData'; ?>',
      onSubmit: function() {
        var valid = $(this).form('validate');
        if (valid) {
          loadingBar('on');
        } else {
          return valid;
        }

        var data = $('#dg').datagrid('getRows');
        for (var i = 0; i < data.length; i++) {

            $('#dg').datagrid('endEdit', i);
            $('<input>').attr({
                type: 'hidden',
                name: 'PARAMETERVALUECODE[]',
                value: data[i].PARAMETERVALUECODE
            }).appendTo('#fm');

            $('<input>').attr({
                type: 'hidden',
                name: 'PARAMETERVALUE[]',
                value: data[i].PARAMETERVALUE
            }).appendTo('#fm');

            $('<input>').attr({
                type: 'hidden',
                name: 'UOM_D[]',
                value: data[i].UOM_D
            }).appendTo('#fm');

            $('<input>').attr({
                type: 'hidden',
                name: 'MIN_D[]',
                value: data[i].MIN_D
            }).appendTo('#fm');

            $('<input>').attr({
                type: 'hidden',
                name: 'MAX_D[]',
                value: data[i].MAX_D
            }).appendTo('#fm');

            $('<input>').attr({
                type: 'hidden',
                name: 'SEQ_NO_D[]',
                value: data[i].SEQ_NO_D
            }).appendTo('#fm');

            $('<input>').attr({
                type: 'hidden',
                name: 'VALUE1_D[]',
                value: data[i].VALUE1_D
            }).appendTo('#fm');

            $('<input>').attr({
                type: 'hidden',
                name: 'VALUE2_D[]',
                value: data[i].VALUE2_D
            }).appendTo('#fm');

            $('<input>').attr({
                type: 'hidden',
                name: 'VALUE_TEXT_D[]',
                value: data[i].VALUE_TEXT_D
            }).appendTo('#fm');
        }
        return true;
      },
            success: function (data_feedbacksave) {
                // tambahan substring karena aneh data hasil json ada script lain jadi json ga kebaca
                var feedbacksave = data_feedbacksave.substring(
                    data_feedbacksave.lastIndexOf("{"),
                    data_feedbacksave.lastIndexOf("}") + 1
                );

                obj = JSON.parse(feedbacksave);

                // alert(feedbacksave);
                loadingBar('off');

                if (obj.status == "ok") {
                    $.messager.alert({
                        title: 'Alert',
                        msg: obj.content,
                        fn: function () {
                            location = "<?php echo site_url() . '/../content/GeneralSetup/ParameterMasterTrxi'; ?>";
                        }
                    });

                    //If you want to allow the user to click on the Submit button now you can enable here like this :
                    $("#dlg-buttons").attr('disabled', false);
                    $('#dg').datagrid('reload'); // reload the user data
                } else {
                    loadingBar('off');
                    $.messager.alert('Alert', obj.content, 'info');
                }

            },
            error: function () {
                loadingBar('off');
                alert('Error get data from ajax');
            }
        });
    }
</script>