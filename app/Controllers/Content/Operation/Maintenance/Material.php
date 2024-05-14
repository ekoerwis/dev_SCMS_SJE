<?php
namespace App\Controllers\Content\Operation\Maintenance;
use App\Models\Content\Operation\Maintenance\MaterialModel;

use \Config\App;

class Material extends \App\Controllers\BaseController
{
	public function __construct() {

		parent::__construct();

		$this->model = new MaterialModel;

		$this->data['site_title'] = 'Material';

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

	public function getMaterialList(){echo json_encode($this->model->getMaterialList());}
	public function getUOM(){echo json_encode($this->model->getUOM());}
	public function getMaterialGroup(){echo json_encode($this->model->getMaterialGroup());}

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
		$this->view('Content/Operation/Maintenance/Material/ListForm.php', $data);
	}

	public function saveMaterial(){
		$action = $this->model->saveMaterial();
		$data_feedbacksave = array(
			"status" => $action['msg']['status'],
			"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function updateMaterial(){
		$action = $this->model->updateMaterial();
		$data_feedbacksave = array(	"status" => $action['msg']['status'],
		"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function deleteMaterial(){
		echo json_encode($this->model->deleteMaterial());
	}

	public function saveMaterialGroup(){
		$action = $this->model->saveMaterialGroup();
		$data_feedbacksave = array(
			"status" => $action['msg']['status'],
			"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function updateMaterialGroup(){
		$action = $this->model->updateMaterialGroup();
		$data_feedbacksave = array(	"status" => $action['msg']['status'],
		"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function deleteMaterialGroup(){
		echo json_encode($this->model->deleteMaterialGroup());
	}

//---------------------------------------------------------
	public function checkUniqueMaterial(){
		$id = $_REQUEST['q'];
		$data= $this->model->getMaterialById($id);
		if(!empty($data)) {
			echo "false";
		} else {
			echo "true";
		}
	}

	public function checkUniqueMaterialGroup(){
		$id = $_REQUEST['q'];
		$data= $this->model->getMaterialGroupById($id);
		if(!empty($data)) {
			echo "false";
		} else {
			echo "true";
		}
	}

}
