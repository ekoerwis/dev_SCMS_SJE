<?php
namespace App\Models\Builtin;

class UserModel extends \App\Models\BaseModel
{

	public function __construct() {
		parent::__construct();
		// helper('stringSQLrep');
	}

	public function countListUsers($searchTambahanCount='') {
		$sql = "SELECT COUNT(*) as jml FROM (
			SELECT ROWNUM RN,ID_ROLE, ID_USER, EMAIL, USERNAME, 
			NAMA, PASSWORD, AKTIF, CREATED, AVATAR, NAMA_ROLE, 
			JUDUL_ROLE, KETERANGAN, ID_MODULE 
			FROM ( SELECT * FROM users LEFT JOIN role USING(id_role) ORDER BY ID_USER)
				WHERE
				( LOWER(TO_CHAR(ID_USER)) LIKE LOWER('%$searchTambahanCount%') OR LOWER(EMAIL) LIKE LOWER('%$searchTambahanCount%') OR LOWER(USERNAME) LIKE LOWER('%$searchTambahanCount%') OR LOWER(NAMA) LIKE LOWER('%$searchTambahanCount%') OR LOWER(JUDUL_ROLE) LIKE LOWER('%$searchTambahanCount%'))
		)";
		$sql=$this->ubahPrefix($sql);
		$query = $this->db->query($sql)->getRow();
		return $query->JML;
	}
	
	public function getListUsers($action_user) { 
		
		// Get user
		// $where = ' WHERE 1 = 1 ';
		$where = ' ';
		if ($action_user['READ_DATA'] == 'own') {
			$where .= ' AND id_user = ' . $this->session->get('user')['id_user'];
		}
		$columns = $this->request->getPost('columns');
		$order_by = '';
		
		// Search
		$search_all = @$this->request->getPost('search')['value'];
		if ($search_all) {
			
			foreach ($columns as $val) {
				if (strpos($val['data'], 'ignore') !== false)
					continue;
				
				$where_col[] = $val['data'] . ' LIKE "%' . $search_all . '%"';
			}
			 $where .= ' AND (' . join(' OR ', $where_col) . ') ';
		}
		
		// Order
		$order = $this->request->getPost('order');
	
		if (@$order[0]['column'] != '' ) {
			$order_by = ' ORDER BY ' . $columns[$order[0]['column']]['data'] . ' ' . strtoupper($order[0]['dir']);
		}

		$start = $this->request->getPost('start') ?: 0;
		$length = $this->request->getPost('length') ?: 10;

		$searchTambahan = isset($_POST['search']['value']) ? strval($_POST['search']['value']) : '';

		if (isset($start)) {
			$start = $start+1;
			$length = $length-1;
		}

		$tot = $start + $length;

		// $sql = 'SELECT * FROM user LEFT JOIN role USING(id_role) ' . $where . $order_by . ' LIMIT ' . $start . ' ' . $length;
		// $sql = 'SELECT * FROM {prefix_portal}users LEFT JOIN {prefix_portal}role USING(id_role) '  ;
		// echo $sql;
		$sql = "SELECT * FROM (
			SELECT ROWNUM RN,ID_ROLE, ID_USER, EMAIL, USERNAME, 
			NAMA, PASSWORD, AKTIF, CREATED, AVATAR, NAMA_ROLE, 
			JUDUL_ROLE, KETERANGAN, ID_MODULE 
			FROM ( 
				SELECT * FROM users LEFT JOIN role USING(id_role) ORDER BY ID_USER)
				WHERE
				( LOWER(TO_CHAR(ID_USER)) LIKE LOWER('%$searchTambahan%') OR LOWER(EMAIL) LIKE LOWER('%$searchTambahan%') OR LOWER(USERNAME) LIKE LOWER('%$searchTambahan%') OR LOWER(NAMA) LIKE LOWER('%$searchTambahan%') OR LOWER(JUDUL_ROLE) LIKE LOWER('%$searchTambahan%'))
			) WHERE  RN BETWEEN ".$start. " AND ".$tot;
		$sql=$this->ubahPrefix($sql);
		return $this->db->query($sql)->getResultArray();
	}
	
	public function getRole() {
		$sql = 'SELECT * FROM {prefix_portal}role';
		$sql=$this->ubahPrefix($sql);
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getMembership() {
		$sql = 'SELECT * FROM {prefix_portal}membership';
		$sql=$this->ubahPrefix($sql);
		$query = $this->db->query($sql)->getResultArray();
		foreach ($query as $key => $val) {
			$result[$val['id_membership']] = $val['judul_membership'];
		}
		return $result;
	}
	
	public function saveData($action_user = []) 
	{ 
		// $fields = ['ID_USER','ID_ROLE', 'NAMA', 'EMAIL', 'AKTIF'];

		// penghilangan form input id karena sudah sequence
		if ($this->request->getPost('id')) {
			$fields = ['ID_USER','ID_ROLE', 'NAMA', 'EMAIL', 'AKTIF'];
		} else {
			$fields = ['ID_ROLE', 'NAMA', 'EMAIL', 'AKTIF'];
		}
		//batas penghilangan form input id karena sudah sequence

		if ($action_user['UPDATE_DATA'] == 'all') {
			$fields[] = 'USERNAME';
		}

		foreach ($fields as $field) {
			$data_db[$field] = $this->request->getPost($field);
		}
		
		if (!$this->request->getPost('id')) {
			$data_db['PASSWORD'] = password_hash($this->request->getPost('PASSWORD'), PASSWORD_DEFAULT);
			$exp = explode('-', $this->request->getPost('tgl_lahir'));
		}
		
		// Save database
		if ($this->request->getPost('id')) {
			$id_user = $this->request->getPost('id');

			$tablename = '{prefix_portal}USERS' ;
			$tablename=$this->ubahPrefix($tablename);

			$save = $this->db->table($tablename)->update($data_db, ['ID_USER' => $id_user]);
		} else {
			$data_db['AKTIF'] = 1;

			// TAMBAHAN 14 APRIL 2023
			$sqlLastIdUser = "SELECT MAX(ID_USER)+1 LAST_ID_USER FROM USERS";
			$resultLastIdUser = $this->db->query($sqlLastIdUser)->getRowArray();

			$data_db['ID_USER'] =$resultLastIdUser['LAST_ID_USER'];
			$data_db['CREATED'] =date("d/M/Y H:i:s");
	
			$EMAIL = $data_db['EMAIL'];
			$USERNAME =  $data_db['USERNAME'];
			$NAMA = $data_db['NAMA'];
			$PASSWORD = $data_db['PASSWORD'];
			$AKTIF = $data_db['AKTIF'];
			$ID_USER = $data_db['ID_USER'];
			$CREATED = $data_db['CREATED'];
			$ID_ROLE = $data_db['ID_ROLE'];
			// BATAS TAMBAHAN 14 APRIL 2023

			$tablename = '{prefix_portal}USERS' ;
			$tablename=$this->ubahPrefix($tablename);

			// $save = $this->db->table($tablename)->insert($data_db);

			// SCRIPT save DIGANTI 14 APRIL 2023
			$sqlInput = "INSERT INTO USERS (ID_USER, USERNAME, PASSWORD, NAMA, EMAIL, AKTIF, CREATED, ID_ROLE) VALUES ($ID_USER, '$USERNAME', '$PASSWORD', '$NAMA', '$EMAIL', $AKTIF, TO_DATE('$CREATED','DD/MON/YYYY HH24:MI:SS'), $ID_ROLE)";
            $save = $this->db->query($sqlInput);
			// dimatikan eko
			// $id_user = $this->db->insertID();
		}
		
		if ($save) {
			
			$file = $this->request->getFile('AVATAR');
			
			if ($file && $file->getName()) 
			{
				$error = false;
				$path = 'public/images/user/';
				
				//old file
				if ($this->request->getPost('id')) 
				{
					$sql = 'SELECT avatar FROM {prefix_portal}users WHERE id_user = ?';
					$sql=$this->ubahPrefix($sql);

					$img_db = $this->db->query($sql, $id_user)->getRow();
					if ($img_db->AVATAR) {
						$unlink = unlink($path . '/' . $img_db->AVATAR);
						if (!$unlink) {
							$result['message'] = 'Data berhasil disimpan, tetapi gagal memproses foto: gagal menghapus gambar lama';
							return $result;
						}
					}
				}
				
				if (!is_dir($path)) {
					if (!mkdir($path, 0777, true)) {
						$result['message'] = 'Data berhasil disimpan, tetapi gagal memproses foto: Unable to create a directory';
						return $result;
					}
				}
				
				$new_name =  get_filename($file->getName(), $path);
					
				$file->move($path, $new_name);
					
				if (!$file->hasMoved()) {
					$result['message'] = 'Error saat memperoses gambar';
					return $result;
				}
				
				// Update avatar
				$data_db = [];
				$data_db['AVATAR'] = $new_name;

				$tablename = '{prefix_portal}USERS' ;
				$tablename=$this->ubahPrefix($tablename);

				$save = $this->db->table($tablename)->update($data_db, ['ID_USER' => $id_user]);
			}
		}
		
		if ($save) {
			$result['status'] = 'ok';
			$result['message'] = 'Data berhasil disimpan';
		} else {
			$result['status'] = 'error';
		}
								
		return $result;
	}
	
	public function deleteUser() {

		$tablename = '{prefix_portal}USERS' ;
		$tablename=$this->ubahPrefix($tablename);

		$prosesDelete=$this->db->table($tablename)->delete(['ID_USER' => $this->request->getPost('id')]);

		// tambahan eko 15 Jun 2022

		$tablename2 = '{prefix_portal}USER_ROLE' ;
		$tablename2=$this->ubahPrefix($tablename2);

		$prosesDelete2=$this->db->table($tablename2)->delete(['ID_USER' => $this->request->getPost('id')]);

		// batas tambahan eko 15 Jun 2022

		// return $this->db->affectedRows();
		return $prosesDelete && $prosesDelete2;
	}
	
	public function countAllUsers() {
		$sql = 'SELECT COUNT(*) as jml FROM {prefix_portal}users';
		$sql=$this->ubahPrefix($sql);
		$query = $this->db->query($sql)->getRow();
		return $query->JML;
	}

	public function updatePassword() {
		$password_hash = password_hash($this->request->getPost('password_new'), PASSWORD_DEFAULT);
		$sql = 'UPDATE {prefix_portal}users SET password = ? 
									WHERE id_user = ? ';
		$sql=$this->ubahPrefix($sql);
		$update = $this->db->query($sql, [$password_hash, $this->user->ID_USER]
								);		
		return $update;
	}

	public function resetPasswordIndependent() {
		$password_hash = password_hash($this->request->getPost('password_new'), PASSWORD_DEFAULT);
		$sql = 'UPDATE {prefix_portal}users SET password = ? 
									WHERE id_user = ? ';
		$sql=$this->ubahPrefix($sql);
		$update = $this->db->query($sql, [$password_hash, $this->request->getPost('id')]
								);		
		return $update;
	}
}
?>