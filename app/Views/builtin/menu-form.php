<?php 
helper('html');?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title">Data Menu</h5>
	</div>
	
	<div class="card-body">
		<a href="<?=$module_url?>" class="btn btn-success btn-xs" id="add-menu"><i class="fa fa-plus pr-1"></i> Tambah Menu</a>
		<!-- tambahan tanggal 25 nov 2022 -->
		<a class="btn btn-danger btn-xs" id="collapseAllButton"><i class="fa fa-chevron-up pr-1"></i> Collapse All</a>
		<a class="btn btn-warning btn-xs" id="expandAllButton"><i class="fas fa-chevron-down pr-1"></i> Expand All</a>
		<!-- batas tambahan tanggal 25 nov 2022 -->
		<hr/>
		<form style="display:none" method="post" class="modal-form" id="add-form" action="<?=current_url()?>" >
			<div>
<!-- dimatikan karena menggunakan seq pada DB -->
<!-- 				<div class="form-group row">
					<label class="col-sm-3 col-form-label">ID Menu</label>
					<div class="col-sm-8">
						<input class="form-control" type="number" name="id_menu" value="" placeholder="ID Menu" required="required"/>
					</div>
				</div> -->
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Nama Menu</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="nama_menu" value="" placeholder="Nama Menu" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">URL</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="url" value="" placeholder="URL" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Aktif</label>
					<div class="col-sm-8">
						<div class="mt-2">
						<input id="menu_aktif" type="checkbox" name="aktif" class="switch is-info is-medium" checked="checked">
						 <label for="menu_aktif"></label>
						</div>
						<small class="form-text text-muted"><em>Jika tidak aktif, semua children tidak akan dimunculkan</em></small>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Module</label>
					<div class="col-sm-8 form-inline">
						<?php
						$options[0] = 'Tidak ada module'; 
						foreach ($list_module as $key => $val) {
							$options[$val['ID_MODULE']] = $val['NAMA_MODULE'] . ' | ' . $val['JUDUL_MODULE'] . ' (' . $val['NAMA_STATUS']  . ')';
						}
						echo options(['name' => 'id_module', 'id' => 'id-module'], $options);
						
						echo '<small class="form-text text-muted"><em>Untuk highlight menu dan parent</em></small>';
						?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Use icon</label>
					<div class="col-sm-8 form-inline">
						<input type="hidden" name="icon_class" value="far fa-circle"/>
						<?php 
							$options = array(1 => 'Ya', 0 => 'Tidak');
							echo options(['name' => 'use_icon'], $options);
						?>
						<a href="javascript:void(0)" class="icon-preview" data-action="faPicker"><i class="far fa-circle"></i></a>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Role</label>
					<div class="col-sm-8 form-inline">
						Untuk memunculkan menu, assign role ke menu
						<?php
				
						/* foreach ($role as $val) {
							$list_role[] = ['name' => 'id_role[]'
											, 'id' => 'id_role_' . $val['id_role']
											, 'label' => $val['judul_role']
											, 'parent_class' => 'mr-2'
										];
							
						}
						checkbox($list_role); */
			
						?>
					</div>
				</div>
				<input type="hidden" name="id" value="<?=@$_GET['id']?>"/>
				
			</div>
		</form>
		<?php

		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		?>
		
		<!-- file js class ada di public/themes/moders/js/admin-menu.js -->
		<div class="dd" id="list-menu">
			<?=$list_menu?>
		</div>
		<form method="POST" action="?module=menu" id="save-menu">
			<textarea class="hidden" id="menu-data" name="data" style="display:none"></textarea>
			<button type="submit" name="submit" value="submit" class="btn btn-primary mt-2">Save</button>
		</form>
		
		<span style="display:none" id="url-delete"><?=$config->baseURL . 'builtin/menu/delete'?></span>
		<span style="display:none" id="url-edit"><?=$config->baseURL . 'builtin/menu/edit'?></span>
		<span style="display:none" id="url-detail"><?=$config->baseURL . 'builtin/menu/menuDetail?ajax=true&id='?></span>

		<!--tambahan  span  id="url-paging" tambahan untuk dipake buat reload after save-->
		<span style="display:none" id="url-paging"><?php 
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		echo $actual_link; 
		?></span>
	</div>
</div>
