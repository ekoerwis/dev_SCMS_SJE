<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php 
			helper ('html');
			echo btn_label(['class' => 'btn btn-success btn-xs',
				'url' => $module_url . '/add',
				'icon' => 'fa fa-plus',
				'label' => 'Tambah User'
			]);
			
			echo btn_label(['class' => 'btn btn-light btn-xs',
				'url' => $module_url,
				'icon' => 'fa fa-arrow-circle-left',
				'label' => 'Daftar User'
			]);

			if($stat_EPMS){
				echo btn_label(['class' => 'btn btn-info btn-xs',
					'url' => site_url() . '/../Builtin/UserImportEPMS',
					'icon' => 'fas fa-compress-alt',
					'label' => 'Import User Dari EPMS'
				]);
			}
		?> 
		<hr/>
		<?php
		if (!empty($msg)) {
			show_message($msg);
		}
		?>
		<form method="post" action="" class="form-horizontal">
			<div class="tab-content" id="myTabContent">
				<!-- dimatikan karena id diperlakukan menggunakan sequence -->
				<!-- <div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">ID User</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="number" name="ID_USER"  placeholder="id user" required="required"/>
					</div>
				</div> -->
				<!-- batas dimatikan karena id diperlakukan menggunakan sequence -->
				
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Username</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="USERNAME" value="<?=set_value('USERNAME', @$USERNAME)?>" placeholder="Username" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="NAMA" value="<?=set_value('NAMA', @$NAMA)?>" placeholder="Nama" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Email</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="EMAIL" value="<?=set_value('EMAIL', @$EMAIL)?>" placeholder="Email" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Role</label>
					<div class="col-sm-8 form-inline">
						<?php
						foreach ($role as $key => $val) {
							$options[$val['ID_ROLE']] = $val['JUDUL_ROLE'];
						}
						echo options(['name' => 'ID_ROLE'], $options, set_value('ID_ROLE', @$ID_ROLE));
						?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Password Baru</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="password" name="PASSWORD" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Ulangi Password Baru</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="password" name="ULANGI_PASSWORD" required="required"/>
					</div>
				</div>
				<div class="form-group row mb-0">
					<div class="col-sm-8">
						<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
						<input type="hidden" name="id" value="<?=@$_GET['id']?>"/>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>