<?php

namespace App\Controllers\Content\Approval;
use App\Models\Content\Approval\MasterContentTableModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;



class MasterContentTable extends \App\Controllers\BaseController
{
    public $MasterContentTableModel;

	public function __construct() {

		parent::__construct();
		
		$this->MasterContentTableModel = new MasterContentTableModel;

		$this->data['site_title'] = 'LogSheet Approval';

		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/icon.css');
		// $this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/default/easyui.css');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/bootstrap/easyui.css');
		$this->addStyle ( $this->config->baseURL . 'public/themes/modern/css/easyui-custom.css');

		$this->addJs ( $this->config->baseURL . 'public/vendors/overlayscrollbars/jquery.overlayScrollbars.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.easyui.min.js');

		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-detailview.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-groupview.js');
        // $this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/datagrid-export-1.0.3/datagrid-export.js');

		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/easyui-custom.js');
		// tambahan untuk client paging
        $this->addJs($this->config->baseURL . 'public/themes/modern/js/easyui-dg-client-pagination-custom.js');
		
		helper(['cookie', 'form', 'stringSQLrep', 'mpdfCustom']);
        
	}

	public function index(){
		$this->cekHakAkses('READ_DATA');
		$data = $this->data;

        // $agent = $this->request->getUserAgent();

		// berfungsi untuk nilai otorisasi berdasarkan role
		$data['auth_tambah']=$this->actionUser['CREATE_DATA'];
		$data['auth_ubah']=$this->actionUser['UPDATE_DATA'];
		$data['auth_hapus']=$this->actionUser['DELETE_DATA'];

		$tinggiContent = 0;
		$data['tinggi_dg']='';
		$tinggiContent = $this->session->get('dg_height');
		
		if(intval($tinggiContent) > 0) {
			$data['tinggi_dg']= 'height:'.$tinggiContent.'px';
		}


		$this->view('Content/Approval/MasterContentTable/MasterContentTableListView.php', $data);

	}

    
    public function dataList(){
        $this->cekHakAkses('READ_DATA');
		
		echo json_encode($this->MasterContentTableModel->dataList());        
	}
    

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

		$this->view('Content/Approval/MasterContentTable/MasterContentTableAddForm.php', $data);
	}
    
    public function getCbModule(){
        $this->cekHakAkses('READ_DATA');
		
		echo json_encode($this->MasterContentTableModel->getCbModule());        
	}
    
    public function getCbTableContent(){
        $this->cekHakAkses('READ_DATA');
		
		echo json_encode($this->MasterContentTableModel->getCbTableContent());        
	}

	public function saveData()
	{
		$this->cekHakAkses('CREATE_DATA');
		$action = $this->MasterContentTableModel->saveData($this->user);
		$data_feedbacksave = array(
			"status" => $action['msg']['status'],
			"content" => $action['msg']['content'],
			"UNIQUEID" => isset($action['msg']['UNIQUEID']) ? strval($action['msg']['UNIQUEID']) : ''  ,
		);
		echo json_encode($data_feedbacksave);
	}

    
	
	public function deleteData()
	{
		$this->cekHakAkses('DELETE_DATA');
		
		echo json_encode($this->MasterContentTableModel->deleteData());
	}




	// batas pakai


}
