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
