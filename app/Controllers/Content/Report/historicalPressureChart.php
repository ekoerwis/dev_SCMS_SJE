<?php

namespace App\Controllers\Content\Report;
use App\Models\Content\Report\historicalPressureChartModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;


class historicalPressureChart extends \App\Controllers\BaseController
{
    public $historicalPressureChartModel;

	public function __construct() {

		parent::__construct();
		
		$this->historicalPressureChartModel = new historicalPressureChartModel;

		$this->data['site_title'] = 'Historical Pressure Chart ';

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

        
        // mengaktifkan chartJS 2.9.4 pilih salat satu yang perlu diaktifkan 2.9.4 atau versi 4.3.0
        // $this->addJs (  $this->config->baseURL . 'public/vendors/chartJs/2.9.4/Chart.js');
		// mengaktifkan chartJS 4.3.0
        $this->addJs (  $this->config->baseURL . 'public/vendors/chartJs/4.3.0/chart.js');
		
		helper(['cookie', 'form', 'stringSQLrep', 'mpdfCustom']);
	}

	public function index(){
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

        $data['dataGraph']=$this->historicalPressureChartModel->dataGraph();

		$this->view('Content/Report/historicalPressureChart/historicalPressureChartView.php', $data);
	}

    public function getData(){
		$this->cekHakAkses('READ_DATA');
		
        echo json_encode($this->historicalPressureChartModel->dataGraph());

	}

	public function getDataBpv(){
		$this->cekHakAkses('READ_DATA');
		
        echo json_encode($this->historicalPressureChartModel->getDataBpv());

	}

	public function getDataTurbin(){
		$this->cekHakAkses('READ_DATA');
		
        echo json_encode($this->historicalPressureChartModel->getDataTurbin());

	}

    // batas pakai


}
