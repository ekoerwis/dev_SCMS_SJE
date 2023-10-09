<?php


namespace App\Models;


class BaseModel extends \CodeIgniter\Model 
{
	protected $request;
	protected $session;
	private $auth;
	protected $user;
	
	public function __construct() {
		parent::__construct();
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();
		$user = $this->session->get('user');
		if ($user)
			$this->user = $this->getUserById($user['ID_USER']);
		
		$this->auth = new \App\Libraries\Auth;
		// helper('stringSQLrep');


		// TAMBAHAN 24 NOV 2022
		$this->db2 = db_connect("dbtrxi");
		// BATAS TAMBAHAN 24 NOV 2022
	}

	public function ubahPrefix($sqltext=''){

		$dbdr='mysql';
		$dbdr='postgres';
		$dbdr='OCI8';

		if($dbdr=='postgres'){
			$pref1='{prefix_portal}';
			$pref2='{prefix_apps}';
			$pref3='{prefix_trxi}';
			$pref11='"SCH_PORTAL".';
			$pref22='"SCH_APPS".';
			$pref33='"SCH_TRXI".';
		}
		else {
			$pref1='{prefix_portal}';
			$pref2='{prefix_apps}';
			$pref3='{prefix_trxi}';
			$pref11=' ';
			$pref22='EPMSAPPS.';
			$pref33=' ';
		}
		

		// $pref11='"public".';
		// $pref22='';
		// $pref33='';

		$sqlstring1 = str_replace($pref1, $pref11, $sqltext);
		$sqlstring2 = str_replace($pref2, $pref22, $sqlstring1);
		$sqlstring3 = str_replace($pref3, $pref33, $sqlstring2);

		return $sqlstring3;
	}
	
	public function getUserById($id_user = null, $array = false) {
		
		if (!$id_user) {
			if (!$this->user) {
				return false;
			}
			$id_user = $this->user->id_user;
		}

		// eko
		$sql='SELECT * FROM {prefix_portal}users WHERE id_user = ?';
		$sql=$this->ubahPrefix($sql);
		// batas eko
		
		$query = $this->db->query($sql, [$id_user]);
		if ($array)
			return $query->getRowArray();
		
		return $query->getRow();
	}
	
	public function getUserSetting() {
		
		// eko
		$sql='SELECT * FROM {prefix_portal}setting_app_user WHERE id_user = ?';
		$sql=$this->ubahPrefix($sql);
		// batas eko

		$result = $this->db->query($sql, [$this->session->get('user')['ID_USER']])
						->getRow();
		
		if (!$result) {
			// eko
			$sql = 'SELECT * FROM {prefix_portal}setting_app_tampilan';
			$sql=$this->ubahPrefix($sql);
			// batas eko

			$query = $this->db->query($sql)
						->getResultArray();
			
			foreach ($query as $val) {
				$data[$val['PARAM']] = $val['VALUE'];
			}
			$result = new \StdClass;
			$result->param = json_encode($data);
		}
		return $result;
	}
	
