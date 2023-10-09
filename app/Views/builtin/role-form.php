<?php

helper('html');
?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	 
	<div class="card-body">
		<a href="<?=$module_url?>/add" class="btn btn-success btn-xs" id="add-menu"><i class="fa fa-plus pr-1"></i> Tambah Role</a>
		<a href="<?=$module_url?>" class="btn btn-light btn-xs" id="add-menu"><i class="fa fa-arrow-circle-left pr-1"></i> Daftar Role</a>
		<hr/>
		<?php
		if (!empty($msg)) {
			show_message($msg);
		}
		
		foreach($module_status as $val) {
			$module_status_list[$val['ID_MODULE_STATUS']] = $val['NAMA_STATUS'];
		}
		
		foreach ($module_role as $key => $val) {
			$module_allowed[$val['ID_ROLE']][$val['ID_MODULE']] = $val['NAMA_MODULE'] . ' | ' . $val['JUDUL_MODULE'] . ' (' . $module_status_list[$val['ID_MODULE_STATUS']] . ')';
		}
		
		// echo '<pre>'; print_r($module_allowed); die;
		$disabled = $request->getGet('id') ? 'readonly="readonly"' : '';
		$kondisiID = $request->getGet('id') ? 'editRole' : 'addRole';
		?>
		<form method="post" action="<?=current_url(true)?>" >
			<div>
				<?php if($kondisiID == 'editRole'){ ?>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">ID Role</label>
					<div class="col-sm-8">
						<input class="form-control" type="number" name="ID_ROLE" value="<?=set_value('ID_ROLE', @$role['ID_ROLE'] ?: '')?>" placeholder="ID Role" <?=$disabled?> required="required"/>
					</div>
				</div>
				<?php } ?>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama Role</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="NAMA_ROLE" value="<?=set_value('NAMA_ROLE', @$role['NAMA_ROLE'] ?: '')?>" placeholder="Nama Role" <?=$disabled?> required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Judul Role</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="JUDUL_ROLE" value="<?=set_value('JUDUL_ROLE', @$role['JUDUL_ROLE'] ?: '')?>" placeholder="Judul Role" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Keterangan</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="KETERANGAN" value="<?=set_value('KETERANGAN', @$role['KETERANGAN'] ?: '')?>" placeholder="Keterangan"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Halaman Default</label>
					<div class="col-sm-8">
						<?php
						if (key_exists(@$role['ID_ROLE'], $module_allowed)) {
							// diganti eko 15 jun 2022
							// echo options(['name=ID_MODULE'], $module_allowed[$role['ID_ROLE']], $role['ID_MODULE']);
							echo options(array("name"=>"ID_MODULE"), $module_allowed[$role['ID_ROLE']], $role['ID_MODULE']);
						} else {
							echo '<span class="text-danger">Tidak ada module yang di assing ke role ini, silakan <a href="'.$config->baseURL.'builtin/module-role" target="_blank">assign</a> terlebih dahulu</span>';
						}
						?>
						<p class="mt-0"><em>Halaman awal sesaat setelah user login</p>
					</div>
				</div>
				<div class="form-group row">
					<?php 
					$id = '';
					if (!empty($msg['ID_ROLE'])) {
						$id = $msg['ID_ROLE'];
					} 
					elseif ($request->getPost('id')) {
						$id = $request->getPost('id');
					}
					elseif ($request->getGet('id')) {
						$id = $request->getGet('id');
					} ?>
					<input type="hidden" name="id" value="<?=$id?>"/>
					<div class="col-sm-8 offset-sm-2">
						<button type="submit" name="submit" value="submit" class="btn btn-primary mt-2">Save</button>
						<?=$auth->createFormToken('form_role')?>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>