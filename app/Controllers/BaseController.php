<?php 

namespace App\Controllers;

use App\Controllers\Base;
use App\Libraries\Auth;
use \Config\App;
use App\Models\BaseModel;

class BaseController extends Base
{
	protected $data;
	protected $config;
	protected $session;
	protected $request;
	protected $isLoggedIn;
	protected $auth;
	protected $user;
	protected $model;
	// protected $userOrganisasi;
	
	public $currentModule;
	private $controllerName;
	private $methodName;
	protected $actionUser;
	protected $queryString;
	protected $moduleURL;
	protected $moduleRole;
	protected $router;

	protected $moduleURLeko;

	protected $tipeLoginCompSite;
	protected $roleNoCompSite;
	
	public function __construct() 
	{
		parent::__construct();
		
		$this->model = new BaseModel;
		
		$this->data['scripts'] = [];
		$this->data['styles'] = [];
		
		$this->session = session();
		
		helper('util');
		
		// Attribute
		
		$router = service('router');
		$controller  = $router->controllerName();
		$exp  = explode('\\', $controller);
		
		if (strpos($controller, 'App\Controllers\Builtin') !== false) {
			
			$module_name = 'Builtin\\' . strtolower($exp[count($exp) - 1]);
			$this->moduleURL = $this->config->baseURL . 'builtin/' . strtolower($exp[count($exp) - 1]);

		}  else {
			
			$module_name = strtolower($exp[count($exp) - 1]);
			$this->moduleURL = $this->config->baseURL . $module_name;

			// ditambah eko karena kalau pake moduleURL bikin error too much redirect
			$cari = '\App\Controllers\\';
			$module_name_eko = str_replace('\\','/',ltrim($controller ,$cari));
			$this->moduleURLeko = $this->config->baseURL . $module_name_eko;
		}
	
		$this->methodName = $router->methodName();
		
		$this->isLoggedIn = $this->session->get('logged_in');

		if ($module_name !== 'login') {
			$this->mustLoggedIn();
		}
		
		$this->user = $this->session->get('user');	
		$this->data['config'] = $this->config;
		$this->data['module_url'] = $this->moduleURL;
		$this->data['title'] = 'TITLE';
		$this->data['request'] = $this->request;
		$this->data['isloggedin'] = $this->isLoggedIn;
		$this->data['session'] = $this->session;
		$this->data['site_title'] = '';
		$this->data['site_desc'] = '';

		// tambahan 24 nov 2022
		$this->data['nama_module'] = '';
		$this->data['url_module']='';
		
		$this->tipeLoginCompSite= $this->config->tipeLoginCompSite;	
		$this->roleNoCompSite= $this->config->roleNoCompSite;	

		if ($this->user)
			$this->data['user'] = $this->model->getSettingWeb();
		else
			$this->data['user'] = [];
		
		$this->data['auth'] = $this->auth;
		$this->data['settingWeb'] = $this->model->getSettingWeb();
		
		if ($this->session->get('user')) {
			$user_setting = $this->model->getUserSetting();
			if ($user_setting)
				$app_layout = json_decode($user_setting->param, true);
			
		} else {
			$query = $this->model->getAppLayoutSetting();
			foreach ($query as $val) {
				$app_layout[$val['PARAM']] = $val['VALUE'];
			}
		}
		
		$this->data['app_layout'] = $app_layout;
		
		
		// Module Detail
		$default_module = 'welcome';
		if ($this->isLoggedIn) 
		{
			$module_role = $this->model->getDefaultUserModule();
			$default_module = $module_role->NAMA_MODULE;
			
			$nama_module = $this->controllerName ?: $default_module;
			
			$exp  = explode('\\', $controller);			
			foreach ($exp as $key => $val) {
				
				if (!$val || strtolower($val) == 'app' || strtolower($val) == 'controllers')
					unset($exp[$key]);
				
			}
			
			// Dash tidak valid untuk nama class, sehingga jika ada dash di url maka otomatis akan diubah menjadi underscore, hal tersebut berpengaruh ke nama controller
			
			$nama_module = str_replace('_', '-', strtolower(join('/', $exp))); 
			
			// List action assigned to role
			$this->data['action_user'] = $this->actionUser;
			
			$module = $this->model->getModule($nama_module);
			$this->currentModule = $module;
			
			if (!$module) { 
				$this->setCurrentModule('error');
			}
			
			$this->data['current_module'] = $this->currentModule;
			
			if (!$module) {
				$this->data['status'] = 'error';
				$this->data['title'] = 'ERROR';
				$this->data['content'] = 'Module ' . $nama_module . ' tidak ditemukan di database';
				$this->viewError($this->data);
				exit();
			}

			$this->data['menu'] = $this->model->getMenu('all',false, $this->currentModule['NAMA_MODULE']);
			
			// Breadcrumb
			// $this->data['breadcrumb'] = ['Home' => $this->config->baseURL, $this->currentModule['judul_module'] => $this->moduleURL];

			//yang di atas diganti eko karena folder nya nyasar 
			$this->data['breadcrumb'] = ['Home' => $this->config->baseURL, $this->currentModule['JUDUL_MODULE'] => $this->config->baseURL.$this->currentModule['NAMA_MODULE']];
			//batas diganti eko karena folder nya nyasar

			$this->getModuleRole();
			$this->data['module_role'] = $module_role;
			$this->getListAction();
			
			// tambahan 24 nov 2022
			$this->data['nama_module'] = $this->currentModule['NAMA_MODULE'];
			$this->data['url_module'] = $this->config->baseURL.$this->currentModule['NAMA_MODULE'];
			
			if ($module_name == 'login') {
				$this->redirectOnLoggedIn();
			}
		}

	
		$this->model->checkLogin();

	}
	
