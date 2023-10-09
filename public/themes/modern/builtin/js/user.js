/**
* Written by: Agus Prawoto Hadi
* Year		: 2020
* Website	: jagowebdev.com
*/

jQuery(document).ready(function () {
	
	if ($('#table-result').length) {
		column = $.parseJSON($('#dataTables-column').html());
		url = $('#dataTables-url').html();
		table =  $('#table-result').DataTable( {
			"processing": true,
			"serverSide": true,
			"scrollX": true,
			"ajax": {
				"url": url,
				"type": "POST"
			},
			"columns": column,
			"initComplete": function( settings, json ) {
				table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
					$row = $(this.node());
					/* this
						.child(
							$(
								'<tr>'+
									'<td>'+rowIdx+'.1</td>'+
									'<td>'+rowIdx+'.2</td>'+
									'<td>'+rowIdx+'.3</td>'+
									'<td>'+rowIdx+'.4</td>'+
								'</tr>'
							)
						)
						.show(); */
				} );
			 }
		} );
	}
});