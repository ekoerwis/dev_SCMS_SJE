function check_DB_F_GS_CHECK_TRANS_DATE_N(p_date='',p_module='',id_form='',id_btnSave=''){

    var url_module =  document.getElementById('url_module_html').value;

    $.ajax({
        url: url_module+"/check_DB_F_GS_CHECK_TRANS_DATE_N",
        data: { 
          tgl:p_date,
          module:p_module
        },
        type: 'post',
        success: function(response) {
            // alert(url_module+"/checkTransDate");                    
            objHistory = JSON.parse(response);
            // $("#testResult").html(objHistory.length);
            // alert(toString(objHistory[0]));
            // alert(objHistory.length);
            if(objHistory.length > 0){
                if(parseInt(objHistory) >= 0){
                  // alert("periode benar");
                } else {
                  // alert("periode salah krn status : "+objHistory);
                  alert("Periode salah karena periode tertutup ");
                  disableForm(id_form,id_btnSave);
                }
            } else {
                alert("Periode salah karena periode tidak terdeteksi ");
                disableForm(id_form,id_btnSave);
            }                    
        },
        error: function (jqXHR, textStatus, errorThrown){
            // alert(url_module+"/checkTransDate");
            // alert('Error get data from ajax');
            alert("Periode salah karena ajax error");
            disableForm(id_form,id_btnSave);
        }
    });

}

function deactivationFormByStatus(p_stat='',id_form='',id_btnSave='',p_message='Status tidak diizinkan'){

    const stat=Number(p_stat);

    if(stat == 0){
        alert(p_message);
        disableForm(id_form,id_btnSave);

    }

}

function disableForm(id_form='',id_btnSave='') {
    
      var form = $('#' + id_form );

      const box = document.getElementById(id_btnSave);
      box.style.display = 'none';

      // var form = $('#' + id_form + '_Form');
      // var btn = $('#' + id_form + '_Toggle');
      // var lock = $('#' + id_form + '_Locked');
      // btn.linkbutton({
      //     text: 'Unlock <span class="offset-up" uk-icon="icon:lock"></span>'
      // });
      // lock.val(1);
      form.find('.easyui-textbox').each(function() {
          $(this).textbox('readonly', true);
      });
      form.find('.easyui-combobox').each(function() {
          $(this).combobox('readonly', true)
      });
      form.find('.easyui-datebox').each(function() {
          $(this).datebox('readonly', true)
      });
      form.find('.easyui-numberbox').each(function() {
          $(this).numberbox('readonly', true)
      });
      form.find('.easyui-combogrid').each(function() {
          $(this).combogrid('readonly', true)
      });
      form.find('.easyui-checkbox').each(function() {
        $(this).checkbox('readonly', true)
    });
      
}

function enabledForm(id_form='',id_btnSave='') {
    
    var form = $('#' + id_form );

    const box = document.getElementById(id_btnSave);
    box.style.display = 'inline-block';

    // var form = $('#' + id_form + '_Form');
    // var btn = $('#' + id_form + '_Toggle');
    // var lock = $('#' + id_form + '_Locked');
    // btn.linkbutton({
    //     text: 'Unlock <span class="offset-up" uk-icon="icon:lock"></span>'
    // });
    // lock.val(1);
    form.find('.easyui-textbox').each(function() {
        $(this).textbox('readonly', false);
    });
    form.find('.easyui-combobox').each(function() {
        $(this).combobox('readonly', false)
    });
    form.find('.easyui-datebox').each(function() {
        $(this).datebox('readonly', false)
    });
    form.find('.easyui-numberbox').each(function() {
        $(this).numberbox('readonly', false)
    });
    form.find('.easyui-combogrid').each(function() {
        $(this).combogrid('readonly', false)
    });
    form.find('.easyui-checkbox').each(function() {
      $(this).checkbox('readonly', false)
  });
    
}