	private function getModuleRole(){
		$query = $this->model->getModuleRole($this->currentModule['ID_MODULE']);
		$this->moduleRole = [];
		foreach ($query as $val) {
			$this->moduleRole[$val['ID_ROLE']] = $val;
		}
	}
	
	private function getListAction() 
	{
		
		$list_action = [];
		$id_role = $this->session->get('user')['ID_ROLE'];
		
		if ($this->isLoggedIn && $this->currentModule['NAMA_MODULE'] != 'login') {
			
			if ($this->moduleRole) {
				if (key_exists($id_role, $this->moduleRole)) {
					
					$this->actionUser = $this->moduleRole[$id_role];
				}
				if ($this->currentModule['NAMA_MODULE'] != 'login' ) {
					
					if (!key_exists($id_role, $this->moduleRole)) {
						$this->setCurrentModule('error');
						$this->data['title'] = 'Error';
						$this->data['msg']['status'] = 'error';
						$this->data['msg']['message'] = 'Anda tidak berhak mengakses halaman ini';
						$this->view('error.php', $this->data);
						
						exit();
					}
				}
			} else {
				$this->data['title'] = 'Error';
				$this->setCurrentModule('error');
				$this->data['msg']['status'] = 'error';
				$this->data['msg']['message'] = 'Role untuk module ini belum diatur'; 
				$this->view('error.php',$this->data);
				exit();
			}
		}
	}
	
	private function setCurrentModule($module) {
		$this->currentModule['nama_module'] = $module;
		// $this->data['nama_module']=$this->currentModule['NAMA_MODULE'];
	}
	
	protected function getControllerName() {
		return $this->controllerName;
	}
	
	protected function getMethodName() {
		return $this->methodName;
	}
	
	protected function addStyle($file) {
		$this->data['styles'][] = $file;
	}
	
	protected function addJs($file) {
		$this->data['scripts'][] = $file;
	}
	
	protected function viewError($data) {
		echo view('app_error.php', $data);
	}
	
	protected function view($file, $data = false, $file_only = false) 
	{
		// echo 'themes/modern/admin/' . $file;
		// diubah karena perubahan struktur di view
		// echo view('themes/modern/header.php', $data);
		// echo view('themes/modern/' . $file, $data);
		// echo view('themes/modern/footer.php');
		echo view('header.php', $data);
		echo view('' . $file, $data);
		echo view('footer.php');
		exit();
	}
	
	protected function loginRequired() {
		if (!$this->isLoggedIn) {
			redirect($this->config->baseURL . 'login');
		}
	}
	
	protected function redirectOnLoggedIn() {

		if ($this->isLoggedIn) {
			header('Location: ' . $this->config->baseURL . $this->data['module_role']->NAMA_MODULE);
		}
	}
	
