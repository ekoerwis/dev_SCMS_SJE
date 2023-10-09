<?php
namespace App\Models\Builtin;

class RoleModel extends \App\Models\BaseModel
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
	
	public function getModuleStatus() {
		$sql = 'SELECT * FROM {prefix_portal}module_status';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function listModuleRole() {

		// $sql ="SELECT * FROM MODULE_ROLE LEFT JOIN MODULE USING(ID_MODULE) ORDER BY NAMA_MODULE";

		// SQL DI GANTI TANGGAL 14 APR 2023 untuk menghilangkan bugs bila modul tidak cocok
		$sql = 'SELECT A.* FROM (
			SELECT * FROM MODULE_ROLE LEFT JOIN MODULE USING(ID_MODULE) ORDER BY NAMA_MODULE) A
			, MODULE B, ROLE C
			WHERE A.ID_MODULE = B.ID_MODULE AND A.ID_ROLE = C.ID_ROLE';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAllRole() {
		// $sql = 'SELECT * FROM {prefix_portal}role';

		// SQL DI GANTI TANGGAL 14 APR 2023 untuk menghilangkan bugs bila modul tidak cocok
		$sql = 'SELECT A.ID_ROLE, A.NAMA_ROLE, A.JUDUL_ROLE, A.KETERANGAN, A.ID_MODULE FROM ROLE A , MODULE B WHERE A.ID_MODULE=B.ID_MODULE';
		// $sql = 'SELECT A.ID_ROLE, A.NAMA_ROLE, A.JUDUL_ROLE, A.KETERANGAN, A.ID_MODULE FROM ROLE A ';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}

	// TAMBAHAN 16 APRIL 2023
	public function getAllRoleNew() {

		$sql = "SELECT A.ID_ROLE, A.NAMA_ROLE, A.JUDUL_ROLE, A.KETERANGAN, A.ID_MODULE , B.NAMA_MODULE
		FROM ROLE A
		LEFT JOIN MODULE B
		ON A.ID_MODULE = B.ID_MODULE
		WHERE A.ID_ROLE =1
		UNION ALL
		(
		SELECT * FROM (
		SELECT A.ID_ROLE, A.NAMA_ROLE, A.JUDUL_ROLE, A.KETERANGAN, A.ID_MODULE , B.NAMA_MODULE
		FROM ROLE A
		LEFT JOIN MODULE B
		ON A.ID_MODULE = B.ID_MODULE
		WHERE A.ID_ROLE <>1
		ORDER BY UPPER(NAMA_ROLE) ASC)
		)";
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
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
	
	public function saveData() 
	{
		// $fields = ['ID_ROLE','NAMA_ROLE','JUDUL_ROLE', 'KETERANGAN'];
		// diganti eko karena ID_ROLE menggunakan sequence 26mar22
		$fields = ['NAMA_ROLE','JUDUL_ROLE', 'KETERANGAN','ID_MODULE'];
		// batas diganti eko karena ID_ROLE menggunakan sequence 26mar22

		foreach ($fields as $field) {
			$data_db[$field] = $this->request->getPost($field);
		}
		// $fields['ID_MODULE'] = $this->request->getPost('ID_MODULE') ?: 0;
		
		// Save database
		if ($this->request->getPost('id')) {

			// tambahan eko
			$fields = ['NAMA_ROLE','JUDUL_ROLE', 'KETERANGAN','ID_MODULE'];

			foreach ($fields as $field) {
				$data_db[$field] = $this->request->getPost($field);
			}
			// batas tambahan eko

			$id_role = $this->request->getPost('id');

			$tablename = '{prefix_portal}ROLE';
			$tablename=$this->ubahPrefix($tablename);

			$save = $this->db->table($tablename)->update($data_db, ['ID_ROLE' => $id_role]);
		} else {
			$tablename = '{prefix_portal}ROLE';
			$tablename=$this->ubahPrefix($tablename);

			// TAMBAHAN 14 APR 2023

			$sqlLastIdRole = "SELECT MAX(ID_ROLE)+1 LAST_ID_ROLE FROM ROLE";
        	$resultLastIdRole = $this->db->query($sqlLastIdRole)->getRowArray();

        	$ID_ROLE =$resultLastIdRole['LAST_ID_ROLE'];

			$NAMA_ROLE = $this->request->getPost('NAMA_ROLE');
			$JUDUL_ROLE=$this->request->getPost('JUDUL_ROLE');
			$KETERANGAN = $this->request->getPost('KETERANGAN');
			$ID_MODULE = $this->request->getPost('ID_MODULE');

			$sqlInput = "INSERT INTO ROLE (ID_ROLE, NAMA_ROLE, JUDUL_ROLE, KETERANGAN, ID_MODULE) VALUES ($ID_ROLE, '$NAMA_ROLE', '$JUDUL_ROLE', '$KETERANGAN', '$ID_MODULE')";
            $save = $this->db->query($sqlInput);

			// BATAS TAMBAHAN 14 APR 2023

			// script insert diubah 14 apr 2023 menjadi manual tidak menggunakan sequense oracle DB
			// $save = $this->db->table($tablename)->insert($data_db);
			// diganti eko
			// $id_role = $this->db->insertID();
			// $id_role = $this->request->getPost('id_role');

			// baru untuk mencari id_role yang baru masuk 26mar22
			$sqlCari = "SELECT * FROM ROLE WHERE NAMA_ROLE = '".$_POST['NAMA_ROLE']."' AND JUDUL_ROLE = '".$_POST['JUDUL_ROLE']."' AND KETERANGAN = '".$_POST['KETERANGAN']."'";
			$sqlCari=$this->ubahPrefix($sqlCari);
			$resultCari = $this->db->query($sqlCari)->getRowArray();
			$id_role = $resultCari['ID_ROLE'];
			//BATAS  baru untuk mencari id_role yang baru masuk 26mar22
			
		}
		
		if ($save) {
			$result['status'] = 'ok';
			$result['message'] = 'Data berhasil disimpan';
			$result['id_role'] = $id_role;
		} else {
			$result['status'] = 'error';
			$result['message'] = 'Data gagal disimpan';
		}
								
		return $result;
	}
	
	public function deleteData() {
		$tablename = '{prefix_portal}ROLE';
		$tablename=$this->ubahPrefix($tablename);

		$prosesDelete = $this->db->table($tablename)->delete(['ID_ROLE' => $this->request->getPost('id')]);

		// tambahan eko 15 jun 2022
		$tablename2 = '{prefix_portal}MENU_ROLE';
		$tablename2=$this->ubahPrefix($tablename2);

		$prosesDelete2 = $this->db->table($tablename2)->delete(['ID_ROLE' => $this->request->getPost('id')]);

		$tablename3 = '{prefix_portal}MODULE_ROLE';
		$tablename3=$this->ubahPrefix($tablename3);

		$prosesDelete3 = $this->db->table($tablename3)->delete(['ID_ROLE' => $this->request->getPost('id')]);

		$tablename4 = '{prefix_portal}USER_ROLE';
		$tablename4=$this->ubahPrefix($tablename4);

		$prosesDelete4 = $this->db->table($tablename4)->delete(['ID_ROLE' => $this->request->getPost('id')]);
		//batas tambahan eko 15 jun 2022

		// return $this->db->affectedRows();
		return $prosesDelete && $prosesDelete2 && $prosesDelete3 && $prosesDelete4 ;
	}
}
?>