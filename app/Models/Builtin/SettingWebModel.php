<?php
namespace App\Models\Builtin;

class SettingWebModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
		// helper('stringSQLrep');
	}
	
	public function getSettingWeb() {

		$sql = 'SELECT * FROM {prefix_portal}SETTING_WEB';
		$sql=$this->ubahPrefix($sql);

		$query = $this->db->query($sql)->getResultArray();
		return $query;
	}
	
	public function getUserSetting() {
		
		$sql = 'SELECT * FROM {prefix_portal}setting_app_user WHERE id_user = ?';
		$sql=$this->ubahPrefix($sql);

		$data = $this->db->query($sql, $_SESSION['user']['id_user'])
					->getResultArray();
		return $data;
	}
	
	public function saveData() 
	{
		$query = false;
		helper('util');
		
		$sql = 'SELECT * FROM {prefix_portal}SETTING_WEB';
		$sql=$this->ubahPrefix($sql);

		$query = $this->db->query($sql)->getResultArray();
		
		foreach($query as $val) {
			$curr_db[$val['PARAM']] = $val['VALUE'];
		}
		
		// Logo Login
		$logo_login = $curr_db['logo_login'];
		$path = ROOTPATH . 'public/images/';
		if ($_FILES['logo_login']['name']) 
		{
			//old file
			if ($curr_db['logo_login']) {
				if (file_exists($path . $curr_db['logo_login'])) {
					$unlink = unlink($path . $curr_db['logo_login']);
					if (!$unlink) {
						$data['msg']['status'] = 'error';
						$data['msg']['content'] = 'Gagal menghapus gambar lama';
					}
				}
			}
			
			$logo_login = \upload_file($path, $_FILES['logo_login']);
		}
		
		// Logo App
		$logo_app = $curr_db['logo_app'];
		if ($_FILES['logo_app']['name']) 
		{
			//old file
			if ($curr_db['logo_app']) {
				if (file_exists($path . $curr_db['logo_app'])) {
					$unlink = unlink($path . $curr_db['logo_app']);
					if (!$unlink) {
						$data['msg']['status'] = 'error';
						$data['msg']['content'] = 'Gagal menghapus gambar lama';
					}
				}
			}
			
			$logo_app = \upload_file($path, $_FILES['logo_app']);
		}
		
		// Favicon
		$favicon = $curr_db['favicon'];
		if ($_FILES['favicon']['name']) 
		{
			//old file
			if ($curr_db['favicon']) {
				if (file_exists($path . $curr_db['favicon'])) {
					$unlink = unlink($path . $curr_db['favicon']);
					if (!$unlink) {
						$data['msg']['status'] = 'error';
						$data['msg']['content'] = 'Gagal menghapus gambar lama';
					}
				}
			}
			
			$favicon = \upload_file($path, $_FILES['favicon']);
		}
		
		if ($logo_login && $logo_app && $favicon) 
		{
			$data_db[] = ['PARAM' => 'logo_login', 'VALUE' => $logo_login];
			$data_db[] = ['PARAM' => 'logo_app', 'VALUE' => $logo_app];
			$data_db[] = ['PARAM' => 'footer_login', 'VALUE' => $_POST['footer_login']];
			$data_db[] = ['PARAM' => 'btn_login', 'VALUE' => $_POST['btn_login']];
			$data_db[] = ['PARAM' => 'footer_app', 'VALUE' => $_POST['footer_app']];
			$data_db[] = ['PARAM' => 'background_logo', 'VALUE' => $_POST['background_logo']];
			$data_db[] = ['PARAM' => 'judul_web', 'VALUE' => $_POST['judul_web']];
			$data_db[] = ['PARAM' => 'deskripsi_web', 'VALUE' => $_POST['deskripsi_web']];
			$data_db[] = ['PARAM' => 'favicon', 'VALUE' => $favicon];
			
			$tablename = '{prefix_portal}SETTING_WEB';
			$tablename=$this->ubahPrefix($tablename);


			$sqlclear = 'DELETE SETTING_WEB';

			$scriptdelete = $this->db->query($sqlclear);

			for($i=0;$i<9;$i++){
				$data_dbinsert['PARAM'] = $data_db[$i]['PARAM'];
				$data_dbinsert['VALUE'] = $data_db[$i]['VALUE'];
				$query_result=$this->db->table($tablename)->insert($data_dbinsert);
			}

			// $this->db->transStart();

			// $tablename = '{prefix_portal}SETTING_WEB';
			// $tablename=$this->ubahPrefix($tablename);

			// $this->db->table($tablename)->emptyTable();
			// $this->db->table($tablename)->insertBatch($data_db);
			
			// $query = $this->db->transComplete();
			// $query_result = $this->db->transStatus();
			
			if ($query_result) {
				$file_name = THEME_PATH . 'builtin/css/login-header.css';
				$css = '.login-header {background-color: '.$_POST['background_logo'].';}.edit-logo-login-container {background: '.$_POST['background_logo'].';}';
				
				if (file_exists($file_name)) {
					file_put_contents($file_name, $css);
				}
				$result['status'] = 'ok';
				$result['message'] = 'Data berhasil disimpan';
			} else {
				$result['status'] = 'error';
				$result['message'] = 'Data gagal disimpan';
			}
			
		} else {
			$result['status'] = 'error';
			$result['content'] = 'Error saat memperoses gambar';
		}

		return $result;
	}
}
?>