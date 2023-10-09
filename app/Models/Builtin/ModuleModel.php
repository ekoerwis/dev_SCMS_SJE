<?php
namespace App\Models\Builtin;

class ModuleModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
		// helper('stringSQLrep');
	}
	
	public function getAllModules() {
		
		$sql = 'SELECT * FROM {prefix_portal}module';
		$sql=$this->ubahPrefix($sql);

		return $this->db->query($sql)->getResultArray();
	}
	
	public function getAllModuleStatus() {
		
		$sql = 'SELECT * FROM {prefix_portal}module_status';
		$sql=$this->ubahPrefix($sql);

		return $this->db->query($sql)->getResultArray();
	}
	
	public function getModule($id_module) {
		
		$sql = 'SELECT * FROM {prefix_portal}module WHERE id_module = ?';
		$sql=$this->ubahPrefix($sql);
		return $this->db->query($sql, [$id_module])->getRowArray();
	}
	
	public function getAllModuleRole() {
		$sql = 'SELECT * FROM {prefix_portal}module_role LEFT JOIN {prefix_portal}module USING(id_module)';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAllRoles() {

		$sql = 'SELECT * FROM {prefix_portal}role';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function deleteData() {

		$tablename = '{prefix_portal}MODULE';
		$tablename = $this->ubahPrefix($tablename);

		$this->db->table($tablename)->delete(['ID_MODULE' => $this->request->getPost('id')]);

		// tambahan eko 15 Jun 2022
		$tablename2 = '{prefix_portal}MODULE_ROLE';
		$tablename2 = $this->ubahPrefix($tablename2);

		$this->db->table($tablename2)->delete(['ID_MODULE' => $this->request->getPost('id')]);

		$idModule = $this->request->getPost('id');
		$sqlUpdate ="UPDATE MENU SET ID_MODULE = 0 WHERE ID_MODULE = $idModule"; 
		$proses = $this->db->query($sqlUpdate);
		// batas tambahan eko 15 Jun 2022

		// return $this->db->affectedRows();
		return $proses;
	}
	
	public function updateStatus() {
		
		$field = $_POST['switch_type'] == 'aktif' ? 'id_module_status' : 'login';
		
		$tablename = '{prefix_portal}module';
		$tablename = $this->ubahPrefix($tablename);

		$this->db->table($tablename)
					->update( 
						[$field => $_POST['id_result']], 
						['id_module' => $_POST['id_module']]
					);
	}
	
	public function getModules() {
		$sql = 'SELECT * FROM {prefix_portal}module LEFT JOIN {prefix_portal}module_status USING(id_module_status)';
		$sql=$this->ubahPrefix($sql);

		return $this->db->query($sql)->getResultArray();
	}
	
	public function saveData() 
	{
		// dimatikan  karena menggunakan seq pada DB
		// $fields = ['id_module','nama_module', 'judul_module', 'deskripsi', 'id_module_status'];
		$fields = ['NAMA_MODULE', 'JUDUL_MODULE', 'DESKRIPSI', 'ID_MODULE_STATUS'];

		foreach ($fields as $field) {
			$data_db[$field] = $this->request->getPost($field);
		}
		
		// Save database
		if ($this->request->getPost('id')) {

			// tambahan eko
			$fields = ['NAMA_MODULE', 'JUDUL_MODULE', 'DESKRIPSI', 'ID_MODULE_STATUS'];

			foreach ($fields as $field) {
				$data_db[$field] = $this->request->getPost($field);
			}
			// batas tambahan eko

			$id_module = $this->request->getPost('id');

			$ID_MODULE = $this->request->getPost('id');

			$tablename = '{prefix_portal}MODULE';
			$tablename = $this->ubahPrefix($tablename);

			$save = $this->db->table($tablename)->update($data_db, ['ID_MODULE' => $_POST['id']]);
		} else {
			// $tablename = '{prefix_portal}MODULE';
			// $tablename = $this->ubahPrefix($tablename);

			// $save = $this->db->table($tablename)->insert($data_db);
			// $id_module = $this->db->insertID();

			// Query save diganti tanggal 16 April 2023
			$sqlLastIdModule = "SELECT MAX(ID_MODULE)+1 LAST_ID_MODULE FROM MODULE";
			$resultLastIdModule = $this->db->query($sqlLastIdModule)->getRowArray();

			$ID_MODULE =$resultLastIdModule['LAST_ID_MODULE'];
			$NAMA_MODULE= $this->request->getPost('NAMA_MODULE');
			$JUDUL_MODULE= $this->request->getPost('JUDUL_MODULE');
			$DESKRIPSI= $this->request->getPost('DESKRIPSI');
			$ID_MODULE_STATUS= $this->request->getPost('ID_MODULE_STATUS');
			$sqlInput = "INSERT INTO MODULE (ID_MODULE, NAMA_MODULE, JUDUL_MODULE, DESKRIPSI, ID_MODULE_STATUS) VALUES ('$ID_MODULE', '$NAMA_MODULE', '$JUDUL_MODULE', '$DESKRIPSI', '$ID_MODULE_STATUS')";
            $save = $this->db->query($sqlInput);
			// Batas query save diganti tanggal 16 April 2023


			// diganti eko (dimatikan dahulu gunakan default karena menggunakan seq pada DB)
			// $id_module = $this->request->getPost('id_module');
		}
		
		if ($save) {
			$result['status'] = 'ok';
			$result['message'] = 'Data berhasil disimpan';
			$result['id_module'] = $ID_MODULE;
		} else {
			$result['status'] = 'error';
			$result['message'] = 'Data gagal disimpan';
		}
								
		return $result;
	}
	
	// EDIT
	public function getRole() {
		$id_role = $this->request->getGet('id');

		$sql = 'SELECT * FROM {prefix_portal}role WHERE id_role = ?';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql, [$id_role])->getRowArray();
		if (!$result)
			$result = [];
		return $result;
	}
	
	
}
?>