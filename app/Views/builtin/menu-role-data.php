<div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Menu Role</h5>
	</div>
	
	<div class="card-body">
		<?php 
		if (!$data_menu) {
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
				<th>Menu</th>
				<th>URL</th>
				<th>Role</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
		
			foreach ($data_menu as $key => $val) 
			{
				
				$list = '';
				if (key_exists($val['ID_MENU'], $menu_role)) {
					$roles = $menu_role[$val['ID_MENU']];
					foreach ($roles as $id_role) 
					{
						$list .= '<span class="badge badge-secondary badge-role px-3 py-2 mr-1 mb-1 pr-4">' . $role[$id_role]['JUDUL_ROLE'] . '<a data-action="remove-role" data-id-menu="'.$val['ID_MENU'].'" data-role-id="'.$id_role.'" href="javascript:void(0)" class="text-danger"><i class="fas fa-times"></i></a></span>';
					}
				}
				echo '<tr>
						<td>' . $val['ID_MENU'] . '</td>
						<td>' . $val['NAMA_MENU'] . '</td>
						<td>' . $val['URL'] . '</td>
						<td>' . $list . '</td>
						<td>
							<div class="btn-action-group">
							<a data-id-menu="'.$val['ID_MENU'].'" href="' . $config->baseURL . 'builtin/menu-role/edit?id=' . $val['ID_MENU'] .'" class="btn btn-success btn-xs mr-1 role-edit"><i class="fa fa-edit"></i>&nbsp;Edit</a>
							</div>
						</td>
					</tr>';
				$no++;
			}
			?>
			</tbody>
			</table>
			<span style="display:none" id="url-delete"><?=$config->baseURL . 'builtin/menu-role/delete'?></span>
			</div>
			<?php 
		} ?>
		
	</div>
</div>