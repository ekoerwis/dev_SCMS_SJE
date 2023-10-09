<div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Module Role</h5>
	</div>
	
	<div class="card-body">
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
				<th>Role</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;

			foreach ($module as $key => $val) 
			{
				
				$list = '';
				if (key_exists($val['ID_MODULE'], $all_module_role)) {
					$roles = $all_module_role[$val['ID_MODULE']];
					foreach ($roles as $role_id) 
					{
						
						$list .= '<span class="badge badge-secondary badge-role px-3 py-2 mr-1 mb-1 pr-4">' . $role[$role_id]['JUDUL_ROLE'] . '<a data-action="remove-role" data-pair-id="'.$val['ID_MODULE'].'" data-role-id="'.$role_id.'" href="javascript:void(0)" class="text-danger"><i class="fas fa-times"></i></a></span>';
					}
				}
				echo '<tr>
						<td>' . $val['ID_MODULE'] . '</td>
						<td>' . $val['NAMA_MODULE'] . '</td>
						<td>' . $val['JUDUL_MODULE'] . '</td>
						<td>' . $list . '</td>
						<td>
							<div class="btn-action-group">
								<a data-pair-id="'.$val['ID_MODULE'].'" href="' . $config->baseURL . 'builtin/module-role/edit?id=' . $val['ID_MODULE'] .'" class="btn btn-success btn-xs mr-1 role-edit"><i class="fa fa-edit pr-1"></i> Edit</a>
								<a href="' . $config->baseURL . 'builtin/module-role/detail?id=' . $val['ID_MODULE'] .'" class="btn btn-primary btn-xs mr-1"><i class="fa fa-edit"></i>&nbsp;Detail</a>
							</div>
						</td>
					</tr>';
				$no++;
			}
			?>
			</tbody>
			</table>
			</div>
			<?php 
		} ?>
		
	</div>
</div>