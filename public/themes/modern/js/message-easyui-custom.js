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


