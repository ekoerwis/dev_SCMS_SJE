<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php 
	
			helper('html');
			helper('builtin/util');
			echo btn_label(['class' => 'btn btn-success btn-xs',
				'url' => $module_url . '/add',
				'icon' => 'fa fa-plus',
				'label' => 'Tambah User'
			]);
			
			echo btn_label(['class' => 'btn btn-light btn-xs',
				'url' => $module_url,
				'icon' => 'fa fa-arrow-circle-left',
				'label' => 'Daftar ' . $current_module['JUDUL_MODULE']
			]);

			echo btn_label(['class' => 'btn btn-warning btn-xs',
				'url' => $module_url . '/resetPassword?id='.$ID_USER,
				'icon' => 'fas fa-key',
				'label' => 'Reset Password ' . $ID_USER
			]);
		?>
		<hr/>
		<?php
		if (!empty($msg)) {
			show_message($msg);
		}
		?>
		<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
			<div class="tab-content">
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Foto</label>
					<div class="col-sm-5">
						<?php 
						$avatar = @$_FILES['file']['name'] ?: @$avatar;
						if (!empty($avatar))
						echo '<div class="list-foto" style="margin:inherit;margin-bottom:10px"><img src="'.$config->baseURL. '/public/images/user/' . $avatar . '"/></div>';
						
						?>
						<input type="file" class="file" name="AVATAR">
							<?php if (!empty($form_errors['avatar'])) echo '<small style="display:block" class="alert alert-danger mb-0">' . $form_errors['avatar'] . '</small>'?>
						<small class="small" style="display:block">Maksimal 300Kb, Minimal 100px x 100px, Tipe file: .JPG, .JPEG, .PNG</small>
						<div class="upload-img-thumb mb-2"><span class="img-prop"></span></div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Username</label>
					<div class="col-sm-8 col-md-6 col-lg-4">
						<input class="form-control" type="text" name="USERNAME" readonly="readonly" class="disabled" value="<?=set_value('USERNAME', $USERNAME)?>" placeholder="" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama</label>
					<div class="col-sm-8 col-md-6 col-lg-4">
						<input class="form-control" type="text" name="NAMA" value="<?=set_value('NAMA', $NAMA)?>" placeholder="" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Email</label>
					<div class="col-sm-8 col-md-6 col-lg-4">
						<input class="form-control" type="text" name="EMAIL" value="<?=set_value('EMAIL', $EMAIL)?>" placeholder="" required="required"/>
						<input type="hidden" name="EMAIL_LAMA" value="<?=set_value('EMAIL_LAMA', $EMAIL)?>" />
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Role</label>
					<div class="col-sm-8 col-md-6 col-lg-4">
						<?php
						foreach ($role as $key => $val) {
							$options[$val['ID_ROLE']] = $val['JUDUL_ROLE'];
						}
						echo options(['name' => 'ID_ROLE'], $options, set_value('ID_ROLE', $ID_ROLE));
						?>
					</div>
				</div>
				<div class="form-group row mb-0">
					<div class="col-sm-8">
						<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
						<input type="hidden" name="id" value="<?=$request->getGet('id')?>"/>

						<!-- tambahan eko -->
						<input type="hidden" name="ID_USER" value="<?=$request->getGet('id')?>"/>
						<input type="hidden" name="AKTIF" value="<?=set_value('AKTIF', $AKTIF)?>"/>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>