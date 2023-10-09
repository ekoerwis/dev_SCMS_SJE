$(document).ready(function() 
{
	$('#list-tree').wdiMenuEditor({
		expandBtnHTML   : '<button data-action="expand" class="fa fa-plus" type="button">Expand</button>',
        collapseBtnHTML : '<button data-action="collapse" class="fa fa-minus" type="button">Collapse</button>',
		editBtnCallback : function($list) 
		{
			var $button = '';
			var	$bootbox = showForm('edit');
			
			var $button = $bootbox.find('button').prop('disabled', true);
			var $loader = $bootbox.find('.loader');
			var url_detail = $('#url-detail').text();

			$.getJSON(url_detail + $list.data('id'), function(result) 
			{
				$loader.remove();
				$button.prop('disabled', false);
				
				var $form = $('#add-form').clone().show();
				$form.find('[name="id"]').val(result.ID_TREE);
				$form.find('[name="ID_MACHINE"]').val(result.ID_MACHINE);
				$form.find('[name="NAMA_MACHINE"]').val(result.NAMA_MACHINE);
				$form.find('[name="PANJANG"]').val(result.PANJANG);
				$form.find('[name="LEBAR"]').val(result.LEBAR);
				$form.find('[name="KAPASITAS"]').val(result.KAPASITAS);
				$form.find('[name="SATUAN_KAPASITAS"]').val(result.SATUAN_KAPASITAS);
				$form.find('[name="MERK"]').val(result.MERK);
				$form.find('[name="MODEL"]').val(result.MODEL);
				$form.find('[name="NOMORSERI"]').val(result.NOMORSERI);
				$form.find('[name="TAHUNPENGADAAN"]').val(result.TAHUNPENGADAAN);
				$form.find('[name="PICTURE"]').val(result.PICTURE);
				$form.find('[name="REMARKS"]').val(result.REMARKS);
				
				var id = 'id_' + Math.random();
				$checkbox = $form.find('[type="checkbox"]').attr('id', id);
				$checkbox.siblings('label').attr('for', id);
		
				$aktif = $form.find('[name="AKTIF"]');
				if (result.AKTIF == 1) {
					$aktif.attr('checked', 'checked');
				} else {
					$aktif.removeAttr('checked');
				}
				
				$use_icon = $form.find('[name="use_icon"]');
				$icon = $form.find('[name="icon_class"]');
				// console.log(result);
				if (result.CLASS != null && $.trim(result.CLASS) != '' && result.CLASS != 'null') {
					$use_icon.val(1);
					$icon.val(result.CLASS);
					$form.find('.icon-preview').find('i').removeAttr('class').addClass(result.CLASS);
				} else {
					$use_icon.val(0);
					$icon.val('');
					$form.find('.icon-preview').hide();
				}
				
				$bootbox.find('.modal-body').empty().append($form);
			})
		},
		beforeRemove: function(item, plugin) {
			var $bootbox = bootbox.confirm({
				message: "Yakin akan menghapus tree? <br/>Semua subtree (jika ada) akan ikut terhapus",
				buttons: {
					confirm: {
						label: 'Yes',
						className: 'btn-success submit'
					},
					cancel: {
						label: 'No',
						className: 'btn-danger'
					}
				},
				callback: function(result) {
					if(result) {
						$button = $bootbox.find('button').prop('disabled', true);
						$button_submit = $bootbox.find('button.submit');
						$button_submit.prepend('<i class="fas fa-circle-notch fa-spin mr-2 fa-lg"></i>');
						url_delete = $('#url-delete').text();
						$.ajax({
							type: 'POST',
							url: url_delete,
							data: 'id=' + item.attr('data-id'),
							success: function(msg) {
								msg = $.parseJSON(msg);
								if (msg.status == 'ok') {
									Swal.fire({
										text: msg.message,
										title: 'Sukses !!!',
										type: 'success',
										showCloseButton: true,
										confirmButtonText: 'OK'
									})
									plugin.deleteList(item);
								} else {
									Swal.fire({
										title: 'Error !!!',
										text: msg.message,
										type: 'error',
										showCloseButton: true,
										confirmButtonText: 'OK'
									})
								}
							},
							error: function() {
								
							}
						})
					}
				}
				
			});
		} 
		// tambahan Eko
		,viewDetailBtnCall : function($list) 
		{
			var $button = '';
			var	$bootbox = showDetail();
			
			var $button = $bootbox.find('button').prop('disabled', true);
			var $loader = $bootbox.find('.loader');
			var url_detail = $('#url-detail').text();

			$.getJSON(url_detail + $list.data('id'), function(result) 
			{
				$loader.remove();
				$button.prop('disabled', false);
				
				var $form = $('#add-form').clone().show();
				$form.find('[name="id"]').val(result.ID_TREE);
				$form.find('[name="ID_MACHINE"]').val(result.ID_MACHINE);
				$form.find('[name="ID_MACHINE"]').attr("readonly",true);
				$form.find('[name="NAMA_MACHINE"]').val(result.NAMA_MACHINE);
				$form.find('[name="NAMA_MACHINE"]').attr("readonly",true);
				$form.find('[name="PANJANG"]').val(result.PANJANG);
				$form.find('[name="PANJANG"]').attr("readonly",true);
				$form.find('[name="LEBAR"]').val(result.LEBAR);
				$form.find('[name="LEBAR"]').attr("readonly",true);
				$form.find('[name="KAPASITAS"]').val(result.KAPASITAS);
				$form.find('[name="KAPASITAS"]').attr("readonly",true);
				$form.find('[name="SATUAN_KAPASITAS"]').val(result.SATUAN_KAPASITAS);
				$form.find('[name="SATUAN_KAPASITAS"]').attr("readonly",true);
				$form.find('[name="MERK"]').val(result.MERK);
				$form.find('[name="MERK"]').attr("readonly",true);
				$form.find('[name="MODEL"]').val(result.MODEL);
				$form.find('[name="MODEL"]').attr("readonly",true);
				$form.find('[name="NOMORSERI"]').val(result.NOMORSERI);
				$form.find('[name="NOMORSERI"]').attr("readonly",true);
				$form.find('[name="TAHUNPENGADAAN"]').val(result.TAHUNPENGADAAN);
				$form.find('[name="TAHUNPENGADAAN"]').attr("readonly",true);
				$form.find('[name="PICTURE"]').val(result.PICTURE);
				$form.find('[name="PICTURE"]').attr("readonly",true);
				$form.find('[name="REMARKS"]').val(result.REMARKS);
				$form.find('[name="REMARKS"]').attr("readonly",true);
				
				var id = 'id_' + Math.random();
				$checkbox = $form.find('[type="checkbox"]').attr('id', id);
				$checkbox.siblings('label').attr('for', id);
		
				$aktif = $form.find('[name="AKTIF"]');
				if (result.AKTIF == 1) {
					$aktif.attr('checked', 'checked');
				} else {
					$aktif.removeAttr('checked');
				}
				
				$use_icon = $form.find('[name="use_icon"]');
				$icon = $form.find('[name="icon_class"]');
				// console.log(result);
				if (result.CLASS != null && $.trim(result.CLASS) != '' && result.CLASS != 'null') {
					$use_icon.val(1);
					$icon.val(result.CLASS);
					$form.find('.icon-preview').find('i').removeAttr('class').addClass(result.CLASS);
				} else {
					$use_icon.val(0);
					$icon.val('');
					$form.find('.icon-preview').hide();
				}
				
				$bootbox.find('.modal-body').empty().append($form);
			})
		}
		//batas tambahan Eko
	});
	
	$('#save-tree').submit(function(e) 
	{
		list_data = $('#list-tree').wdiMenuEditor('serialize');
		data = JSON.stringify(list_data);
		$('#tree-data').empty().text(data);
	})
	
	$(document).on('change', 'select[name="use_icon"]', function(){
		$this = $(this);
		if (this.value == 1) 
		{
			$icon_preview = $this.next().show();
			$this.next().show();
			var calass_name = $icon_preview.find('i').attr('class');
			$this.parent().find('[name="icon_class"]').val(calass_name);
		} else {
			$this.next().hide();
		}
	});
	
	$('#add-tree').click(function(e) 
	{
		e.preventDefault();
		var $add_form = $('#form-edit').clone();
		var id = 'id_' + Math.random();
		$checkbox = $add_form.find('[type="checkbox"]').attr('id', id);
		$checkbox.siblings('label').attr('for', id);
		$bootbox = showForm('add');
	});

// tambahan Eko
	function showDetail(type='viewdetail') 
	{
		var $button = '';
		var $bootbox = '';
		var $button_submit = '';			
		var msg = '<div class="loader-ring loader"></div>';

		$bootbox =  bootbox.dialog({
			title: 'Detail',
			message: msg,
			buttons: {
				cancel: {
					label: 'OK'
				},
			}
		});
	
		return $bootbox;
	}
// batas tambahan Eko
	
	function showForm(type='add') 
	{
		var $button = '';
		var $bootbox = '';
		var $button_submit = '';
			
		var $form = $('#add-form').clone().show();
		var id = 'id_' + Math.random();
		$checkbox = $form.find('[type="checkbox"]').attr('id', id);
		$checkbox.siblings('label').attr('for', id);
// console.log($form[0].outerHTML);
		if (type == 'edit') {
			var msg = '<div class="loader-ring loader"></div>';
		} else {
			var msg = '<div class="form-container">' +  $form[0].outerHTML + '</div>';
		}
		
		$bootbox =  bootbox.dialog({
			title: type == 'edit' ? 'Edit Tree' : 'Tambah Tree',
			message: msg,
			buttons: {
				cancel: {
					label: 'Cancel'
				},
				success: {
					label: 'Submit',
					className: 'btn-success submit',
					callback: function() 
					{
						$bootbox.find('.alert').remove();
						$button_submit.prepend('<i class="fas fa-circle-notch fa-spin mr-2 fa-lg"></i>');
						$button.prop('disabled', true);
						$form_filled = $bootbox.find('form');
						url_edit = $('#url-edit').text();
						url_paging = $('#url-paging').text();
						$.ajax({
							type: 'POST',
							url: url_edit,
							data: $form_filled.serialize(),
							dataType: 'text',
							success: function (data) {
								// console.log(data);
								data = $.parseJSON(data);
								
								if (data.status == 'ok') 
								{
									var id = $form_filled.find('input[name="id"]').val();
									var ID_MACHINE = $form_filled.find('input[name="ID_MACHINE"]').val();
									var NAMA_MACHINE = $form_filled.find('input[name="NAMA_MACHINE"]').val();
									var PANJANG = $form_filled.find('input[name="PANJANG"]').val();
									var LEBAR = $form_filled.find('input[name="LEBAR"]').val();
									var KAPASITAS = $form_filled.find('input[name="KAPASITAS"]').val();
									var SATUAN_KAPASITAS = $form_filled.find('input[name="SATUAN_KAPASITAS"]').val();
									var MERK = $form_filled.find('input[name="MERK"]').val();
									var MODEL = $form_filled.find('input[name="MODEL"]').val();
									var NOMORSERI = $form_filled.find('input[name="NOMORSERI"]').val();
									var TAHUNPENGADAAN = $form_filled.find('input[name="TAHUNPENGADAAN"]').val();
									var PICTURE = $form_filled.find('input[name="PICTURE"]').val();
									var REMARKS = $form_filled.find('input[name="REMARKS"]').val();
									var AKTIF = $form_filled.find('input[name="AKTIF"]').val();
									var use_icon = $form_filled.find('select[name="use_icon"]').val();
									var icon_class = $form_filled.find('input[name="icon_class"]').val();
									// edit
									if (id) {
										$tree = $('#list-tree').find('[data-id="'+id+'"]');
										$tree.find('.tree-title:eq(0)').text(NAMA_MACHINE);
									} 
									// add
									else {
										$tree_container = $('#list-tree').children();
										$tree = $tree_container.children(':eq(0)').clone();
										$tree.find('ol, ul').remove();
										$tree.find('[data-action="collapse"]').remove();
										$tree.find('[data-action="expand"]').remove();
										$tree.attr('data-id', data.ID_TREE);
										$tree.find('.tree-title').text(NAMA_MACHINE);
									}
									
									$handler = $tree.find('.dd-handle:eq(0)');
									$handler.find('i').remove();
									
									if (use_icon == 1) {
										$handler.prepend('<i class="'+icon_class+'"></i>');
									}
									
									if (!id) {
										$tree_container.prepend($tree);
									}
										
									$bootbox.modal('hide');
									// bootbox.alert(data.message);
									Swal.fire({
										title: 'Sukses !!!',
										text: data.message,
										type: 'success',
										showCloseButton: true,
										confirmButtonText: 'OK'
									})
									// .then ==> tambahan untuk ngantisipasi bugs after save tambah
									.then((result) => {
										  // Reload the Page
										  window.location.href=url_paging;
										})
								} else {
									$button_submit.find('i').remove();
									$button.prop('disabled', false);
									if (data.error_query != undefined) {
										Swal.fire({
											title: 'Error !!!',
											html: data.message,
											type: 'error',
											showCloseButton: true,
											confirmButtonText: 'OK'
										})
									} else {
										$bootbox.find('.modal-body').prepend('<div class="alert alert-dismissible alert-danger" role="alert">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
									}
								}
							},
							error: function (xhr) {
								console.log(xhr.responseText);
							}
						})
						return false;
					}
				}
			}
		});
		
		$button = $bootbox.find('button').prop('disabled', false);
		$button_submit = $bootbox.find('button.submit');
		
		if (type == 'edit') {
			$button.prop('disabled', true);
		}
		
		return $bootbox;
	}
	
	$(document).on('click', '.icon-preview', function() {

		$this = $(this);
		fapicker({
			iconUrl: base_url + 'public/vendors/font-awesome/metadata/icons.yml',
			onSelect: function (elm) {
				
				var icon_class = $(elm).data('icon');
				$this.find('i').removeAttr('class').addClass(icon_class);
				$this.parent().find('[name="icon_class"]').val(icon_class);
			}
		});
	});
});