	protected function mustNotLoggedIn() {
		if ($this->isLoggedIn) {	
			if ($this->currentModule['NAMA_MODULE'] == 'login') {
				header('Location: ' . $this->config->baseURL . $this->data['module_role']->NAMA_MODULE);
				exit();
			}
		}
	}
	
	protected function mustLoggedIn() {
		if (!$this->isLoggedIn) {
			header('Location: ' . $this->config->baseURL . 'login');
			exit();
		}
	}
	
	protected function cekHakAkses($action, $scope = '') {
	
		$allowed = $this->actionUser[$action];
		if ($scope) {
			if ($allowed != $scope) {
				$this->module->nama_module = 'error';
				$this->view('views/error.php', ['status' => 'error', 'message' => 'Anda tidak berhak mengakses halaman ini']);
			}
		}
		if ($allowed == 'no') { 
			// $this->module->nama_module = 'error';
			// load_view('views/error.php', ['status' => 'error', 'message' => 'Anda tidak berhak mengakses halaman ini']);
// diganti eko
			$this->setCurrentModule('error');
			$this->data['title'] = 'Error';
			$this->setCurrentModule('error');
			$this->data['msg']['status'] = 'error';
			$this->data['msg']['message'] = 'Anda tidak memiliki hak akses ke halaman ini'; 
			$this->view('error.php',$this->data);
			exit();
// batas penggantian eko
		}
	}
	
	protected function printError($message) {
		$this->data['title'] = 'Error...';
		$this->data['msg'] = $message;
		$this->view('error.php', $this->data);
		exit();
	}
	
	/* Used for modules when edited data not found */
	protected function errorDataNotFound($addData = null) {
		$data = $this->data;
		$data['title'] = 'Error';
		$data['msg']['status'] = 'error';
		$data['msg']['content'] = 'Data tidak ditemukan';
		
		if ($addData) {
			$data = array_merge($data, $addData);
		}
		$this->view('error-data-notfound.php', $data);
		exit;
	}

	// TAMBAHAN EKO UNTUK SIZE
	public function setSizeContentSession() 
	{
		$height_site_content = $this->request->getPost('height_site_content');
		$width_site_content = $this->request->getPost('width_site_content');
		$height_content = $this->request->getPost('height_content');
		$width_content = $this->request->getPost('width_content');
		$height_content_wrapper = $this->request->getPost('height_content_wrapper');
		$width_content_wrapper = $this->request->getPost('width_content_wrapper');
		$height_breadcrumb = $this->request->getPost('height_breadcrumb');
		$width_breadcrumb = $this->request->getPost('width_breadcrumb');
		$dg_height_t =  $height_site_content  - 10;
		// tanggal 09 nov 2022 dimatikan
		// $dg_height_t =  $height_site_content - $height_breadcrumb - 10;
		// DI TANGGAL 25 OKT 2022 DIGANTI HARDCODE 10 SAMA EKO
		// ($height_site_content * 0.02);
		
		$ress = 'noneedrefresh';
		if($this->session->get('dg_height') <= 0 )	{
			$ress = 'needrefresh';
			$this->session->set('dg_height', $dg_height_t);					
			$this->session->set('height_site_content', $height_site_content);
			$this->session->set('width_site_content', $width_site_content);
			$this->session->set('height_content', $height_content);
			$this->session->set('width_content', $width_content);
			$this->session->set('height_content_wrapper', $height_content_wrapper);
			$this->session->set('width_content_wrapper', $width_content_wrapper);
			$this->session->set('height_breadcrumb', $height_breadcrumb);
			$this->session->set('width_breadcrumb', $width_breadcrumb);
		}			
		
		echo $ress;
	}

	// BATAS TAMBAHAN EKO UNTUK SIZE

	// TAMBAHAN 24 NOV 2022

	public function check_DB_F_GS_CHECK_TRANS_DATE_N(){

		$tgl= isset($_POST["tgl"]) ?  date("d/M/Y", strtotime($_POST['tgl'])) : '';
		$module= isset($_POST["module"]) ? strval($_POST["module"]) : '';

		echo json_encode($this->model->check_DB_F_GS_CHECK_TRANS_DATE_N($tgl, $module));
	}
	// BATAS TAMBAHAN 24 NOV 2022

}