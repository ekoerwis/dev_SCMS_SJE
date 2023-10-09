<?php

namespace App\Controllers;
use App\Models\Builtin\LoginModel;
use \Config\App;

class Login extends \App\Controllers\BaseController
{
	protected $model = '';
	
	public function __construct() {
		parent::__construct();
		$this->model = new LoginModel;	
		$this->data['site_title'] = 'Login ke akun Anda';

		helper(['cookie', 'form']);
		
	}
	
	public function index()
	{
		
		$this->mustNotLoggedIn();
		$this->data['status'] = '';

		// $siteparameter='test';
		$this->data['tipeLoginCompSite']=$this->tipeLoginCompSite;
		$this->data['roleNoCompSite']=$this->roleNoCompSite;

		if ($this->request->getPost('password')) {
			
			$this->login();
			if ($this->session->get('logged_in')) {
				return redirect()->back();
			}
		}
		
		echo view('builtin/login-page', $this->data);
	}
	
	private function login()
	{
		// Check Token
		$sess_index = $this->request->getPost('login_form_header') ? 'login_form_token_header' : 'login_form_token';
		if (!$this->auth->validateFormToken($sess_index))
		{
			$this->data['status'] = 'error';
			$this->data['message'] = 'Token tidak ditemukan, silakan submit ulang form dengan mengklik tombol Submit';
			return;
		}
		
		$error = false;
		$result = $this->model->checkUser($this->request->getPost('username'));
		
		if ($result) {
			if (!password_verify($this->request->getPost('password'), $result['PASSWORD'])) {
			
				$error = true;
			}
			
		} else {
			$error = true;
		}
		
		if ($error)
		{
			$this->data['status'] = 'error';
			$this->data['message'] = 'Email dan Password tidak cocok';
			return;
		}
		
		if ($this->request->getPost('remember')) 
		{
			// $expired_time = 3600*24*30; // 1 month
			$expired_time = 60*5; // 1 month
			$param = ['param' => 'remember=' . $result['id_user']
						, 'expires' => date('Y-m-d H:i:s', time() + $expired_time)
					];
					
			$token = $this->model->generateDbToken($param);
			
			//set_cookie('jwd_remember', $token->selector . ':' . $token->external, time() + $expired_time, '', '/');
			setcookie('jwd_remember', $token->selector . ':' . $token->external, time() + $expired_time, '/');
		}

		// PENAMBAHAN COMP ID DAN SITEID SESSION
		$userOrganisasi['LOGINID'] = '';
		$userOrganisasi['PASSWORD'] = '';
		$userOrganisasi['COMPANYID'] = '';
		$userOrganisasi['COMPANYNAME'] = '';
		$userOrganisasi['COMPANYSITEID'] = '';
		$userOrganisasi['COMPANYSITENAME'] = '';
		if($this->tipeLoginCompSite){
			// $userOrganisasi['COMPANYID'] = $this->request->getPost('COMPANYID');
			// $userOrganisasi['COMPANYSITEID'] = $this->request->getPost('COMPANYSITEID');
			$username = $this->request->getPost('username');
			$companyid=$this->request->getPost('COMPANYID');
			$companysiteid = $this->request->getPost('COMPANYSITEID');
			$CompanySiteInfo = $this->model->getCompanySiteInfo($username,$companyid,$companysiteid);

			if($CompanySiteInfo){
				$userOrganisasi['LOGINID'] = $CompanySiteInfo['LOGINID'];
				$userOrganisasi['PASSWORD'] = $CompanySiteInfo['PASSWORD'];
				$userOrganisasi['COMPANYID'] = $CompanySiteInfo['COMPANYID'];
				$userOrganisasi['COMPANYNAME'] = $CompanySiteInfo['COMPANYNAME'];
				$userOrganisasi['COMPANYSITEID'] = $CompanySiteInfo['COMPANYSITEID'];
				$userOrganisasi['COMPANYSITENAME'] = $CompanySiteInfo['COMPANYSITENAME'];
			}
			
			
		}
		$this->session->set('userOrganisasi', $userOrganisasi);
		// BATAS PENAMBAHAN COMPID DAN COMPANYSITEID
		
		$this->session->set('user', $result);
		$this->session->set('logged_in', true);
		$this->model->recordLogin();
	}
	
	public function refreshLoginData() 
	{
		$email = $this->session->get('user')['email'];
		$result = $this->model->checkUser($email);
		$this->session->set('user', $result);
	}
	
	public function logout() 
	{
		$this->session->destroy();
		setcookie('jwd_remember', '', -1, '/');
		return redirect()->to($this->config->baseURL . 'login');
	}

	public function getCompID() 
	{
		$username = $this->request->getPost('username');

		$optioncompid = $this->model->getCompID($username);

		echo json_encode($optioncompid);
	}

	public function getCompanySiteID() 
	{
		$username = $this->request->getPost('username');
		$companyid = $this->request->getPost('companyid');

		// $username = $_GET['username'];
		// $companyid = $_GET['companyid'];

		$optioncompsiteid = $this->model->getCompanySiteID($username,$companyid);

		// echo $username.'-'.$companyid.'<br>';
		// echo dd($optioncompsiteid);
		echo json_encode($optioncompsiteid);
	}

	// tambahan untuk set required comp site login
	public function getAttrCompanySite() 
	{
		$username = $this->request->getPost('username');

		$data = $this->model->getRoleUsername($username);

		$statReq = 'true';

		if(!empty($data)){
			if(in_array(intval($data['ID_ROLE']),$this->roleNoCompSite)){
				$statReq = 'false';
			}
		}		

		$attr['requiredStat']=$statReq;

		echo json_encode($attr);
		
	}
}
