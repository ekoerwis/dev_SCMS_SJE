<?php

namespace App\Controllers\Content\Approval;
use App\Models\Content\Approval\ApprovalListLogsheetModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;



class ApprovalListLogsheet extends \App\Controllers\BaseController
{
    public $ApprovalListLogsheetModel;

	public function __construct() {

		parent::__construct();
		
		$this->ApprovalListLogsheetModel = new ApprovalListLogsheetModel;

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

        // $data['srcView'] = 'https://10.20.38.95:6063/';

		// echo "<script>console.log('".json_encode($this->user)."')</script>";

		$this->view('Content/Approval/ApprovalListLogsheet/ApprovalListLogsheetView.php', $data);


        // echo "
        // <script>
        // window.open('https://google.com/?', '_blank');
        // </script>
        // ";
        
        // if ($agent->isReferral()) {
        //     echo $agent->referrer();
        // }
	}

    
    public function dataList(){
        $this->cekHakAkses('READ_DATA');
		
		echo json_encode($this->ApprovalListLogsheetModel->dataList($this->user));        
	}

	public function goToNeedActionPage(){
		$this->cekHakAkses('READ_DATA');
		$data = $this->data;

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

		$data['MONTHNUMBER']=isset($_GET['MONTHNUMBER']) ? intval($_GET['MONTHNUMBER']) : 0;
		$data['YEARNUMBER']=isset($_GET['YEARNUMBER']) ? intval($_GET['YEARNUMBER']) : 0;
		$data['IDMODULE']=isset($_GET['IDMODULE']) ? intval($_GET['IDMODULE']) : 0;

		$data['JUDULMODULELS']=$this->ApprovalListLogsheetModel->getModuleLS($data['IDMODULE'])['JUDUL_MODULE'];

		$this->view('Content/Approval/ApprovalListLogsheet/NeedActionPageView.php', $data);

	}

	public function dataListNeedAction(){
        $this->cekHakAkses('READ_DATA');

		echo json_encode($this->ApprovalListLogsheetModel->dataListNeedAction($this->user));        
	}

	public function actionApprove()
	{
		$this->cekHakAkses('CREATE_DATA');
		$this->cekHakAkses('UPDATE_DATA');
		
		echo json_encode($this->ApprovalListLogsheetModel->actionApprove($this->user));
	}

	public function goToStatusPage(){
		$this->cekHakAkses('READ_DATA');
		$data = $this->data;

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

		$data['MONTHNUMBER']=isset($_GET['MONTHNUMBER']) ? intval($_GET['MONTHNUMBER']) : 0;
		$data['YEARNUMBER']=isset($_GET['YEARNUMBER']) ? intval($_GET['YEARNUMBER']) : 0;
		$data['IDMODULE']=isset($_GET['IDMODULE']) ? intval($_GET['IDMODULE']) : 0;

		$data['JUDULMODULELS']=$this->ApprovalListLogsheetModel->getModuleLS($data['IDMODULE'])['JUDUL_MODULE'];

		$this->view('Content/Approval/ApprovalListLogsheet/StatusPageView.php', $data);

	}

	public function dataListStatus(){
        $this->cekHakAkses('READ_DATA');

		echo json_encode($this->ApprovalListLogsheetModel->dataListStatus($this->user));        
	}


	// batas pakai
	
	


		


}
