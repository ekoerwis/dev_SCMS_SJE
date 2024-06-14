    <!--- DATA GRID ------------------------------------------------------------------------->
    <table id="dg" style="<?php echo $tinggi_dg; ?>"  >

        <!-- frozenColumns:[[
                        {field:'JVNO',title:'No. JV',width:180,align:'',halign:'center'},
                    ]], -->
        <thead>
            <tr>
                <!-- <th field="PARAMETERCODE" halign="center" data-options="sortable:false,width:100 " formatter=""><b>Parameter Code</b></th> -->
                <th field="PARAMETERNAME" halign="center" data-options="sortable:false,width:250 " formatter=""><b>Parameter Name</b></th>
                <th field="CONTROLSYSTEM" halign="center" data-options="sortable:false,width:100 " formatter=""><b>Control System</b></th>
                <th field="UOM" halign="center" data-options="sortable:false,width:100 " formatter=""><b>UOM</b></th>
                <th field="VALUE1" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="formatNumberColumnCostum"><b>Value 1</b></th>
                <th field="VALUE2" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="formatNumberColumnCostum"><b>Value 2</b></th>
                <th field="VALUE3" halign="center" data-options="sortable:false,width:100 " formatter=""><b>Value 3</b></th>
                <th field="INACTIVE" halign="center" data-options="sortable:false,width:100,align:'right' " formatter="formatNumberColumnCostum"><b>Inactive</b></th>
                <th field="INACTIVEDATE" halign="center" data-options="sortable:false,width:100 " formatter=""><b>Inactive Date</b></th>
            </tr>
        </thead>
    </table>
    <!--- END GRID ------------------------------------------------------------------------->
    <!--- BUTTON TAMBAH EDIT DELETE GRID ---------------------------------------------------------->
    <div id="tb-pv" style="" class=" col row mt-1">
        <div class="col-md-auto">
            <?php if (strtolower($auth_tambah) == 'yes') { ?>
                <!-- <a href="javascript:void(0)" class="easyui-linkbutton icon-crud icon-crud-tabp icon-crud-tabl icon-crud-mobp icon-crud-mobl" iconCls="icon-add" plain="true" onclick="addData()" style="width:80px;height:30px;line-height:25px;color:white;background: #00a300;">
                    <b class="texthidden-tabp texthidden-mobp">Add</b></a> -->
                    <button id="btn-add" class="btn btn-success btnSearch" onclick="addData()" style="width: 80px;"><i class="fas fa-plus"></i> Add</button>
            <?php } ?>
            <?php if (strtolower($auth_ubah) == 'all') { ?>
                <!-- <a href="javascript:void(0)" class="easyui-linkbutton icon-crud icon-crud-tabp icon-crud-tabl icon-crud-mobp icon-crud-mobl" iconCls="icon-edit" plain="true" onclick="updateData()" style="width:80px;height:30px;line-height:25px;color:white;background:#ffc40d;">
                    <b class="texthidden-tabp texthidden-mobp">Edit</b></a> -->
                    <button id="btn-edit" class="btn btn-warning btnSearch" onclick="updateData()" style="width: 80px;"><i class="fas fa-pen"></i> Edit</button>
            <?php } ?>
            <?php if (strtolower($auth_hapus) == 'all') { ?>
                <!-- <a href="javascript:void(0)" class="easyui-linkbutton btndisabled icon-crud icon-crud-tabp icon-crud-tabl icon-crud-mobp icon-crud-mobl" iconCls="icon-remove" plain="true" onclick="deleteData()" style="width:80px;height:30px;line-height:25px;color:white;background:#ee1111;">
                    <b class="texthidden-tabp texthidden-mobp">Delete</b></a> -->
                    <button id="btn-delete" class="btn btn-danger btnSearch" onclick="deleteData()" style="width: 80px;"><i class="fas fa-minus"></i> Delete</button>
            <?php } ?>
        </div>
        <div class="col row mr-2">
            <div class="col row">
                <input id="cg-module" name="MODULECODE" style="width:200px;" data-options="" prompt="Modul">
                &nbsp;
                <input id="p_cgrid" class="easyui-textbox" style="width:300px;" prompt="Cari Keyword"></input>
            </div>
            <div class="col-md-auto row">
                <!-- <a href="#" class="easyui-linkbutton mr-1" plain="true" iconCls="icon-search" onclick="doSearch()" style="width:40px;height:30px;line-height:25px;background:#99b433;"></a>
                <a href="#" class="easyui-linkbutton" plain="true" iconCls="icon-reload" onclick="doSearchReset()" style="width:40px;height:30px;line-height:25px;background:#99b433;"></a> -->
                <button id="btn-print" class="btn btn-primary btnSearch" onclick="doSearch()" style="width: 100px;"><i class="fas fa-search"></i> Search</button>
                &nbsp;
                <button id="btn-print" class="btn btn-danger btnResetSearch" onclick="doSearchReset()" style="width: 100px;"><i class="fas fa-eraser"></i> Clear</button>
            </div>
        </div>
    </div>

    <script type="text/javascript">

    $(document).ready(function() {

        $('#cg-module').combogrid({
            panelWidth: 350,
            url: "<?php echo site_url() . '/../Content/GeneralSetup/ParameterMasterTrxi/getModuleList'; ?>",
            idField: 'CODE',
            textField: 'CODE',
            mode: 'remote',
            loadMsg: 'Loading',
            pageSize:50,
            pagination: true,
            fitColumns: true,
            multiple: false,
            columns: [
                [{
                        field: 'CODE',
                        title: 'Kode',
                        width: 200
                    },
                ]
            ],
            onSelect: function(index, row) {
            }
        });


    });
        

