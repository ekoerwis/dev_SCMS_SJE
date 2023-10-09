<?php

namespace App\Models\Builtin;

class MenuModel extends \App\Models\BaseModel
{
	
	public function __construct() {
		parent::__construct();
		// helper('stringSQLrep');
	}
	
	public function getMenuDb($aktif = 'all', $show_all = false) {
		
		global $db;
		global $app_module;
		
		$result = [];
		$nama_module = $app_module['nama_module'];
		
		$where = ' ';
		$where_aktif = '';
		if ($aktif != 'all') {
			$where_aktif = ' AND aktif = '.$aktif;
		}
		
		$role = '';
		if (!$show_all) {
			$role = ' AND id_role = ' . $_SESSION['user']['id_role'];
		}
		
		$sql = 'SELECT * FROM {prefix_portal}menu 
					LEFT JOIN {prefix_portal}menu_role USING (id_menu)
					LEFT JOIN {prefix_portal}module USING (id_module)
				WHERE 1 = 1 ' . $role
					. $where_aktif.' 
				ORDER BY urut';

		$sql=$this->ubahPrefix($sql);
		
		$this->db->query($sql)->resultArray();
		
		$current_id = '';
		foreach ($query->getResult('array') as $row) {
			$result[$row['id_menu']] = $row;
			$result[$row['id_menu']]['highlight'] = 0;
			$result[$row['id_menu']]['depth'] = 0;

			if ($nama_module == $row['nama_module']) {
				
				$current_id = $row['id_menu'];
				$result[$row['id_menu']]['highlight'] = 1;
			}
		}
		
		if ($current_id) {
			menu_current($result, $current_id);
		}
		
		return $result;
	}
	
	public function getListModules() {
		
		$sql = 'SELECT * FROM {prefix_portal}module LEFT JOIN {prefix_portal}module_status USING(id_module_status) ORDER BY NAMA_MODULE';
		$sql=$this->ubahPrefix($sql);
		return $this->db->query($sql)->getResultArray();
	}
	
	public function getAllRole() {
		$sql = 'SELECT * FROM {prefix_portal}ROLE';
		$sql=$this->ubahPrefix($sql);
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getMenuDetail() {
		$sql = 'SELECT * FROM {prefix_portal}menu WHERE id_menu = ?';
		$sql=$this->ubahPrefix($sql);
		$result = $this->db->query($sql, $_GET['id'])->getRowArray();
		return $result;
	}
	
	public function saveData($id = null) 
	{
		$data_db['NAMA_MENU'] = $_POST['nama_menu'];
		$data_db['ID_MODULE'] = $_POST['id_module'];
		$data_db['URL'] = $_POST['url'];
		if (empty($_POST['aktif'])) {
			$data_db['AKTIF'] = 0;
		} else {
			$data_db['AKTIF'] = 1;
		}
		
		if ($_POST['use_icon']) {
			$data_db['CLASS'] = $_POST['icon_class'];
		} else {
			$data_db['CLASS'] = NULL;
		}
		
		if ($id) {
			$tablename='{prefix_portal}MENU';
			$tablename= $this->ubahPrefix($tablename);
			$proses =  $this->db->table($tablename)->update($data_db, 'ID_MENU = ' . $id);
			
			// return $this->db->affectedRows();
			return $proses;
		} else {
			// tambahan eko dimatikan karena menggunakan seq pada DB
			// $data_db['id_menu'] = $_POST['id_menu'];
			// batas tambahan

			// $tablename='{prefix_portal}MENU';
			// $tablename= $this->ubahPrefix($tablename);
			// $save = $this->db->table($tablename)->insert($data_db);

			// diganti eko
			
			// $insert_id = $this->db->insertID();


			// dimatikan karena menggunakan seq pada DB
			 // $insert_id = $_POST['id_menu'];

			$sqlLastIdMenu = "SELECT MAX(ID_MENU)+1 LAST_ID_MENU FROM MENU";
			$resultLastIdMenu = $this->db->query($sqlLastIdMenu)->getRowArray();

			$data_db['ID_MENU'] =$resultLastIdMenu['LAST_ID_MENU'];

			 $NAMA_MENU = $data_db['NAMA_MENU'] ;
			 $ID_MODULE = $data_db['ID_MODULE'] ;
			 $URL = $data_db['URL'] ;
			 $AKTIF = $data_db['AKTIF'] ;
			 $CLASS = $data_db['CLASS'] ;
			 $ID_MENU = $data_db['ID_MENU'] ;

			$sqlInput = "INSERT INTO MENU (ID_MENU, NAMA_MENU, CLASS, URL, ID_MODULE, AKTIF) VALUES ('$ID_MENU','$NAMA_MENU', '$CLASS', '$URL', '$ID_MODULE', '$AKTIF')";
            $save = $this->db->query($sqlInput);
		}
	}
	
	public function deleteData() {
		$tablename='{prefix_portal}MENU';
		$tablename= $this->ubahPrefix($tablename);
		$prosesDelete=$this->db->table($tablename)->delete(['ID_MENU' => $this->request->getPost('id')]);

		// tambahan eko 15 Jun 2022
		$tablename2='{prefix_portal}MENU_ROLE';
		$tablename2= $this->ubahPrefix($tablename2);
		$prosesDelete2=$this->db->table($tablename2)->delete(['ID_MENU' => $this->request->getPost('id')]);
		//batas tambahan eko 15 Jun 2022


		// return $this->db->affectedRows();
		// diubah tanggal16 April 2023
		return $prosesDelete && $prosesDelete2;
	}
	
	public function getAllMenu() {
		$sql='SELECT * FROM {prefix_portal}MENU';
		$sql=$this->ubahPrefix($sql);
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function updateData() {
		
		$json = json_decode(trim($_POST['data']), true);
		$array = $this->buildChild($json);
		
		foreach ($array as $id_parent => $arr) {
			foreach ($arr as $key => $id_menu) {
				$list_menu[$id_menu] = ['id_parent' => $id_parent, 'urut' => ($key + 1)];
			}
		}
		// echo '<pre>'; print_r($list_menu);die;
		$result = $this->getAllMenu();
		$menu_updated = [];
		foreach ($result as $key => $row) 
		{
			$update = [];
			if ($list_menu[$row['ID_MENU']]['id_parent'] != $row['ID_PARENT']) {
				$id_parent =  $list_menu[$row['ID_MENU']]['id_parent'] == 0 ? NULL : $list_menu[$row['ID_MENU']]['id_parent'];
				$update['ID_PARENT'] = $id_parent;
			}
			
			if ($list_menu[$row['ID_MENU']]['urut'] != $row['URUT']) {
				$update['URUT'] = $list_menu[$row['ID_MENU']]['urut'];
			}
			
			if ($update) {
				$tablename='{prefix_portal}MENU';
				$tablename= $this->ubahPrefix($tablename);
				$result = $this->db->table($tablename)->update($update, ['ID_MENU=' => $row['ID_MENU']]);
				if ($result) {
					$menu_updated[$row['ID_MENU']] = $row['ID_MENU'];
				}
			}
		}
		return $menu_updated;
	}
	
	private function buildChild($arr, $parent=0, &$list=[]) 
	{
		foreach ($arr as $key => $val) 
		{
			// tambahan eko

			// batas tambahan eko

			$list[$parent][] = $val['id'];

			if (key_exists('children', $val))
			{ 
				$this->buildChild($val['children'], $val['id'], $list);
			}
		}
		
		
		return $list;
	}
}
?>