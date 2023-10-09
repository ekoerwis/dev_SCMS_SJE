<div id="alertProses" class="" role="alert" style=" display:none;"> 
  <a id=statProses> </a>
  <br>
  <a id="msgProses"></a>
  <br><br>
  <a>Password Default : <i>123456</i></a>
  <br>
  <a>Role :<i> Belum Diatur</i></a>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<?php
if ($stat_EPMS) {
?>

<table id="dg" title="" class="easyui-datagrid" style="<?php echo $tinggi_dg; ?>" url="<?php echo site_url() . '/../Builtin/UserImportEPMS/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
                    fitColumns:false,
                    pagination:true,
                    nowrap:true,
                    pageSize:50,
                    showFooter: false,
                    singleSelect:false
                    ">
    <thead>
      <tr>
        <th field="ck" checkbox="true"></th>
        <th field="LOGINID" halign="center" data-options="sortable:true,width:120"> <b>USERNAME</b> </th>
        <th field="FULLNAME" halign="center" data-options="sortable:true,width:500"><b>Nama</b></th>
      </tr>
    </thead>
  </table>
<?php
}
?>

<div id="tb-pv" class="pb-2">
  <div class='col-xl-12 col-lg-12 col-md-12 row'>
    <div class="col-xl-10 col-lg-10 col-md-10 row">
      <input id="tb-Search" name="SEARCH" class="easyui-textbox" data-options="required:false" style="width: 40%;" prompt="Search">
      &nbsp;&nbsp;&nbsp;
      <button id="btn-print" class="btn btn-primary btnSearch" onclick="doSearch()"><i class="fas fa-search"></i> Search</button>
      &nbsp;&nbsp;&nbsp;
      <button id="btn-print" class="btn btn-danger btnResetSearch" onclick="doSearchReset()"><i class="fas fa-eraser"></i> Clear</button>
    </div>
    <div></div>

    <div class="col-xl-2 col-lg-2 col-md-2 text-right pt-1">
      <button id="btn-print" class="btn btn-success btnDownloadXls" onclick="importData()"><i class="fas fa-download"></i> Import</button>
    </div>
  </div>
</div>


<div id='loadingmessage' style='display:none;position:fixed; z-index:1040; opacity: 0.5;
top:0;
left:0;
background-color: #616161;
  width : 100%;
  height : 100%;
  margin:auto;'>
  <img src='<?php echo $config->baseURL . '/public/images/Spinner_Loading_191px.gif' ?>' style=' display: block;
  margin-left: auto;
  margin-right: auto;
  padding-top : 200px' />
</div>

<script>

  // JS Searching and Reset
  function doSearch() {

    var q = $('#tb-Search').textbox('getValue');

    $('#dg').datagrid('load', {
      KEYWORD: $('#tb-Search').textbox('getValue'),
    });
  }

  function doSearchReset() {
    $('#tb-Search').textbox('reset')
  }

  function importData() {

    var ids = [];
    var rows = $('#dg').datagrid('getSelections');
    var y = document.getElementById("alertProses");

    for (var i = 0; i < rows.length; i++) {
      ids.push(rows[i].LOGINID);
    }

    $.ajax({
      url: "<?php echo site_url() . '/../Builtin/UserImportEPMS/importProses' ?>",
      type: 'POST',
      data: {
        barisData: rows,
      },
      beforeSend: function() {
        $('#loadingmessage').show();
      },
      success: function(data_feedbacksave) {
        $('#loadingmessage').hide();

        var msgFeedback = JSON.parse(data_feedbacksave);
        if (msgFeedback.status.toLowerCase() == 'success') {
          $("#alertProses").addClass("alert alert-dismissible alert-success");
        } else if (msgFeedback.status.toLowerCase() == 'warning') {
          $("#alertProses").addClass("alert alert-dismissible alert-warning");
        } else {
          $("#alertProses").addClass("alert alert-dismissible alert-danger");
        }

        $("#statProses").html('PROSES '+msgFeedback.status.toUpperCase()+' ,PENGATURAN SELANJUTNYA ADA PADA FITUR USERS');
        $("#msgProses").html(msgFeedback.msg);
        y.style.display = "block";

        doSearch();
      },
      error: function() {
        $('#loadingmessage').hide();
        $("#alertProses").addClass("alert alert-dismissible alert-danger");
        $("#statProses").html("ERROR !");
        $("#msgProses").html("Error : Hubungi Administrator !");
        y.style.display = "block";
        doSearch();
      }

    });
  }
</script>