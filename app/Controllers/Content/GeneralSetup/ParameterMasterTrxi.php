<?php

namespace App\Controllers\Content\GeneralSetup;

use App\Models\Content\GeneralSetup\ParameterMasterTrxiModel;
use \Config\App;


class ParameterMasterTrxi extends \App\Controllers\BaseController
{
    protected $ParameterMasterTrxiModel;

	public function __construct()
	{

		parent::__construct();

		$this->ParameterMasterTrxiModel = new ParameterMasterTrxiModel;

		$this->data['site_title'] = 'ParameterMasterTrxi';
		$this->addStyle($this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/icon.css');
		// $this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/default/easyui.css');
		$this->addStyle($this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/bootstrap/easyui.css');
		$this->addStyle($this->config->baseURL . 'public/themes/modern/css/easyui-custom.css');
        
		$this->addJs($this->config->baseURL . 'public/vendors/overlayscrollbars/jquery.overlayScrollbars.min.js');
		$this->addJs($this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.min.js');
		$this->addJs($this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.easyui.min.js');
        
		$this->addJs($this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-groupview.js');
		$this->addJs($this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-detailview.js');
		$this->addJs($this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/datagrid-export-1.0.3/datagrid-export.js');
		$this->addJs($this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-edatagrid/jquery.edatagrid.js');
        
		$this->addJs($this->config->baseURL . 'public/themes/modern/js/easyui-custom.js');
        
		$this->addJs($this->config->baseURL . 'public/vendors/epms/js/epmsScriptHandling.js');
		
        helper(['cookie', 'form']);
	}

	public function index()
	{
		$this->cekHakAkses('READ_DATA');
		$data = $this->data;
		// berfungsi untuk nilai otorisasi berdasarkan role
		$data['auth_tambah'] = $this->actionUser['CREATE_DATA'];
		$data['auth_ubah'] = $this->actionUser['UPDATE_DATA'];
		$data['auth_hapus'] = $this->actionUser['DELETE_DATA'];
		// berfungsi untuk nilai otorisasi berdasarkan role

		$tinggiContent = 0;
		$data['tinggi_dg'] = '';
		$tinggiContent = $this->session->get('dg_height');
        $tinggiContent_1 = $tinggiContent * 0.1;
        $tinggiContent_2 = $tinggiContent * 0.2;
        $tinggiContent_3 = $tinggiContent * 0.3;
        $tinggiContent_4 = $tinggiContent * 0.4;
        $tinggiContent_5 = $tinggiContent * 0.5;
        $tinggiContent_6 = $tinggiContent * 0.6;
        $tinggiContent_7 = $tinggiContent * 0.7;
        $tinggiContent_8 = $tinggiContent * 0.8;
        $tinggiContent_9 = $tinggiContent * 0.9;
        $tinggiContent_11 = $tinggiContent * 1.1;

		if (intval($tinggiContent) > 0) {
			$data['tinggi_dg'] = 'height:' . $tinggiContent . 'px';
            $data['tinggi_dg_1'] = 'height:' . $tinggiContent_1 . 'px;';
            $data['tinggi_dg_2'] = 'height:' . $tinggiContent_2 . 'px;';
            $data['tinggi_dg_3'] = 'height:' . $tinggiContent_3 . 'px;';
            $data['tinggi_dg_4'] = 'height:' . $tinggiContent_4 . 'px;';
            $data['tinggi_dg_5'] = 'height:' . $tinggiContent_5 . 'px;';
            $data['tinggi_dg_6'] = 'height:' . $tinggiContent_6 . 'px;';
            $data['tinggi_dg_7'] = 'height:' . $tinggiContent_7 . 'px;';
            $data['tinggi_dg_8'] = 'height:' . $tinggiContent_8 . 'px;';
            $data['tinggi_dg_9'] = 'height:' . $tinggiContent_9 . 'px;';
            $data['tinggi_dg_11'] = 'height:' . $tinggiContent_11 . 'px;';
		}

		$this->view('Content/GeneralSetup/ParameterMasterTrxi/ParameterMasterTrxiView.php', $data);
	}

	public function dataList()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->ParameterMasterTrxiModel->getList());
	}
	
	public function getModuleList()
	{
		$this->cekHakAkses('READ_DATA');
        // $chacheUser=$this->user;
		echo json_encode($this->ParameterMasterTrxiModel->getModuleList());
	}

	
	public function editForm()
	{
		$this->cekHakAkses('UPDATE_DATA');
		$data = $this->data;

		$data['id'] = isset($_GET["id"]) ? strval($_GET["id"]) : '';

		$this->cekHakAkses('READ_DATA');
		$data = $this->data;

		$tinggiContent = 0;
		$data['tinggi_dg'] = '';
		$tinggiContent = $this->session->get('dg_height');
        $tinggiContent_1 = $tinggiContent * 0.1;
        $tinggiContent_2 = $tinggiContent * 0.2;
        $tinggiContent_3 = $tinggiContent * 0.3;
        $tinggiContent_4 = $tinggiContent * 0.4;
        $tinggiContent_5 = $tinggiContent * 0.5;
        $tinggiContent_6 = $tinggiContent * 0.6;
        $tinggiContent_7 = $tinggiContent * 0.7;
        $tinggiContent_8 = $tinggiContent * 0.8;
        $tinggiContent_9 = $tinggiContent * 0.9;
        $tinggiContent_11 = $tinggiContent * 1.1;

		if (intval($tinggiContent) > 0) {
			$data['tinggi_dg'] = 'height:' . $tinggiContent . 'px';
            $data['tinggi_dg_1'] = 'height:' . $tinggiContent_1 . 'px;';
            $data['tinggi_dg_2'] = 'height:' . $tinggiContent_2 . 'px;';
            $data['tinggi_dg_3'] = 'height:' . $tinggiContent_3 . 'px;';
            $data['tinggi_dg_4'] = 'height:' . $tinggiContent_4 . 'px;';
            $data['tinggi_dg_5'] = 'height:' . $tinggiContent_5 . 'px;';
            $data['tinggi_dg_6'] = 'height:' . $tinggiContent_6 . 'px;';
            $data['tinggi_dg_7'] = 'height:' . $tinggiContent_7 . 'px;';
            $data['tinggi_dg_8'] = 'height:' . $tinggiContent_8 . 'px;';
            $data['tinggi_dg_9'] = 'height:' . $tinggiContent_9 . 'px;';
            $data['tinggi_dg_11'] = 'height:' . $tinggiContent_11 . 'px;';
		}

		$data_parameter = $this->ParameterMasterTrxiModel->getHeaderById($_GET['id']);
		if (empty($data_parameter)) {
			$this->errorDataNotFound();
		}
		$data_details = $this->ParameterMasterTrxiModel->getDetailById($_GET['id']);
		$data = array_merge($data, $data_parameter);
		$data['data_details'] = $data_details;

		$this->view('Content/GeneralSetup/ParameterMasterTrxi/ParameterMasterTrxiEditForm.php', $data);
	}
	
	public function getDetailByIdForm()
	{
		$this->cekHakAkses('READ_DATA');
        // $chacheUser=$this->user;
		echo json_encode($this->ParameterMasterTrxiModel->getDetailByIdForm($_GET['id']));
	}

	public function updateData()
	{
		$this->cekHakAkses('UPDATE_DATA');
		$action = $this->ParameterMasterTrxiModel->updateData();
		$data_feedbacksave = array(
			"status" => $action['msg']['status'],
			"content" => $action['msg']['content'],
			"ID" => isset($action['msg']['ID']) ? strval($action['msg']['ID']) : ''  ,
		);
		echo json_encode($data_feedbacksave);
	}

    // BATAS PAKAI

	public function addForm()
	{
		$this->cekHakAkses('CREATE_DATA');
		$this->cekHakAkses('READ_DATA');
		$data = $this->data;

		$tinggiContent = 0;
		$data['tinggi_dg'] = '';
		$tinggiContent = $this->session->get('dg_height');

		if (intval($tinggiContent) > 0) {
			$data['tinggi_dg'] = 'height:' . $tinggiContent . 'px';
		}

		$this->view('Content/GeneralSetup/ParameterMasterTrxi/ParameterMasterTrxiAddForm.php', $data);
	}

	public function getUOM(){
		echo json_encode($this->ParameterMasterTrxiModel->getUOM());
	}

	public function saveData()
	{
		$this->cekHakAkses('CREATE_DATA');
		$action = $this->ParameterMasterTrxiModel->saveData();
		$data_feedbacksave = array(
			"status" => $action['msg']['status'],
			"content" => $action['msg']['content'],
			"ID" => isset($action['msg']['ID']) ? strval($action['msg']['ID']) : ''  ,
		);
		echo json_encode($data_feedbacksave);
	}
	
	public function deleteData()
	{
		$this->cekHakAkses('DELETE_DATA');
		
		echo json_encode($this->ParameterMasterTrxiModel->deleteData());
	}

	public function checkUniqueCode(){

		$id = $_REQUEST['PARAMETERCODE'];
		$data= $this->ParameterMasterTrxiModel->getParameterById($id);

		if(!empty($data)) {
			echo "false";
		} else {
			echo "true";
		}

	}

	
}
