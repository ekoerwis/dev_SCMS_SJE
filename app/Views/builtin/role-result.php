<!-- <?php
//dd($module_role);
?> -->

<div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Role</h5>
	</div>
	
	<div class="card-body">
		<a href="<?=current_url()?>/add" class="btn btn-success btn-xs"><i class="fa fa-plus pr-1"></i> Tambah Role</a>
		<hr/>
		<?php 
		if (!$result) {
			show_message('Data tidak ditemukan', '', false);
		} else {
			if (!empty($msg)) {
				show_alert($msg);
			}
			
			/* foreach($module_role as $val) {
				$module_role_list[$val['
			} */
			
			foreach($module as $val) {
				$module_list[$val['ID_MODULE']] = $val;
			}
			foreach($module_status as $val) {
				$module_status_list[$val['ID_MODULE_STATUS']] = $val['NAMA_STATUS'];
			}

			?>
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover data-tables">
			<thead>
			<tr>
				<th>No</th>
				<th>Nama Role</th>
				<th>Judul Role</th>
				<th>Default Module</th>
				<th>Keterangan</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php

			

			//Dibawah ini Dimatikan dan digantikan menampilkan dengan variabel resultNew karena masih ada bugs bahwa yang baru di tambah ga bisa kelihatan KARENA DATA ALLOWED2 ITU, QUERY HARUS DI UBAH (14 APR 2023) KARENA SEKARANG YANG PENTING GA ERROR DAHULU dan penambahan role sudah tidak menggunakan seq database

			// foreach ($module_role as $key => $val) {
			// 	$module_allowed[$val['ID_ROLE']][$val['ID_MODULE']] = $val['NAMA_MODULE'] . ' | ' . $val['JUDUL_MODULE'] . ' (' . $module_status_list[$val['ID_MODULE_STATUS']] . ')';
			// }

			// foreach ($result as $key => $val) {
			// 	if (key_exists($val['ID_ROLE'], $module_allowed)) {
			// 		$module_assign = $module_list[$val['ID_MODULE']]['NAMA_MODULE'] . ' | ' . $module_list[$val['ID_MODULE']]['JUDUL_MODULE'] . ' (' . $module_status_list[$module_list[$val['ID_MODULE']]['ID_MODULE_STATUS']] . ')';
			// 	} else {
			// 		$module_assign = '';
			// 	}
			// 	echo '<tr>
			// 			<td>' . ($key + 1) . '</td>
			// 			<td>' . $val['NAMA_ROLE'] . '</td>
			// 			<td>' . $val['JUDUL_ROLE'] . '</td>
			// 			<td>' . $module_assign;
						
			// 			if (key_exists($val['ID_ROLE'], $module_allowed)) {
			// 				if (!key_exists($val['ID_MODULE'], $module_allowed[$val['ID_ROLE']])) {
			// 					echo '<p class="mt-0 mb-0">
			// 								<span class="text-danger">Module <strong>' . $module_list[$val['ID_MODULE']]['NAMA_MODULE'] . '</strong> belum di assing ke role ini, silakan <a href="'. $config->baseURL .'builtin/module-role" target="_blank">assign</a> terlebih dahulu</span>
			// 						</p>';
			// 				}
			// 			} else {
			// 				echo '<p class="mt-0 mb-0">
			// 						<span class="text-danger">Tidak ada module yang di assing ke role ini, silakan <a href="'.$config->baseURL.'builtin/module-role" target="_blank">assign</a> terlebih dahulu</span>
			// 					</p>';
			// 			}
						
			// 	echo '</td>
			// 			<td>' . $val['KETERANGAN'] . '</td>
			// 			<td>
			// 				<div class="btn-action-group">
			// 				<a target="_self" href="'.current_url().'/edit?id='. $val['ID_ROLE'] .'" class="btn btn-success btn-xs mr-1"><i class="fa fa-edit"></i>&nbsp;Edit</a>
			// 				<form method="post" action="'.current_url().'"><button data-action="delete-data" data-delete-title="Hapus Role: <strong>'.$val['JUDUL_ROLE'].'</strong>?" type="submit" class="btn btn-danger btn-xs" name="delete"><i class="fas fa-times"></i>&nbsp;Delete</button><input type="hidden" name="id" value="'.$val['ID_ROLE'].'"/><input type="hidden" name="delete" value="delete"/></form>
			// 				</div>
			// 			</td>
			// 		</tr>';
			// }


			foreach ($resultNew as $key => $val) {
				echo '<tr>
						<td>' . ($key + 1) . '</td>
						<td>' . $val['NAMA_ROLE'] . '</td>
						<td>' . $val['JUDUL_ROLE'] . '</td>
						<td>' . $val['NAMA_MODULE'] . '</td>
						<td>' . $val['KETERANGAN'] . '</td>
						<td>
							<div class="btn-action-group">
							<a target="_self" href="'.current_url().'/edit?id='. $val['ID_ROLE'] .'" class="btn btn-success btn-xs mr-1"><i class="fa fa-edit"></i>&nbsp;Edit</a>
							<form method="post" action="'.current_url().'"><button data-action="delete-data" data-delete-title="Hapus Role: <strong>'.$val['JUDUL_ROLE'].'</strong>?" type="submit" class="btn btn-danger btn-xs" name="delete"><i class="fas fa-times"></i>&nbsp;Delete</button><input type="hidden" name="id" value="'.$val['ID_ROLE'].'"/><input type="hidden" name="delete" value="delete"/></form>
							</div>
						</td>
					</tr>';
			}
			?>
			</tbody>
			</table>
			</div>
			<?php 
		} ?>
		
	</div>
</div>