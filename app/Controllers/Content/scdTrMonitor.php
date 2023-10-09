<?php

namespace App\Controllers\Content;
use App\Models\Content\scdTrMonitorModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;



class scdTrMonitor extends \App\Controllers\BaseController
{
    public $scdTrMonitorModel;

	public function __construct() {

		parent::__construct();
		
		$this->scdTrMonitorModel = new scdTrMonitorModel;

		$this->data['site_title'] = 'Tabel scd_TrMonitor';

		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/icon.css');
		// $this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/default/easyui.css');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/bootstrap/easyui.css');
		$this->addStyle ( $this->config->baseURL . 'public/themes/modern/css/easyui-custom.css');

		$this->addJs ( $this->config->baseURL . 'public/vendors/overlayscrollbars/jquery.overlayScrollbars.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.easyui.min.js');

		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-detailview.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-groupview.js');
        $this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/datagrid-export-1.0.3/datagrid-export.js');

		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/easyui-custom.js');
		// tambahan untuk client paging
        $this->addJs($this->config->baseURL . 'public/themes/modern/js/easyui-dg-client-pagination-custom.js');
		
		helper(['cookie', 'form']);
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

		$this->view('Content/scdTrMonitor/scdTrMonitorView.php', $data);
	}

    public function dataList(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->scdTrMonitorModel->dataList());        
	}


	public function exportExcelFile()
    {
        $this->cekHakAkses('READ_DATA');
        $data = $this->data;
        $data_parameter = $this->scdTrMonitorModel->dataListExcel();

        $userOrganisasi = $this->session->get('userOrganisasi');
        $userid = $userOrganisasi['LOGINID'];
        

        $fileName = 'writable/filedownload/scdTrMonitor_'.$userid.'.xlsx';
        $spreadsheet = new Spreadsheet();

        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'CRTTS');
        $sheet->setCellValue('B1', 'CRTBY');
        $sheet->setCellValue('C1', 'SVRDT');
        $sheet->setCellValue('D1', 'POSTDT');
        $sheet->setCellValue('E1', 'ORG_ID');
        $sheet->setCellValue('F1', 'ORG_CODE');
        $sheet->setCellValue('G1', 'ORG_CODE_PR');
        $sheet->setCellValue('H1', 'DT_ID');
        $sheet->setCellValue('I1', 'DT_UEP');
        $sheet->setCellValue('J1', 'DT_DIV');
        $sheet->setCellValue('K1', 'DT_ADD');
        $sheet->setCellValue('L1', 'DT_VAL');
        $sheet->setCellValue('M1', 'DT_TYPE');
        $sheet->setCellValue('N1', 'TDATETIME');

        $rows = 2;

        foreach ($data_parameter as $val) {
            $sheet->setCellValue('A' . $rows, $val['CRTTS']);
            $sheet->setCellValue('B' . $rows, $val['CRTBY']);
            $sheet->setCellValue('C' . $rows, $val['SVRDT']);
            $sheet->setCellValue('D' . $rows, $val['POSTDT']);
            $sheet->setCellValue('E' . $rows, $val['ORG_ID']);
            $sheet->setCellValue('F' . $rows, $val['ORG_CODE']);
            $sheet->setCellValue('G' . $rows, $val['ORG_CODE_PR']);
            $sheet->setCellValue('H' . $rows, $val['DT_ID']);
            $sheet->setCellValue('I' . $rows, $val['DT_UEP']);
            $sheet->setCellValue('J' . $rows, $val['DT_DIV']);
            $sheet->setCellValue('K' . $rows, $val['DT_ADD']);
            $sheet->setCellValue('L' . $rows, $val['DT_VAL']);
            $sheet->setCellValue('M' . $rows, $val['DT_TYPE']);
            $sheet->setCellValue('N' . $rows, $val['TDATETIME']);


            $rows++;
        }

        $writer = new Xlsx($spreadsheet);

        $writer->save($fileName);

        header("Content-Type: application/vnd.ms-excel");

        header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length:' . filesize($fileName));

        flush();

        readfile($fileName);

        echo "<script>window.close();</script>";

        exit;
    }


	// batas pakai
	
	


		


}
