<?php
namespace App\Models\Builtin;

class SettingModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
		// helper('stringSQLrep');
	}
	
	public function getDefaultSetting() {
		$sql = 'SELECT * FROM {prefix_portal}SETTING_APP_TAMPILAN';
		$sql=$this->ubahPrefix($sql);
		
		$data = $this->db->query($sql)->getResultArray();
		return $data;
	}
	
	public function getUserSetting() {

		$sql = 'SELECT * FROM {prefix_portal}setting_app_user WHERE id_user = ?';
		$sql=$this->ubahPrefix($sql);

		$data = $this->db->query($sql, $_SESSION['user']['ID_USER'])
					->getRowArray();
		return $data;
	}
	
	public function saveData($module_role) 
	{
		$query = false;
		

		
		if ($module_role[$_SESSION['user']['ID_ROLE']]['UPDATE_DATA'] == 'all')
		{
			$params = ['color_scheme' => 'Color Scheme'
			, 'sidebar_color' => 'Sidebar Color'
			, 'logo_background_color' => 'Background Logo'
			, 'font_family' => 'Font Family'
			, 'font_size' => 'Font Size'
			];
			
			$sql = 'DELETE FROM {prefix_portal}SETTING_APP_TAMPILAN';
			$sql=$this->ubahPrefix($sql);
			$this->db->query($sql);

			$num = 1;
			foreach ($params as $param => $title) {
				// $data_db[] = ['ID' => $num, 'PARAM' => $param, 'VALUE' => $_POST[$param]];
				$arr[$param] = $_POST[$param];
				$data_dbinserttampilan['ID']=$num;
				$data_dbinserttampilan['PARAM']=$param;
				$data_dbinserttampilan['VALUE']=$_POST[$param];
				$num++;

				$tablename = '{prefix_portal}SETTING_APP_TAMPILAN';
				$tablename=$this->ubahPrefix($tablename);
				$result = $this->db->table($tablename)->insert($data_dbinserttampilan);
			}
			// transStart tidak jalan di oracle
			// $this->db->transStart();

			


			// $tablename = '{prefix_portal}SETTING_APP_TAMPILAN';
			// $tablename=$this->ubahPrefix($tablename);
			// $result = $this->db->table($tablename)->insertBatch($data_db);
			// $this->db->transComplete();

			// $result = $this->db->transStatus();
			
			// if ($this->db->transStatus()) {
			if($result){
				$file_name = ROOTPATH . 'public/themes/modern/builtin/css/fonts/font-size-' . $_POST['font_size'] . '.css';
				if (!file_exists($file_name)) {
					file_put_contents($file_name, 'html, body { font-size: ' . $_POST['font_size'] . 'px }');
				}						
			}
			
		} else if ($module_role[$_SESSION['user']['ID_ROLE']]['UPDATE_DATA'] == 'own') 
		{
			// $this->db->transStart();
			$tablename = '{prefix_portal}SETTING_APP_USER';
			$tablename=$this->ubahPrefix($tablename);
			$this->db->table($tablename)->delete(['ID_USER' => $_SESSION['user']['ID_USER'] ]);

			$data_dbinserttamuser['ID_USER'] = $_SESSION['user']['ID_USER'];
			$data_dbinserttamuser['PARAM'] = json_encode($arr);

			// $result = $this->db->table($tablename)->insert(['ID_USER' => $_SESSION['user']['ID_USER']
			// 												, 'PARAM' => json_encode($arr)
			// 											]
			// 				);

			$result = $this->db->table($tablename)->insert($data_dbinserttamuser);
			
			// $this->db->transComplete();
			// $result = $this->db->transStatus();
		}
		
		return $result;
	}
}
?>