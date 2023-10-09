<?php
namespace App\Controllers\Builtin;
use App\Models\Builtin\UserModel;
use \Config\App;

class User extends \App\Controllers\BaseController
{
	protected $model;
	protected $moduleURL;
	protected $formValidation;
	
	public function __construct() {
		
		parent::__construct();
		
		$this->model = new UserModel;	
		$this->formValidation =  \Config\Services::validation();
		$this->data['site_title'] = 'Halaman Profil';
		
		$this->addJs($this->config->baseURL . 'public/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
		$this->addJs($this->config->baseURL . 'public/themes/modern/js/date-picker.js');
		$this->addJs($this->config->baseURL . 'public/themes/modern/builtin/js/user.js');
		$this->addStyle($this->config->baseURL . 'public/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css');
		
		helper(['cookie', 'form']);
	}
	
	public function index()
	{
		$this->cekHakAkses('READ_DATA');

		if ($this->request->getPost('delete')) 
		{
			$this->cekHakAkses('DELETE_DATA');
			
			$result = $this->model->deleteUser();
			if ($result) {
				$data['msg'] = ['status' => 'ok', 'message' => 'Data user berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'warning', 'message' => 'Tidak ada data yang dihapus'];
			}
		}
		$data['title'] = 'Data User';
		$data['users'] = $this->model->getListUsers($this->actionUser);
		
		if (!$data['users']) {
			$data['msg'] = ['status' => 'error', 'message' => 'Data user tidak ditemukan'];
		}
		
		$this->setData();
		$this->view('builtin/user/result.php', array_merge($data, $this->data));
	}
	
	public function getUserDT() {
		
		$this->cekHakAkses('READ_DATA');
		
		// $num_users = $this->model->countAllUsers();
		$param_search = isset($_POST['search']['value']) ? strval($_POST['search']['value']) : '';
		$num_users = $this->model->countListUsers($param_search);
		
		$result['draw'] = $start = $this->request->getPost('draw') ?: 1;
		$result['recordsTotal'] = $num_users;
		$result['recordsFiltered'] = $num_users;
		$query = $this->model->getListUsers($this->actionUser);
		
		helper('html');
		$avatar_path = ROOTPATH . 'public/images/user/';
		
		foreach ($query as $key => &$val) {
			
			if ($val['AVATAR']) {
				if (file_exists($avatar_path . $val['AVATAR'])) {
					$avatar = $val['AVATAR'];
				} else {
					$avatar = 'default.png';
				}
				
			} else {
				$avatar = 'default.png';
			}
			$val['AVATAR'] = '<img src="'. $this->config->baseURL . 'public/images/user/' . $avatar . '">';
								
			$btn['edit'] = ['url' => $this->moduleURL . '/edit?id='. $val['ID_USER']];
			// if ($this->actionUser['delete_data'] == 'own' || $this->actionUser['delete_data'] == 'all') {
			$btn['delete'] = ['url' => $this->moduleURL
											, 'id' =>  $val['ID_USER']
											, 'delete-title' => 'Hapus data user: <strong>'.$val['NAMA'].'</strong> ?'
										]
						;
			// }
			$val['ignore_btn_action'] = btn_action($btn);
		}
					
		$result['data'] = $query;
		echo json_encode($result); exit();
	}
	
	public function add() 
	{
		$this->cekHakAkses('CREATE_DATA');
		
		$breadcrumb['Add'] = '';
		
		$this->setData();
		$data = $this->data;
		$data['title'] = 'Tambah ' . $this->currentModule['JUDUL_MODULE'];
		$this->setData();
		$data['msg'] = [];
		
		// tambahan eko 17 mar 2022 u/ proses import data user dari epms
		$data['stat_EPMS']=$this->tipeLoginCompSite;
		//batas tambahan eko 17 mar 2022 u/ proses import data user dari epms
		
		$error = false;
		if ($this->request->getPost('submit'))
		{
			$save_msg = $this->saveData();
			$data = array_merge( $data, $save_msg);
		}
		
		$this->view('builtin/user/form-add.php', $data);
	}
	
	public function edit()
	{
		$this->cekHakAkses('UPDATE_DATA');
		$this->setData();
		$data = $this->data;
		$data['title'] = 'Edit ' . $this->currentModule['JUDUL_MODULE'];
		$breadcrumb['Edit'] = '';
			
		// Submit
		$data['msg'] = [];
		if ($this->request->getPost('submit')) 
		{
			$save_msg = $this->saveData();
			$data = array_merge( $data, $save_msg);
		}
		
		$result = $this->model->getUserById($this->request->getGet('id'), true);
		if (!$result) {
			$data['msg']['status'] = 'error';
			$data['msg']['message'] = 'Data user tidak ditemukan';
		} else {
			$data = array_merge($data, $result);
		}

		$this->view('builtin/user/form-edit.php', $data);
	}
	
	public function setData() {
		$this->data['role'] = $this->model->getRole();
	}
	
	private function saveData() 
	{		
		$form_errors = $this->validateForm();
		
		$error = false;		
		if ($form_errors) {
			$data['msg']['status'] = 'error';
			$data['form_errors'] = $form_errors;
			$data['msg']['message'] = $form_errors;
				$error = true;
		}
		
		if (!$error) {
				
			$save = $this->model->saveData($this->actionUser);
			if ($save['status'] == 'ok') {
				$data['msg']['status'] = 'ok';
				$data['msg']['message'] = 'Data berhasil disimpan';
			} else {
				$data['msg']['status'] = 'error';
				$data['msg']['message'] = $save['message'];
			}
		}
		
		return $data;
	}
	
	private function validateForm() { 
	
		$validation =  \Config\Services::validation();
		$validation->setRule('NAMA', 'NAMA', 'trim|required');
		$validation->setRule('EMAIL', 'EMAIL', 'trim|required');
		$validation->setRule('USERNAME', 'USERNAME', 'trim|required');
		$validation->setRule('ID_ROLE', 'ROLE', 'trim|required');
		
		if ($this->request->getPost('id')) {
			if ($this->request->getPost('EMAIL') != $this->request->getPost('EMAIL_LAMA')) {
				// echo 'sss'; die;
				if ($this->actionUser['UPDATE_DATA'] == 'all') 
				{
					$validation->setRules(
						['EMAIL' => [
								'label'  => 'Email',
								'rules'  => 'required|valid_email',
								'errors' => [
									'is_unique' => 'Email sudah digunakan'
									, 'valid_email' => 'Alamat email tidak valid'
								]
							]
						]
						
					);
				}
			}
		} else {
			$validation->setRule('PASSWORD', 'Password', 'trim|required|min_length[3]');
			$validation->setRules(
				['EMAIL' => [
						'label'  => 'Email',
						'rules'  => 'required|valid_email',
						'errors' => [
							'is_unique' => 'Email sudah digunakan'
							, 'valid_email' => 'Alamat email tidak valid'
						]
					],
					'ULANGI_PASSWORD' => [
						'label'  => 'Ulangi Password',
						'rules'  => 'required|matches[PASSWORD]',
						'errors' => [
							'required' => 'Ulangi password tidak boleh kosong'
							, 'matches' => 'Ulangi password tidak cocok dengan password'
						]
					]
				]
				
			);
		}
		
		$valid = $validation->withRequest($this->request)->run();
		$form_errors = $validation->getErrors();

		$file = $this->request->getFile('avatar');
		if ($file && $file->getName())
		{
			if ($file->isValid())
			{
				$type = $file->getMimeType();
				$allowed = ['image/png', 'image/jpeg', 'image/jpg'];
				
				if (!in_array($type, $allowed)) {
					$form_errors['avatar'] = 'Tipe file harus ' . join($allowed, [', ']);
				}
				
				if ($file->getSize() > 300 * 1024) {
					$form_errors['avatar'] = 'Ukuran file maksimal 300Kb';
				}
				
				$info = \Config\Services::image()
						->withFile($file->getTempName())
						->getFile()
						->getProperties(true);
				// echo '<pre>'; print_r($info);
				if ($info['height'] < 100 || $info['width'] < 100) {
					$form_errors['avatar'] = 'Dimensi file minimal: 100px x 100px';
				}
				
			} else {
				$form_errors['avatar'] = $file->getErrorString().'('.$file->getError().')';
			}
		}
		
		return $form_errors;
	}
	
	public function edit_password()
	{
		$form_errors = null;
		$this->data['status'] = '';
		
		if ($this->request->getPost('submit')) 
		{
			$result = $this->model->getUserById($this->user['ID_USER']);
			$error = false;
			
			if ($result) {
				
				if (!password_verify($this->request->getPost('password_old'), $result->PASSWORD)) {
					$error = true;
					$this->data['msg'] = ['status' => 'error', 'message' => 'Password lama tidak cocok'];
				}
			} else {
				$error = true;
				$this->data['msg'] = ['status' => 'error', 'message' => 'Data user tidak ditemukan'];
			}
		
			if (!$error) {
		
				$this->formValidation->setRule('password_new', 'Password', 'trim|required');
				$this->formValidation->setRule('password_new_confirm', 'Confirm Password', 'trim|required|matches[password_new]');
					
				$this->formValidation->withRequest($this->request)->run();
				$errors = $this->formValidation->getErrors();
				
				$custom_validation = new \App\Libraries\FormValidation;
				$custom_validation->checkPassword('password_new', $this->request->getPost('password_new'));
			
				$form_errors = array_merge($custom_validation->getErrors(), $errors);
					
				if ($form_errors) {
					$this->data['msg'] = ['status' => 'error', 'message' => $form_errors];
				} else {
					$update = $this->model->updatePassword();
					if ($update) {
						$this->data['msg'] = ['status' => 'ok', 'message' => 'Password Anda berhasil diupdate'];
					} else {
						$this->data['msg'] = ['status' => 'error', 'message' => 'Password Anda gagal diupdate... Mohon hubungi admin. Terima Kasih...'];
					}
				}
			}
		}
		
		$this->data['title'] = 'Edit Password';
		$this->data['form_errors'] = $form_errors;
		$this->data['user'] = $this->model->getUserById($this->user['ID_USER']);
		$this->view('builtin/user/form-edit-password.php', $this->data);
	}


	public function resetPassword()
	{
		$this->cekHakAkses('UPDATE_DATA');
		$this->setData();
		

		$form_errors = null;
		$this->data['status'] = '';
		
		if ($this->request->getPost('submit')) 
		{
			$result = $this->model->getUserById($_GET['id']);
			$error = false;
			
			if ($result) {				
				// if (!password_verify($this->request->getPost('password_old'), $result->PASSWORD)) {
				// 	$error = true;
				// 	$this->data['msg'] = ['status' => 'error', 'message' => 'Password lama tidak cocok'];
				// }
				$error = false;
			} else {
				$error = true;
				$this->data['msg'] = ['status' => 'error', 'message' => 'Data user tidak ditemukan'];
			}
		
			if (!$error) {
		
				$this->formValidation->setRule('password_new', 'Password', 'trim|required');
				$this->formValidation->setRule('password_new_confirm', 'Confirm Password', 'trim|required|matches[password_new]');
					
				$this->formValidation->withRequest($this->request)->run();
				$errors = $this->formValidation->getErrors();
				
				$custom_validation = new \App\Libraries\FormValidation;
				$custom_validation->checkPassword('password_new', $this->request->getPost('password_new'));
			
				$form_errors = array_merge($custom_validation->getErrors(), $errors);
					
				if ($form_errors) {
					$this->data['msg'] = ['status' => 'error', 'message' => $form_errors];
				} else {
					$update = $this->model->resetPasswordIndependent();
					if ($update) {
						$this->data['msg'] = ['status' => 'ok', 'message' => 'Password Anda berhasil diupdate'];
					} else {
						$this->data['msg'] = ['status' => 'error', 'message' => 'Password Anda gagal diupdate... Mohon hubungi admin. Terima Kasih...'];
					}
				}
			}
		}
		
		$this->data['title'] = 'Edit Password';
		$this->data['form_errors'] = $form_errors;
		$this->data['user'] = $this->model->getUserById($_GET['id']);
		$this->view('builtin/user/form-reset-password.php', $this->data);
	}
}
