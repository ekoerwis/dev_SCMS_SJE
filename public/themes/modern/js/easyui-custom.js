// batas format kalender
$.extend($.fn.datebox.defaults,{
  monthNames: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
  formatter:function(date){
    var opts = $(this).datebox('options');
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    return d+'-'+opts.monthNames[m]+'-'+y;
	//return (d<10?('0'+d):d)+'-'+opts.monthNames[m]+'-'+y;
  },
  parser:function(s){
    if (!s){return new Date();}
    var opts = $(this).datebox('options');
    var ss = s.split('-');
    var d = parseInt(ss[0],10);
    var m = $.inArray(ss[1], opts.monthNames);
    var y = parseInt(ss[2],10);

    if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
      return new Date(y,m,d);
    } else {
      return new Date();
    }
  }
})

$.extend($.fn.datetimebox.defaults, {
  monthNames: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
  formatter:function(date){
    var opts = $(this).datetimebox('options');
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var hh = ('0' + date.getHours()).slice(-2); // Ensure two digits
    var mi = ('0' + date.getMinutes()).slice(-2); // Ensure two digits
    var sec = ('0' + date.getSeconds()).slice(-2); // Ensure two digits

    // var hh = date.getHours();
    // var mi = date.getMinutes();
    // var sec = date.getSeconds();
    return d+'-'+opts.monthNames[m]+'-'+y+' '+hh+':'+mi+':'+sec;
  },
  parser:function(s){
    if (!s){return new Date();}
    var opts = $(this).datetimebox('options');
    var ss = s.split('-');
    var d = parseInt(ss[0],10);
    var m = $.inArray(ss[1], opts.monthNames);
    var y = parseInt(ss[2],10);

    var dt = s.split(' ');
    var tt = dt[1].split(':');
    var hh = parseInt(tt[0],10);
    var mi = parseInt(tt[1],10);
    var sec = parseInt(tt[2],10);
    return new Date(y,m,d,hh,mi,sec);
  }
})
// batas format kalender

// loading bar easyui
 function loadingBar(status='', p_title = 'Please waiting', p_msg='Loading data...'){
      if(status == "on"){
        $.messager.progress({
         title: p_title,
          msg: p_msg
          });
        var bar = $.messager.progress('bar');
        bar.progressbar({
            text: ''
          });
      } else {
        $.messager.progress('close');
      }

  }

//batas  loading bar easyui

// Merubah format number column datagrid -> <th data-options="formatter:formatdecimal">
Number.prototype.format = function(n, x, s, c) {
  var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
  num = this.toFixed(Math.max(0, ~~n));
  return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
function formatdecimal(num){
  return parseInt(num).format(2, 3, ',', '.');
}

// Format Number Custom Easyui
function formatNumberNoComma(val,row){

  if(val){
    var v = parseFloat(val);
    return isNaN(v) ? '' : parseFloat(val).format(0, 3, ',', '.');
  }else{
    return '';
  }
}

function formatNumberOneComma(val,row){

  if(val){
    var v = parseFloat(val);
    return isNaN(v) ? '' : parseFloat(val).format(1, 3, ',', '.');
  }else{
    return '';
  }
}

function formatNumberTwoComma(val,row){
  if(val){
    var v = parseFloat(val);
    return isNaN(v) ? '' : parseFloat(val).format(2, 3, ',', '.');
  }else{
    return '';
  }
}
// End Format Number Custom Easyui

// message easyui
$.map(['validatebox','textbox','passwordbox','filebox','searchbox',
    'combo','combobox','combogrid','combotree',
    'datebox','datetimebox','numberbox',
    'spinner','numberspinner','timespinner','datetimespinner'], function(plugin){
  if ($.fn[plugin]){
    $.fn[plugin].defaults.missingMessage = 'Tidak Boleh Kosong';
  }
});
if ($.fn.validatebox){
  $.fn.validatebox.defaults.rules.email.message = 'Please enter a valid email address.';
  $.fn.validatebox.defaults.rules.url.message = 'Please enter a valid URL.';
  $.fn.validatebox.defaults.rules.length.message = 'Please enter a value between {0} and {1}.';
  $.fn.validatebox.defaults.rules.remote.message = 'Please fix this field.';
}

// batas message easyui

// DISABLE ALL FORM -- CARA PAKAI -> $('#fm').form('disable');
$.extend($.fn.form.methods, {
  enable: function(jq){
    jq.form('disable','_enable_')
  },

  disable: function(jq,omit){
    var omit = '' || omit, mode = 'disable';
    if(omit == '_enable_') mode = 'enable';
    return jq.each(function(){
      var t = $(this);
      var plugins = ['textbox','combo','combobox','combotree','combogrid','datebox','datetimebox','spinner','timespinner','numberbox','numberspinner','slider','validatebox'];
      for(var i=0; i<plugins.length; i++){
        var plugin = plugins[i];
        if(plugin=='validatebox') {
          var r = t.children().find('.easyui-validatebox').not(omit);
          if (r.length) {
            if(mode=='enable') r.removeAttr('disabled');
            else r.attr('disabled','disabled');
          }
        }
        else {
          var r = t.children().find('.'+plugin+'-f').not(omit);
          if(r.length && r[plugin]) r[plugin](mode);
        }
      }
      t.form('validate');
    })
  }
})
      // TAMBAH KAN CODE DIBAWAH UNTUK DISABLED FORM
      //$('#fm').form('disable');
      // END ALL FORM DISABLED
      //var cc = $('#lov-status');
      //var data = cc.combobox('getData');
      // DISABLED ISI SELECT ROW KE 3 -> data[2]
      //data[2].disabled = true;
      //cc.combobox('loadData', data);
// BATAS DISABLE ALL FORM

// cara penggunaan di id="dg" table -> data-options : onResize:onResize
$.extend($.fn.datagrid.methods,{
  resizeColumn:function(jq,param){
    return jq.each(function(){
      var dg = $(this);
      var col = dg.datagrid('getColumnOption', param.field);
      col.boxWidth = param.width + (col.boxWidth-col.width);
      col.width = param.width;
      dg.datagrid('fixColumnSize', param.field);
    })
  }
})

function onResize(){
  var dg = $('#dg');
  var width = dg.datagrid('getPanel').width();
  var fitColumns = width<800?false:true;
  dg.datagrid('options').fitColumns = fitColumns;
  if (!fitColumns){
    var fields = dg.datagrid('getColumnFields');
    for(var i=0; i<fields.length; i++){
      var col = dg.datagrid('getColumnOption',fields[i]);
      if (col.defaultWidth){
        dg.datagrid('resizeColumn',{field:fields[i],width:col.defaultWidth})
      }
    }
  }
  dg.datagrid('fitColumns')
}

// batas cara penggunaan di id="dg" table -> data-options : onResize:onResize
