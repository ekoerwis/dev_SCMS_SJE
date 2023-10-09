<?php

namespace App\Controllers\Builtin;
use App\Models\Builtin\UserModel;
use \Config\App;

class EditPassword extends \App\Controllers\BaseController
{
	protected $model;
	protected $moduleURL;
	
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

		$this->cekHakAkses('UPDATE_DATA');

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
					$form_errors['avatar'] = 'Tipe file harus ' . join($allowed, ', ');
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
	
	
}
