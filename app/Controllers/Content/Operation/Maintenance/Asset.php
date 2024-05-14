<?php
namespace App\Controllers\Content\Operation\Maintenance;
use App\Models\Content\Operation\Maintenance\AssetModel;

use \Config\App;

class Asset extends \App\Controllers\BaseController
{
	public function __construct() {

		parent::__construct();

		$this->model = new AssetModel;

		$this->data['site_title'] = 'Asset';

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

	public function getAssetMasterLocation(){echo json_encode($this->model->getAssetMasterLocation());}
	public function getAssetMaster(){echo json_encode($this->model->getAssetMaster());}
	public function getFaFixedAsset(){echo json_encode($this->model->getFaFixedAsset());}
	public function getSupplier(){echo json_encode($this->model->getSupplier());}

	public function getAssetLocation(){echo json_encode($this->model->getAssetLocation());}
	public function getLocationType(){echo json_encode($this->model->getLocationType());}

	public function getAssetMaintenanceGroup(){echo json_encode($this->model->getAssetMaintenanceGroup());}
	public function getFaGroup(){echo json_encode($this->model->getFaGroup());}

	public function getAssetMasterById(){echo json_encode($this->model->getAssetMasterById($_GET['id']));}

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
		$this->view('Content/Operation/Maintenance/Asset/ListForm.php', $data);
	}

	public function saveMaster(){
		$action = $this->model->saveMaster();
		$data_feedbacksave = array(
			"status" => $action['msg']['status'],
			"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function updateMaster(){
		$action = $this->model->updateMaster();
		$data_feedbacksave = array(	"status" => $action['msg']['status'],
		"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function deleteMaster(){
		echo json_encode($this->model->deleteMaster());
	}

	public function saveLocation(){
		$action = $this->model->saveLocation();
		$data_feedbacksave = array(
			"status" => $action['msg']['status'],
			"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function updateLocation(){
		$action = $this->model->updateLocation();
		$data_feedbacksave = array(	"status" => $action['msg']['status'],
		"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function deleteLocation(){
		echo json_encode($this->model->deleteLocation());
	}

	public function saveMaintenanceGroup(){
		$action = $this->model->saveMaintenanceGroup();
		$data_feedbacksave = array(
			"status" => $action['msg']['status'],
			"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function updateMaintenanceGroup(){
		$action = $this->model->updateMaintenanceGroup();
		$data_feedbacksave = array(	"status" => $action['msg']['status'],
		"content" => $action['msg']['content']);
		echo json_encode($data_feedbacksave);
	}

	public function deleteMaintenanceGroup(){
		echo json_encode($this->model->deleteMaintenanceGroup());
	}
//---------------------------------------------------------
	public function checkAssetMaster(){
		$id = $_REQUEST['q'];
		$data= $this->model->getAssetMasterById($id);
		if(!empty($data)) {
			echo "false";
		} else {
			echo "true";
		}
	}

	public function checkLocation(){
		$id = $_REQUEST['q'];
		$data= $this->model->getAssetLocationById($id);
		if(!empty($data)) {
			echo "false";
		} else {
			echo "true";
		}
	}

	public function checkMaintenanceGroup(){
		$id = $_REQUEST['q'];
		$data= $this->model->getAssetMaintenanceGroupById($id);
		if(!empty($data)) {
			echo "false";
		} else {
			echo "true";
		}
	}

}
