<?php

namespace App\Models\Builtin;

class LoginModel extends \App\Models\BaseModel
{	

	public function __construct() {
		parent::__construct();
		// helper('stringSQLrep');
		$this->db2 = db_connect('dbapps');	
	}
	
	public function recordLogin() 
	{
		$username = $this->request->getPost('username'); 
		$sql='SELECT id_user 
									FROM {prefix_portal}users
									LEFT JOIN {prefix_portal}role USING (id_role)
									LEFT JOIN {prefix_portal}module USING (id_module)
									WHERE username = ?';
		$sql=$this->ubahPrefix($sql);
		$data_user = $this->db->query($sql, [$username])
							->getRow();
		// echo '<pre>'; print_r($data_user->id_user); die;	
		date_default_timezone_set("Asia/Bangkok");

		// $data = array('ID_USER' => $data_user->ID_USER
		// 			, 'ID_ACTIVITY' => 1
		// 			, 'TIME' =>  'TO_DATE('.date("d/M/Y H:i:s").', \'DD/MM/YYYY HH24:MI:SS\')'
		// 		);
		
		//$db      = \Config\Database::connect();		
		//$db->table('user_login_activity')->insert($data);
		
		$tablename='{prefix_portal}USER_LOGIN_ACTIVITY';
		$tablename=$this->ubahPrefix($tablename);
		// $this->db->table($tablename)->insert($data);

		$sqlinsert = 'INSERT INTO '.$tablename.'(ID_USER,ID_ACTIVITY,TIME) VALUES ('.$data_user->ID_USER.',1,TO_DATE(\''.date("d/M/Y H:i:s").'\', \'DD/MM/YYYY HH24:MI:SS\'))';
		$this->db->query($sqlinsert);

		// $this->db->table('user_login_activity')->insert($data);
	}


	public function getCompID($username) 
	{
		$sql = 'SELECT A.LOGINID, A.COMPANYID, B.COMPANYNAME FROM USERCOMPANY A, COMPANY B WHERE A.COMPANYID = B.COMPANYID AND A.LOGINID = \''.$username.'\'';

		$result = $this->db2->query($sql)->getResultArray();
		return $result;
	} 
	
	public function getCompanySiteID($username,$companyid) 
	{
		$sql = 'SELECT A.LOGINID, A.COMPANYID, A.COMPANYSITEID, B.COMPANYSITENAME FROM USERCOMPANYSITE A, COMPANYSITE B WHERE A.COMPANYSITEID = B.COMPANYSITEID AND A.COMPANYID=B.COMPANYID AND A.LOGINID = \''.$username.'\' AND A.COMPANYID =  \''.$companyid.'\' ORDER BY LOGINID, COMPANYID, COMPANYSITEID';

		$result = $this->db2->query($sql)->getResultArray();
		return $result;
	} 

	public function getCompanySiteInfo($username,$companyid,$companysiteid) 
	{
		$sql = 'SELECT A.LOGINID, A.PASSWORD, B.COMPANYID, C.COMPANYNAME, D.COMPANYSITEID, E.COMPANYSITENAME FROM USERPROFILE A, USERCOMPANY B, COMPANY C, USERCOMPANYSITE D, COMPANYSITE E WHERE A.LOGINID=B.LOGINID AND B.COMPANYID=C.COMPANYID AND A.LOGINID=D.LOGINID AND D.COMPANYSITEID = E.COMPANYSITEID AND B.LOGINID = D.LOGINID AND B.COMPANYID=D.COMPANYID AND A.LOGINID = \''.$username.'\' AND B.COMPANYID =  \''.$companyid.'\' AND D.COMPANYSITEID =  \''.$companysiteid.'\' ORDER BY LOGINID, COMPANYID, COMPANYSITEID';

		$result = $this->db2->query($sql)->getRowArray();
		return $result;
	}

	// tambahan untuk set required comp site login
	public function getRoleUsername($username) 
	{
		$sql = "SELECT ID_USER, USERNAME, NAMA, ID_ROLE FROM USERS WHERE USERNAME ='$username' ";

		$result = $this->db->query($sql)->getRowArray();
		return $result;
	}
	/* See base model
	public function checkUser($username) 
	{
		
	} */
}
?>