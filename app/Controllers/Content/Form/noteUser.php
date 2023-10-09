<?php

namespace App\Controllers\Content\Form;

use App\Models\Content\Form\noteUserModel;
use \Config\App;


class noteUser extends \App\Controllers\BaseController
{
    protected $noteUserModel;

	public function __construct()
	{

		parent::__construct();

		$this->noteUserModel = new noteUserModel;

		$this->data['site_title'] = 'noteUser';
        

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

		// $data['RANGEPERIOD'] = isset($_GET["RANGEPERIOD"]) ? strval($_GET["RANGEPERIOD"]) : '';
		// $data['PERIODCODE'] = isset($_GET["PERIODCODE"]) ? strval($_GET["PERIODCODE"]) : '';
		// $data['PERIODID'] = isset($_GET["PERIODID"]) ? strval($_GET["PERIODID"]) : '';

		$tinggiContent = 0;
		$data['tinggi_dg'] = '';
		$tinggiContent = $this->session->get('dg_height');

		if (intval($tinggiContent) > 0) {
			$data['tinggi_dg'] = 'height:' . $tinggiContent . 'px';
		}

		$this->view('Content/Form/noteUser/noteUserList.php', $data);
	}

	public function dataList()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getList());
	}


	public function addForm()
	{
		$this->cekHakAkses('CREATE_DATA');
		$this->cekHakAkses('READ_DATA');
		$data = $this->data;

        $data['user_data']=$this->user;
		$tinggiContent = 0;
		$data['tinggi_dg'] = '';
		$tinggiContent = $this->session->get('dg_height');

		if (intval($tinggiContent) > 0) {
			$data['tinggi_dg'] = 'height:' . $tinggiContent . 'px';
		}

		$this->view('Content/Form/noteUser/noteUserAddForm.php', $data);
	}

	public function saveData()
	{

		$this->cekHakAkses('CREATE_DATA');
		$action = $this->noteUserModel->saveData();
		$data_feedbacksave = array(
			"status" => $action['msg']['status'],
			"content" => $action['msg']['content'],
			"ID" => isset($action['msg']['ID']) ? strval($action['msg']['ID']) : ''  ,
		);
		echo json_encode($data_feedbacksave);
		// echo json_encode($action);
	}

    
    // BATAS PAKAI
	
	// public function editForm()
	// {
	// 	$this->cekHakAkses('UPDATE_DATA');
	// 	$data = $this->data;

	// 	$data['id'] = isset($_GET["id"]) ? strval($_GET["id"]) : '';

	// 	$tinggiContent = 0;
	// 	$data['tinggi_dg'] = '';
	// 	$tinggiContent = $this->session->get('dg_height');

	// 	if (intval($tinggiContent) > 0) {
	// 		$data['tinggi_dg'] = 'height:' . $tinggiContent . 'px';
	// 	}

	// 	$data_parameter = $this->noteUserModel->getDataHeader();
	// 	$data['data_header'] = $data_parameter;
	// 	if (empty($data_parameter)) {
	// 		$this->errorDataNotFound();
	// 	}

	// 	$this->view('Content/Portal/noteUser/noteUserEditForm.php', $data);
	// }

	// public function updateData()
	// {
	// 	$this->cekHakAkses('UPDATE_DATA');
	// 	$action = $this->noteUserModel->updateData();
	// 	$data_feedbacksave = array(
	// 		"status" => $action['msg']['status'],
	// 		"content" => $action['msg']['content'],
	// 		"ID" => isset($action['msg']['ID']) ? strval($action['msg']['ID']) : ''  ,
	// 	);
	// 	echo json_encode($data_feedbacksave);
	// }
	
	// public function deleteData()
	// {
	// 	$this->cekHakAkses('DELETE_DATA');
		
	// 	echo json_encode($this->noteUserModel->deleteData());
	// }


	
	public function getCgBank()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getCgBank());
	}

	public function getOpeningBalance()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getOpeningBalance());
	}
	
	public function getCbPaymentType()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getCbPaymentType());
	}
	
	public function getCbVoucherType()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getCbVoucherType());
	}
	
	public function getCgSuppCont()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getCgSuppCont());
	}
	
	public function getCgPaymentToBank()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getCgPaymentToBank());
	}
	
	public function getCbProcessFlag()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getCbProcessFlag());
	}

	public function getDetailByHeader()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getRVDetailPerNo());
	}

	public function getCgLocType()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getCgLocType());
	}

	public function getCgLocCode()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getCgLocCode());
	}

	public function getCgJobCode()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getCgJobCode());
	}

	public function getCgCashFlow()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getCgCashFlow());
	}

	public function getCgReference()
	{
		$this->cekHakAkses('READ_DATA');
		echo json_encode($this->noteUserModel->getCgReference());
	}


	

	
}
