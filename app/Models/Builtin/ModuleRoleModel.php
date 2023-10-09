<?php 
namespace App\Models\Builtin;

class ModuleRoleModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
		// helper('stringSQLrep');
	}
	
	public function getAllModule() {

		$sql = 'SELECT * FROM {prefix_portal}MODULE';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getModule($id) {
		$sql = 'SELECT * FROM {prefix_portal}module WHERE id_module = ?';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql, [$id])->getRowArray();

		return $result;
	}
	
	public function getAllRole() {

		$sql = 'SELECT * FROM {prefix_portal}ROLE';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getRoleDetail() {

		$sql = 'SELECT * FROM {prefix_portal}ROLE_DETAIL';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAllModuleRole() {
		$sql = 'SELECT * FROM {prefix_portal}MODULE_ROLE';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getModuleRoleById($id) {

		$sql = 'SELECT * FROM {prefix_portal}module_role WHERE id_module = ?';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql, [$id])->getResultArray();
		// echo '<pre>'; print_r($result); die;
		return $result;
	}
	
	public function getModuleStatus() {
		$sql = 'SELECT * FROM {prefix_portal}module
				LEFT JOIN {prefix_portal}module_status USING(id_module_status)';
		$sql=$this->ubahPrefix($sql);
				
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function deleteData() {

		$tablename='{prefix_portal}MODULE_ROLE';
		$tablename=$this->ubahPrefix($tablename);

		$this->db->table($tablename)->delete(['ID_MODULE' => $_POST['pair_id'], 'ID_ROLE' => $_POST['id_role']]);

		return $this->db->affectedRows();
	}
	
	public function saveData() 
	{

		// pengganti insertbatch tidak bisa

		$tablename='{prefix_portal}MODULE_ROLE';
		$tablename=$this->ubahPrefix($tablename);

		$this->db->table($tablename)->delete(['ID_MODULE' => $_POST['id']]);
		// batas pengganti insertbatch tidak bisa

		foreach ($_POST as $key => $val) {
			$exp = explode('_', $key);
			if ($exp[0] == 'role') {
				$id_role = $exp[1];
				// diganti eko
				// $data_db[] = ['id_module' => $_POST['id']
				// 				, 'id_role' => $id_role
				// 				, 'read_data' => $_POST['akses_read_data_' . $id_role]
				// 				, 'create_data' => $_POST['akses_create_data_' . $id_role]
				// 				, 'update_data' => $_POST['akses_update_data_' . $id_role]
				// 				, 'delete_data' => $_POST['akses_delete_data_' . $id_role]
				// 			];
				// $data_db[] = ['ID' => $id_role.$_POST['id']
				// 				,'ID_MODULE' => $_POST['id']
				// 				, 'ID_ROLE' => $id_role
				// 				, 'READ_DATA' => $_POST['akses_READ_DATA_' . $id_role]
				// 				, 'CREATE_DATA' => $_POST['akses_CREATE_DATA_' . $id_role]
				// 				, 'UPDATE_DATA' => $_POST['akses_UPDATE_DATA_' . $id_role]
				// 				, 'DELETE_DATA' => $_POST['akses_DELETE_DATA_' . $id_role]
				// 			];

				// pengganti insertbatch tidak bisa
				$data_db['ID'] = $id_role.$_POST['id'];
				$data_db['ID_MODULE'] = $_POST['id'];
				$data_db[ 'ID_ROLE'] = $id_role;
				$data_db[ 'READ_DATA'] = $_POST['akses_READ_DATA_' . $id_role];
				$data_db[ 'CREATE_DATA'] = $_POST['akses_CREATE_DATA_' . $id_role];
				$data_db[ 'UPDATE_DATA'] = $_POST['akses_UPDATE_DATA_' . $id_role];
				$data_db[ 'DELETE_DATA'] = $_POST['akses_DELETE_DATA_' . $id_role];

					$result = $this->db->table($tablename)->insert($data_db);
				// batas pengganti insertbatch tidak bisa
			}
		}
		
		// INSERT - UPDATE
		// $this->db->transStart();

		// $tablename='{prefix_portal}MODULE_ROLE';
		// $tablename=$this->ubahPrefix($tablename);

		// $this->db->table($tablename)->delete(['ID_MODULE' => $_POST['id']]);
		// $this->db->table($tablename)->insertBatch($data_db);

		// $this->db->transComplete();
		// $result = $this->db->transStatus();
								
		return $result;
	}
}
?>