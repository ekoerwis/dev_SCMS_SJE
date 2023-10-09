<?php

helper('html');?>

<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php
		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		
		?>
		<form method="post" class="modal-form" id="add-form" action="<?=current_url(true)?>" >
			<div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Module</label>
					<div class="col-sm-8 form-inline">
						<?=$module['JUDUL_MODULE']?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Role</label>
					<div class="col-sm-8">
						
						<?php 
						foreach ($role_detail as $val) {
							$role_detail_options[$val['NAMA_ROLE_DETAIL']] = $val['NAMA_ROLE_DETAIL'] . ' | ' . $val['JUDUL_ROLE_DETAIL'];
						}
						
						$module_role_check = [];
						foreach ($module_role as $val) {
							$module_role_check[$val['ID_ROLE']] = $val;
						}
						
						echo '<div id="check-all-wrapper">';
						foreach ($role as $role_val) 
						{
							$checkbox = [['class' => 'toggle-role', 'id' => $role_val['ID_ROLE'], 'name' => 'role_' . $role_val['ID_ROLE'], 'label' => $role_val['JUDUL_ROLE']]];
							
							$checked = [];
							if (isset($_POST['role_' . $role_val['ID_ROLE']])) {
								$checked = ['role_' . $role_val['ID_ROLE']];
							} else {
								if (key_exists($role_val['ID_ROLE'], $module_role_check)) {
									$checked[] = 'role_' . $role_val['ID_ROLE'];
								}
							}
							// echo '<pre>';print_r($checked);
							checkbox($checkbox, $checked);
							$display = !$checked ? ' style="display:none"' : '';

							$action = ['READ_DATA' => 'Read', 'CREATE_DATA' => 'Create', 'UPDATE_DATA' => 'Update', 'DELETE_DATA' => 'Delete'];
							
							echo '<div class="ml-4 role-child" ' . $display . '>';
										foreach ($action as $key => $val_action) 
										{
											$selected = '';
											if (isset($_POST['role_' . $role_val['ID_ROLE']])) {
												$selected = $_POST['akses_' . $key . '_' . $role_val['ID_ROLE']];
											} else {
												if (key_exists($role_val['ID_ROLE'], $module_role_check)) {
													$selected = $module_role_check[$role_val['ID_ROLE']][$key];
												}
											}
										
											if ($key == 'CREATE_DATA') {
												$options = options(['name' => 'akses_' . $key . '_' . $role_val['ID_ROLE']], ['yes' => 'yes | YA', 'no' => 'no | TIDAK'], $selected, false);
											} else {
												$options = options(['name' => 'akses_' . $key . '_' . $role_val['ID_ROLE']], $role_detail_options, $selected, false);
											}
											echo '
											<div class="form-group row form-inline">
											<div class="col-sm-2">'.$val_action.'</div>
											<div class="col-sm-8 form-inline">' . $options . '</div>
											</div>';
										}
							echo '
								</div>';
						}
							
						
						
						
						echo '</div>';
						?>
						
					</div>
				</div>
				
				<?php 
				$id = '';
				if (!empty($msg['id_module'])) {
					$id = $msg['id_module']; // Setelah submit add
				} elseif (!empty($_GET['id'])) {
					$id = $_GET['id'];
				} ?>
				<input type="hidden" name="id" value="<?=$id?>"/>
				<button type="submit" name="submit" value="submit" class="btn btn-primary mt-2">Save</button>
				<?php
					$form_token = $auth->generateFormToken('form_edit');
				?>
				<input type="hidden" name="form_token" value="<?=$form_token?>"/>
			</div>
		</form>
	</div>
</div>