	public function getAppLayoutSetting() {
		// eko
			$sql = 'SELECT * FROM {prefix_portal}setting_app_tampilan';
			$sql=$this->ubahPrefix($sql);
		// batas eko

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getDefaultUserModule() {
		// eko
			$sql = 'SELECT * 
							FROM {prefix_portal}role 
							LEFT JOIN {prefix_portal}module USING(id_module)
							WHERE id_role = ? ';
			$sql=$this->ubahPrefix($sql);
		// batas eko

		$query = $this->db->query($sql, $this->session->get('user')['ID_ROLE']
						)->getRow();
		return $query;
	}
	
	public function getModule($nama_module) {
		// eko
			$sql ='SELECT * FROM {prefix_portal}module WHERE nama_module = ?';
			$sql = $this->ubahPrefix($sql);
		// batas eko

		$result = $this->db->query($sql, [$nama_module])
						->getRowArray();
		return $result;
	}
	
	public function getMenu($aktif = 'all', $showAll = false, $current_module) {
	
		$result = [];
		$where = ' ';
		$where_aktif = '';
		if ($aktif != 'all') {
			$where_aktif = ' AND aktif = '.$aktif;
		}
		
		$role = '';
		if (!$showAll) {
			$role = ' AND id_role = ' . $_SESSION['user']['ID_ROLE'];
		}
		
		$sql = 'SELECT * FROM {prefix_portal}menu 
					LEFT JOIN {prefix_portal}menu_role USING (id_menu)
					LEFT JOIN {prefix_portal}module USING (id_module)
				WHERE 1 = 1 ' . $role
					. $where_aktif.' 
				ORDER BY urut';
		$sql = $this->ubahPrefix($sql);

		$menu_array = $this->db->query($sql)->getResultArray();
		
		$current_id = '';
		foreach ($menu_array as $val) 
		{
			
			$result[$val['ID_MENU']] = $val;
			$result[$val['ID_MENU']]['highlight'] = 0;
			$result[$val['ID_MENU']]['depth'] = 0;

			if ($current_module == $val['NAMA_MODULE']) {
				
				$current_id = $val['ID_MENU'];
				$result[$val['ID_MENU']]['highlight'] = 1;
			}
			
		}
		
		if ($current_id) {
			$this->menuCurrent($result, $current_id);
		}
		
		return $result;
		
	}
	
	private function menuCurrent( &$result, $current_id) 
	{
		$parent = $result[$current_id]['ID_PARENT'];

		$result[$parent]['highlight'] = 1; // Highlight menu parent
		if (@$result[$parent]['ID_PARENT']) {
			$this->menuCurrent($result, $parent);
		}
	}
	
	public function getModuleRole($id_module) {
		// eko
			$sql = 'SELECT * FROM {prefix_portal}module_role WHERE id_module = ? ';
			$sql=$this->ubahPrefix($sql);
		// batas eko

		 $result = $this->db->query($sql, $id_module)->getResultArray();
		 return $result;
	}

	public function validateFormToken($session_name = null, $post_name = 'form_token') {				

		$form_token = explode (':', $this->request->getPost($post_name));
		
		$form_selector = $form_token[0];
		$sess_token = $this->session->get('token');
		if ($session_name)
			$sess_token = $sess_token[$session_name];
	
		if (!key_exists($form_selector, $sess_token))
				return false;
		
		try {
			$equal = $this->auth->validateToken($sess_token[$form_selector], $form_token[1]);

			return $equal;
		} catch (\Exception $e) {
			return false;
		}
		
		return false;
	}
	
	public function checkUser($username) 
	{
		$sql = 'SELECT * FROM {prefix_portal}users WHERE username = ?';
		// $sql = "SELECT * FROM {prefix_portal}user WHERE lower(username) = lower('".$username."')";

		$sql=$this->ubahPrefix($sql);

		$query = $this->db->query($sql, [$username]);
		$result = $query->getRowArray();
		
		return $result;		
	}
	
	public function getSettingWeb() {
		$sql = 'SELECT * FROM {prefix_portal}setting_web';
		$sql=$this->ubahPrefix($sql);

		$query = $this->db->query($sql)->getResultArray();
		
		$settingWeb = new \stdClass();
		foreach($query as $val) {
			$settingWeb->{$val['PARAM']} = $val['VALUE'];
		}
		return $settingWeb;
	}
	
	public function checkLogin() 
	{
		if ($this->session->get('logged_in')) 
		{
			return true; 
		}
		
		helper('cookie');
		$cookie_login = get_cookie('jwd_remember');
	
		if ($cookie_login) 
		{
			list($selector, $cookie_token) = explode(':', $cookie_login);

			$sql = 'SELECT * 
					FROM token
					WHERE selector = ' . $this->db->escape($selector) . ' 
						AND expires > "' . date('Y-m-d H:i:s') . '"';				
			$db_token = $this->db->query($sql)->getRow();

			if ($db_token)
			{
				if ($db_token->expires >= date('Y-m-d H:i:s')) {
					if ($this->auth->validateToken($db_token->token, $cookie_token)) 
					{
						$id_user = preg_replace('/\D/', '', $db_token->param);
						$result = $this->getUserById($id_user, true);
						$this->session->set('user', $result);
						$this->session->set('logged_in', true);
						return true;
					}
				} else {
					redirect()->to('login/logout');
				}
			}
		}
	}


	// TAMBAHAN 24 NOV 2022

	public function check_DB_F_GS_CHECK_TRANS_DATE_N($tgl='', $module=''){

		$userOrganisasi=$this->session->get('userOrganisasi');
		$sql_security="CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('".$userOrganisasi['LOGINID']."', '".$userOrganisasi['PASSWORD']."', '".$userOrganisasi['COMPANYID']."', '".$userOrganisasi['COMPANYSITEID']."');";
		$this->db2->query($sql_security);

		try{
			$sql="SELECT GS_CHECK_TRANS_DATE_N('$tgl', '$module') STATUS FROM DUAL";
			$sql = $this->db2->query($sql)->getRowArray();
			$result= $sql['STATUS'];

		}catch (\Exception $e) {
			$result= '-1';
		}
		
		

		return $result;
	}

	// BATAS TAMBAHAN 24 NOV 2022


	// TAMBAHAN 30 MAY 2023

	public function getSCD_MA_PARAM($prnid='',$prmid=''){

		$w_prn = ' ';
		$w_prm = ' ';

		if($prnid != ''){
			$w_prn = " AND PRNID = '$prnid'";
		}

		if($prmid != ''){
			$w_prm = " AND PRMID = '$prmid'";
		}

		try{
			$sql="SELECT CRTTS, CRTBY, UPDTS, UPDBY, TRM, INACT, INACTBY, ORGID, ORG_CODE_PR, ORG_CODE, PRMID, PRNID, PRNDESC, VALNUM, VALSTR, SEQ FROM SCD_MA_PARAM WHERE ROWNUM > 0 $w_prn $w_prm";

			$result = $this->db->query($sql)->getResultArray();

		}catch (\Exception $e) {
			$result['status']= '0';
			$result['message']= 'SQL Error';
		}
		
		return $result;
	}

	// BATAS TAMBAHAN 30 MAY 2023
}