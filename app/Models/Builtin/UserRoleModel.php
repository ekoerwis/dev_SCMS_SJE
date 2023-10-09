<?php
/**
*	App Name	: Admin Template Dashboard Codeigniter 4	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2020 
*/

namespace App\Models\Builtin;

class UserRoleModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
		// helper('stringSQLrep');
	}
	
	public function getAllRole() {

		$sql = 'SELECT * FROM {prefix_portal}ROLE';
		$sql=$this->ubahPrefix($sql);
		
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getUserRole() {
		$sql = 'SELECT * FROM {prefix_portal}USER_ROLE';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getUserRoleByID($id) {
		$sql = 'SELECT * FROM {prefix_portal}user_role WHERE id_user = ?';
		$sql=$this->ubahPrefix($sql);
		$result = $this->db->query($sql, $id)->getResultArray();
		return $result;
	}
	
	public function getAllUser() {

		$sql = 'SELECT * FROM {prefix_portal}USERS';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function deleteData() {

		$tablename = '{prefix_portal}USER_ROLE';
		$tablename=$this->ubahPrefix($tablename);

		$this->db->table($tablename)->delete(['ID_USER' => $_POST['pair_id'], 'ID_ROLE' => $_POST['id_role']]);

		// $sqldelete = 'DELETE USER_ROLE WHERE ID_USER = '.$_POST['pair_id'].' AND ID_ROLE = '.$_POST['id_role'];

		// $this->db->query($sqldelete);

		return $this->db->affectedRows();
	}
	
	public function saveData() {

		// ada delete disini karena transStart tidak jalan 
		$tablename = '{prefix_portal}USER_ROLE';
		$tablename=$this->ubahPrefix($tablename);

		$result = $this->db->table($tablename)->delete(['ID_USER' => $_POST['pair_id']]);

		// batas delete disini karena transStart tidak jalan 


		foreach ($_POST as $key => $val) {
			$exp = explode('_', $key);
			if ($exp[0] == 'role') {

				// dimatikan karena transStart tidak jalan 
				// $insert[] = ['id_user' => $_POST['pair_id'], 'id_role' => $exp[1]];
				// $insert[] = ['ID' => $exp[1].$_POST['pair_id'],'ID_USER' => $_POST['pair_id'], 'ID_ROLE' => $exp[1]];
				// batas dimatikan karena transStart tidak jalan 

				$data_db['ID'] = $exp[1].$_POST['pair_id'];
				$data_db['ID_USER']=$_POST['pair_id'];
				$data_db['ID_ROLE']=$exp[1];

				$result = $this->db->table($tablename)->insert($data_db);
			}

		}
		
		// dimatikan karena transStart tidak jalan 
		// INSERT - UPDATE
		// $this->db->transStart();

		// $tablename = '{prefix_portal}USER_ROLE';
		// $tablename=$this->ubahPrefix($tablename);

		// $this->db->table($tablename)->delete(['ID_USER' => $_POST['pair_id']]);
		// $this->db->table($tablename)->insertBatch($insert);
		// $this->db->transComplete();
		// $result = $this->db->transStatus();
		
		return $result;
	}
}
?>