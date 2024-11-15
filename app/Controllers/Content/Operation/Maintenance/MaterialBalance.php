<?php
namespace App\Controllers\Content\Operation\Maintenance;
use App\Models\Content\Operation\Maintenance\MaterialBalanceModel;

use \Config\App;

class MaterialBalance extends \App\Controllers\BaseController
{
	public function __construct() {

		parent::__construct();

		$this->model = new MaterialBalanceModel;

		$this->data['site_title'] = 'MaterialBalance';

		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/icon.css');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/bootstrap/easyui.css');
		$this->addStyle ( $this->config->baseURL . 'public/themes/modern/css/easyui-custom.css');

		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.easyui.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-detailview.js');

    $this->addJs ( $this->config->baseURL . 'public/vendors/epms/js/epmsScriptHandling.js');
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/easyui-custom.js');
		helper(['cookie', 'form']);
	}

	public function getMaterialBalance(){echo json_encode($this->model->getMaterialBalance());}
	public function getParentNode(){echo json_encode($this->model->getParentNode());}

	public function index(){
		$this->cekHakAkses('READ_DATA');
		$data = $this->data;
		// tambahan : berfungsi untuk nilai otorisasi berdasarkan role
		$data['auth_tambah']=$this->actionUser['CREATE_DATA'];
		$data['auth_ubah']=$this->actionUser['UPDATE_DATA'];
		$data['auth_hapus']=$this->actionUser['DELETE_DATA'];
		// batas tambahan  : berfungsi untuk nilai otorisasi berdasarkan role
		$tinggiContent = 0;
		$data['tinggi_dg']='';
		$tinggiContent = $this->session->get('dg_height')*0.87;
		if(intval($tinggiContent) > 0) {
			$data['tinggi_dg']= 'height:'.$tinggiContent.'px';
		}
		$this->view('Content/Operation/Maintenance/MaterialBalance/MaterialBalanceView.php', $data);
	}

	public function saveData(){
		$action = $this->model->saveData();
		$data_feedbacksave = array(
			"status" => $action['msg']['status'],
			"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function updateData(){
		$action = $this->model->updateData();
		$data_feedbacksave = array(	"status" => $action['msg']['status'],
		"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function deleteData(){
		echo json_encode($this->model->deleteData());
	}


}
