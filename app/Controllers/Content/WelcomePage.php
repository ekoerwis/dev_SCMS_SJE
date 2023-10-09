<?php

namespace App\Controllers\Content;
use \Config\App;

class WelcomePage extends \App\Controllers\BaseController
{
	public function __construct() {

		parent::__construct();
		// $this->mustLoggedIn();

		$this->data['site_title'] = 'Welcome Page';

		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/icon.css');
		// $this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/default/easyui.css');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/bootstrap/easyui.css');
		$this->addStyle ( $this->config->baseURL . 'public/themes/modern/css/easyui-custom.css');

		$this->addJs ( $this->config->baseURL . 'public/vendors/overlayscrollbars/jquery.overlayScrollbars.min.js');
		
		helper(['cookie', 'form']);
	}

	public function index()
	{
		$this->cekHakAkses('READ_DATA');
		$data = $this->data;

		// berfungsi untuk nilai otorisasi berdasarkan role
		$data['auth_tambah']=$this->actionUser['CREATE_DATA'];
		$data['auth_ubah']=$this->actionUser['UPDATE_DATA'];
		$data['auth_hapus']=$this->actionUser['DELETE_DATA'];
		// berfungsi untuk nilai otorisasi berdasarkan role

		// $data['result'] = $this->model->getActivity();
		$this->view('Content/WelcomePage/WelcomePageView.php', $data);
	}


}
