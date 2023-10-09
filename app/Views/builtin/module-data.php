<div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Module</h5>
	</div>
	
	<div class="card-body">
		<?php
		
		helper ('html');
			echo btn_label(['class' => 'btn btn-success btn-xs',
				'url' => current_url() . '/add',
				'icon' => 'fa fa-plus',
				'label' => 'Tambah Module'
			]);
			
			echo btn_label(['class' => 'btn btn-light btn-xs',
				'url' => current_url(),
				'icon' => 'fa fa-arrow-circle-left',
				'label' => 'Daftar Module'
			]);
		?>
		<hr/>
		<?php 
		if (!$result) {
			show_message('Data tidak ditemukan', '', false);
		} else {
			if (!empty($msg)) {
				show_alert($msg);
			}
			?>
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover data-tables">
			<thead>
			<tr>
				<th>ID</th>
				<th>Nama Module</th>
				<th>Judul Module</th>
				<th>Deskripsi</th>
				<th>File Module</th>
				<th>Aktif</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;

			foreach ($result as $key => $val) {
				if ($val['ID_MODULE_STATUS'] == 1) {
					//$id_module_status = 0;
					$checked = 'checked';
					$btn_class = 'btn-danger';
					$btn_text = 'Non Aktifkan';
				} elseif ($val['ID_MODULE_STATUS'] != 1) {
					//$id_module_status = 1;
					$checked = '';
					$btn_class = 'btn-success';
					$btn_text = 'Aktifkan';
				}
				
				$checked_login = $val['LOGIN'] == 1 ? 'checked' : '';
				
				$disabled = $current_module['NAMA_MODULE'] == $val['NAMA_MODULE'] ? ' disabled' : '';
				
				$file_exists = in_array( str_replace('-', '_', $val['NAMA_MODULE']) . '.php', $file_module) ? 'Ada' : 'Tidak Ada';
				echo '<tr>
						<td>' . $val['ID_MODULE'] . '</td>
						<td>' . $val['NAMA_MODULE'] . '</td>
						<td>' . $val['JUDUL_MODULE'] . '</td>
						<td>' . $val['DESKRIPSI'] . '</td>
						<td>' . $file_exists . '</td>
						<td>
							<input data-switch="aktif" id="switch-'.$val['ID_MODULE'].'" type="checkbox" data-module-id="'.$val['ID_MODULE'].'" name="aktif" class="switch is-rounded is-info is-small" '.$checked. $disabled .'>
							<label for="switch-'.$val['ID_MODULE'].'"></label>
						</td>
						<td>
							<div class="btn-action-group">
								<a href="' . current_url() . '/edit?id=' . $val['ID_MODULE'] .'" class="btn btn-success btn-xs mr-1"><i class="fa fa-edit"></i>&nbsp;Edit</a>
								<form method="post" action="'.current_url().'">
									<button data-action="delete-data" data-delete-title="Hapus Module '.$val['ID_MODULE'].' - '.$val['NAMA_MODULE'].'?" type="submit" class="btn btn-danger btn-xs" name="delete"><i class="fas fa-times"></i>&nbsp;Delete</button>
									<input type="hidden" name="id" value="'.$val['ID_MODULE'].'"/><input type="hidden" name="delete" value="delete"/>
								</form>
							</div>
						</td>
					</tr>';
				$no++;
			}
			?>
			</tbody>
			</table>
			<?php 
		} ?>
		
	</div>
</div>