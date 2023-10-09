<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php
		helper ('html');
		echo btn_label(['class' => 'btn btn-success btn-xs',
			'url' => $config->baseURL . 'builtin/module/add',
			'icon' => 'fa fa-plus',
			'label' => 'Tambah Module'
		]);
		
		echo btn_label(['class' => 'btn btn-light btn-xs',
			'url' => $config->baseURL . 'builtin/module',
			'icon' => 'fa fa-arrow-circle-left',
			'label' => 'Daftar Module'
		]);
		?>
		<hr/>
		<?php
		if (!empty($msg)) {
			// echo '<pre>'; print_r($msg); die;
			show_alert($msg);
		}
		
		if (empty($NAMA_MODULE)) {
			$fields = ['NAMA_MODULE', 'JUDUL_MODULE', 'DESKRIPSI', 'ID_MODULE_STATUS'];
			foreach ($fields as $val) {
				$$val = '';
			}
		}
		?>
		<form method="post" class="modal-form" id="add-form" action="" >
			<div>
<!-- dimatikan karena menggunakan seq pada DB				 -->
<!-- 				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">ID Module</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="number" name="id_module" value="<?php //set_value('id_module', @$id_module)?>" placeholder="ID Module" required/> <em>Harus Unik</em>
						<input type="hidden" name="id_module_old" value="<?php //set_value('id_module', @$id_module)?>">
					</div>
				</div> -->
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama Module</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="NAMA_MODULE" value="<?=set_value('NAMA_MODULE', @$NAMA_MODULE)?>" placeholder="Nama Module" required/> <em>Sesuai nama yang ada di URL</em>
						<input type="hidden" name="NAMA_MODULE_OLD" value="<?=set_value('NAMA_MODULE', @$NAMA_MODULE)?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Judul Module</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="JUDUL_MODULE" value="<?=set_value('JUDUL_MODULE', @$JUDUL_MODULE)?>" placeholder="Judul Module" required/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Deskripsi</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="DESKRIPSI" value="<?=set_value('DESKRIPSI', @$DESKRIPSI)?>" placeholder="Deskripsi"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Status</label>
					<div class="col-sm-8 form-inline">
						<?php 
						foreach ($module_status as $item) {
							$options[$item['ID_MODULE_STATUS']] = $item['NAMA_STATUS'];
						}
						echo options(['name' => 'ID_MODULE_STATUS'], $options, ['ID_MODULE_STATUS', @$ID_MODULE_STATUS])?>
					</div>
				</div>
				
				<?php 
				$id = '';
				if (!empty($_GET['id'])) {
					$id = $_GET['id'];
				} elseif (!empty($msg['module_id'])) { // ADD Auto Increment
					$id = $msg['module_id'];
				} ?>
				<input type="hidden" name="id" value="<?=$id?>"/>
				<button type="submit" name="submit" value="submit" class="btn btn-primary mt-2">Save</button>
			</div>
		</form>
	</div>
</div>