$(function() {
            $('#dg').datagrid({
                url:"<?php echo site_url() . '/../Content/GeneralSetup/ParameterMasterTrxi/dataList'; ?>",
                toolbar:"#tb-pv" ,
                pageSize:50,
                striped:true,
                fitColumns:false,
                pagination:true,
                nowrap:false,
                rownumbers:true,
                singleSelect:true,
                frozenColumns:[[
                    {field:'PARAMETERCODE',title:'Paramter Code',width:100,align:'',halign:'center',sortable:true},
                ]],
                view: detailview,
                detailFormatter: function(rowIndex, rowData) {
                    var tableReturn =" ";
                    tableReturn += "<table class='table table-striped' style='margin-top:5px;'> ";
                    tableReturn += '<tr> <th colspan="13" style="text-align:center;padding:3px 3px;"> Parameter Value</tt> </tr>';
                    tableReturn += "<tr style='text-align:center;padding:3px 3px 3px 3px;'>";
                    tableReturn += "<th style='width:50px;padding:3px 3px 3px 3px;vertical-align: middle;'>No</th>";
                    tableReturn += "<th style='padding:3px 3px 3px 3px;vertical-align: middle;'>Code</th>";
                    tableReturn += "<th style='text-align:center;padding:3px 3px 3px 3px;'> Value</th>";
                    tableReturn += "<th style='text-align:center;padding:3px 3px 3px 3px;'>UOM</th>";
                    tableReturn += "<th style='text-align:center;padding:3px 3px 3px 3px;'>Seq</th>";
                    tableReturn += "<th style='text-align:center;padding:3px 3px 3px 3px;'>Rate</th>";
                    tableReturn += "<th style='text-align:center;padding:3px 3px 3px 3px;'>Min</th>";
                    tableReturn += "<th style='text-align:center;padding:3px 3px 3px 3px;'>Max</th>";
                    tableReturn += "<th style='text-align:center;padding:3px 3px 3px 3px;'>Value 1</th>";
                    tableReturn += "<th style='text-align:center;padding:3px 3px 3px 3px;'>Value 2</th>";
                    tableReturn += "<th style='text-align:center;padding:3px 3px 3px 3px;'>Value Text</th>";
                    tableReturn += "<th style='text-align:center;padding:3px 3px 3px 3px;'>Inactive</th>";
                    tableReturn += "<th style='text-align:center;padding:3px 3px 3px 3px;'>Inactive Date</th>";
                    tableReturn += "</tr>";

                    var jmlDetail=0;
                    var jmlDetail =rowData.dataDetail.length;
                    if (jmlDetail == 0) {
                        tableReturn += '<tr> <td colspan="13" style="text-align:center;padding:3px 3px;"> Tidak Ada Parameter Terdaftar</td> </tr>';
                    } 
                    else {                        
                        for(var i = 0 ; i<jmlDetail ; i++){
                            
                            if (rowData.dataDetail[i].PARAMETERCODE == null) {
                                PARAMETERCODE = '';
                            } else {
                                PARAMETERCODE = rowData.dataDetail[i].PARAMETERCODE;
                            }

                            if (rowData.dataDetail[i].PARAMETERVALUECODE == null) {
                                PARAMETERVALUECODE = '';
                            } else {
                                PARAMETERVALUECODE = rowData.dataDetail[i].PARAMETERVALUECODE;
                            }

                            if (rowData.dataDetail[i].PARAMETERVALUE == null) {
                                PARAMETERVALUE = '';
                            } else {
                                PARAMETERVALUE = rowData.dataDetail[i].PARAMETERVALUE;
                            }

                            if (rowData.dataDetail[i].UOM == null) {
                                UOM = '';
                            } else {
                                UOM = rowData.dataDetail[i].UOM;
                            }

                            if (rowData.dataDetail[i].SEQ_NO == null) {
                                SEQ_NO = '';
                            } else {
                                SEQ_NO = rowData.dataDetail[i].SEQ_NO;
                            }

                            if (rowData.dataDetail[i].RATE == null) {
                                RATE = '';
                            } else {
                                RATE = rowData.dataDetail[i].RATE;
                            }

                            if (rowData.dataDetail[i].MIN == null) {
                                MIN = '';
                            } else {
                                MIN = rowData.dataDetail[i].MIN;
                            }

                            if (rowData.dataDetail[i].MAX == null) {
                                MAX = '';
                            } else {
                                MAX = rowData.dataDetail[i].MAX;
                            }

                            if (rowData.dataDetail[i].VALUE1 == null) {
                                VALUE1 = '';
                            } else {
                                VALUE1 = rowData.dataDetail[i].VALUE1;
                            }

                            if (rowData.dataDetail[i].VALUE2 == null) {
                                VALUE2 = '';
                            } else {
                                VALUE2 = rowData.dataDetail[i].VALUE2;
                            }

                            if (rowData.dataDetail[i].VALUE_TEXT == null) {
                                VALUE_TEXT = '';
                            } else {
                                VALUE_TEXT = rowData.dataDetail[i].VALUE_TEXT;
                            }

                            if (rowData.dataDetail[i].INACTIVE == null) {
                                INACTIVE = '';
                            } else {
                                INACTIVE = rowData.dataDetail[i].INACTIVE;
                            }

                            if (rowData.dataDetail[i].INACTIVEDATE == null) {
                                INACTIVEDATE = '';
                            } else {
                                INACTIVEDATE = rowData.dataDetail[i].INACTIVEDATE;
                            }

                            tableReturn += '<tr >';
                            tableReturn += ' <td style="text-align:center;padding:3px 3px;width:60px;"> '+ (i+1)+'</td> ';
                            // tableReturn += ' <td style="padding:3px 3px;"> '+ ID_ROLE+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ PARAMETERVALUECODE+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ PARAMETERVALUE+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ UOM+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ SEQ_NO+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ RATE+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ MIN+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ MAX+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ VALUE1+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ VALUE2+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ VALUE_TEXT+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ INACTIVE+'</td> ';
                            tableReturn += ' <td style="padding:3px 3px;"> '+ INACTIVEDATE+'</td> ';
                            tableReturn += '</tr>';
                        }
                    }
                    
                    // });

                    tableReturn += "</table>";

                    return tableReturn;
                }
            });
        });

        // JS Searching and Reset
        function doSearch() {
            $('#dg').datagrid('load', {
                MODULECODE: $('#cg-module').combogrid('getValue'),
                SEARCH_KEYWORD: $('#p_cgrid').textbox('getValue'),
            });
        }

        function doSearchReset() {
            $('#cg-module').combogrid('reset'),
            $('#p_cgrid').textbox('reset'),
            doSearch();
        }

        //JS addData
        function addData() {
            // $.messager.alert('Info','Menu Ini Tidak Memiliki Fitur Add, Silahkan Menggunakan Tombol Edit','info');
            url = "<?php echo site_url().'/../Content/GeneralSetup/ParameterMasterTrxi/addForm'; ?>";
            window.open(url,"_self");
        }

        //JS Update
        function updateData() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                url = "<?php echo site_url() . '/../Content/GeneralSetup/ParameterMasterTrxi/editForm?id='; ?>" + row.PARAMETERCODE;
                window.open(url, "_self");
            }
        }

        // JS Delete
        function deleteData() {
            // $.messager.alert('Info','Menu Ini Tidak Memiliki Fitur Delete, Silahkan Menggunakan Tombol Edit','info');
            
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Hapus Data Parameter: ' + row.PARAMETERCODE, function(r) {
                    if (r) {
                        $.post('<?php echo site_url() . '/../Content/GeneralSetup/ParameterMasterTrxi/deleteData'; ?>', {
                                id: row.PARAMETERCODE
                            },
                            function(result) {
                                $.messager.alert('Alert', 'Data berhasil di hapus', 'info');
                                $('#dg').datagrid('reload');
                                if (result.success) {
                                    $.messager.alert('Alert', 'Data berhasil di hapus', 'info');
                                    $('#dg').datagrid('reload');
                                } else {
                                    $.messager.show({ // show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                    });
                                }
                            }, 'json');
                    }
                });
            }
        }

        // END JS Delete


        function formatNumberColumnCostum(val, row) {
            // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var returnVal = '';
            if (val != null) {
                returnVal = parseFloat(val).format(0, 3, ',', '.');
            }
            return returnVal;
        }
    </script>