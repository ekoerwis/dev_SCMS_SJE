<?php
/**
*	App Name	: Admin Template Dashboard Codeigniter 4	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com 
*	Year		: 2020
*/

namespace App\Models\Builtin;

class MenuRoleModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
		// helper('stringSQLrep');
	}
	
	public function getAllMenu() {
		$sql = 'SELECT * FROM {prefix_portal}MENU';
		$sql=$this->ubahPrefix($sql);
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAllRole() {
		$sql = 'SELECT * FROM {prefix_portal}ROLE';
		$sql=$this->ubahPrefix($sql);
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAllMenuRole() {
		$sql = 'SELECT * FROM {prefix_portal}MENU_ROLE';
		$sql=$this->ubahPrefix($sql);
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getMenuRoleById($id) {
		$sql = 'SELECT * FROM {prefix_portal}menu_role WHERE id_menu = ?';
		$sql=$this->ubahPrefix($sql);
		$result = $this->db->query($sql, $id)->getResultArray();
		return $result;
	}
	
	public function deleteData() {

		$tablename='{prefix_portal}MENU_ROLE';
		$tablename=$this->ubahPrefix($tablename);

		$this->db->table($tablename)->delete(['ID_MENU' => $this->request->getPost('id_menu'), 'ID_ROLE' => $_POST['id_role']]);
		return $this->db->affectedRows();
	}
	
	public function saveData() 
	{
		// Find all parent
		$menu_parent = $this->allParents($_POST['id_menu']);
		$role_del = [];

		// Cek role yang tercentang
		foreach ($_POST as $key => $val) {
			$exp = explode('_', $key);
			if ($exp[0] == 'role') {
				$id_role = $exp[1];
				// diganti eko
				// $insert[] = ['id_menu' => $_POST['id_menu'], 'id_role' => $exp[1]];
				$insert[] = ['id' => $exp[1].$_POST['id_menu'],'id_menu' => $_POST['id_menu'], 'id_role' => $exp[1]];
				$curr_id_role[$id_role] = $id_role;
			}
		}
		// echo '<pre>'; print_r($insert);
		
		$insert_parent = [];
		if ($menu_parent) 
		{
			// Cek apakah parent telah diassign di role yang tercentang, jika belum buat insert nya
			foreach($menu_parent as $id_menu_parent) {
				foreach ($curr_id_role as $id_role) {

					$sql = 'SELECT * FROM {prefix_portal}menu_role WHERE id_menu = ? AND id_role = ?';
					$sql=$this->ubahPrefix($sql);

					$data = [$id_menu_parent, $id_role];
					$query = $this->db->query($sql, $data)->getResultArray();
					if (!$query) {
						// digantieko
						// $insert_parent[] = ['id_menu' => $id_menu_parent, 'id_role' => $id_role];
						$insert_parent[] = ['ID' => $id_role.$id_menu_parent ,'ID_MENU' => $id_menu_parent, 'ID_ROLE' => $id_role];

						// pengganti insertbatch tidak jalan
						if ($insert_parent) {

							$data_db['ID'] = $id_role.$id_menu_parent;
							$data_db['ID_MENU'] = $id_menu_parent;
							$data_db['ID_ROLE'] = $id_role;

							$tablename = '{prefix_portal}MENU_ROLE';
							$tablename=$this->ubahPrefix($tablename);

							$this->db->table($tablename)->insert($data_db);
						}
						// batas pengganti insertbatch tidak jalan

					}
				}
			}

			// Delete parent
			// Cari role yang tidak tercentang, kemudian hapus dari tabel
			$sql = 'SELECT * FROM {prefix_portal}ROLE';
			$sql=$this->ubahPrefix($sql);
			$result = $this->db->query($sql)->getResultArray();
			foreach($result as $val) {
				if (!key_exists($val['ID_ROLE'], $curr_id_role)) {
					$role_del[$val['ID_ROLE']] = $val['ID_ROLE'];
				}
			}
		}
		

		// INSERT - DELETE
		// $this->db->transStart();
		// if ($insert_parent) {

		// 	$tablename = '{prefix_portal}MENU_ROLE';
		// 	$tablename=$this->ubahPrefix($tablename);

		// 	$this->db->table($tablename)->insertBatch($insert_parent);
		// }
		
		// Hapus role yang tidak tercentang
		foreach ($role_del as $id_role) {
			$tablename='{prefix_portal}MENU_ROLE';
			$tablename=$this->ubahPrefix($tablename);

			$this->db->table($tablename)->delete(['ID_MENU' => $_POST['id_menu'], 'ID_ROLE' => $id_role]);
		}

		// Insert role yang tercentang
		foreach ($curr_id_role as $id_role) 
		{
			$sql = 'SELECT * FROM {prefix_portal}menu_role WHERE id_menu = ? AND id_role = ?';
			$sql=$this->ubahPrefix($sql);

			$query = $this->db->query($sql, [$_POST['id_menu'], $id_role])->getRowArray();
			if (!$query) {

				$tablename='{prefix_portal}MENU_ROLE';
				$tablename=$this->ubahPrefix($tablename);
				$trans = $this->db->table($tablename)->insert(['ID'=>$id_role.$_POST['id_menu'],'ID_MENU' => $_POST['id_menu'], 'ID_ROLE' => $id_role]);
			}
		}

		// $this->db->transComplete();
		// $trans = $this->db->transStatus();
		
		if ($trans) {
			$result['status'] = 'ok';
			$result['insert_parent'] = $insert_parent;
		} else {
			$result['status'] = 'error';
		}
		return $result;
	}
	
	private function allParents($id_menu, &$list_parent = []) {

		$sql='SELECT * FROM {prefix_portal}MENU';
		$sql=$this->ubahPrefix($sql);
		
		$query = $this->db->query($sql)->getResultArray();
		foreach($query as $val) {
			$menu[$val['ID_MENU']] = $val;
		}
		
		if (key_exists($id_menu, $menu)) {
			$parent = $menu[$id_menu]['ID_PARENT'];
			if ($parent) {
				$list_parent[$parent] = &$parent;
				$this->allParents($parent, $list_parent);
			}
		}
		
		return $list_parent;
	}
}
?>