<?php

namespace App\Controllers\Content\Report;
use App\Models\Content\Report\HMMachineModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;



class HMMachine extends \App\Controllers\BaseController
{
    public $HMMachineModel;

	public function __construct() {

		parent::__construct();
		
		$this->HMMachineModel = new HMMachineModel;

		$this->data['site_title'] = 'Report HM Machine ';

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
        $this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/datagrid-export-1.0.3/pdfmake.min.js');
        $this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/datagrid-export-1.0.3/vfs_fonts.js');

		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/easyui-custom.js');
		// tambahan untuk client paging
        $this->addJs($this->config->baseURL . 'public/themes/modern/js/easyui-dg-client-pagination-custom.js');
		
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

		$this->view('Content/Report/HMMachine/HMMachineView.php', $data);
	}

    public function getMonth(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->HMMachineModel->getMonth());     
    }

    public function getYear(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->HMMachineModel->getYear());     
    }

    public function dataList(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->HMMachineModel->dataList());        
	}

    

    public function cekDataexportExcelFile(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->HMMachineModel->dataListExcel());        
	}
    
    public function exportExcelFile()
    {
        $this->cekHakAkses('READ_DATA');
        $data = $this->data;
        $data_parameter = $this->HMMachineModel->dataListExcel();

        
        // if (empty($_GET['TDATE'])) {
		// 	$data_db['TDATE'] = '';
		// } else {
		// 	$data_db['TDATE'] =  date("d-M-y", strtotime($_GET['TDATE']));

        //     $hari = $this->indonesiaDays(date("l", strtotime($_GET['TDATE'])));
		// }

        $userOrganisasi = $this->session->get('userOrganisasi');
        $userid = $userOrganisasi['LOGINID'];

        

        $titleOrg =$this->HMMachineModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->HMMachineModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];
        

        $fileName = 'writable/filedownload/HMMachine_'.$userid.'.xlsx';
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setShowGridlines(false);

        $spreadsheet
        ->getActiveSheet()
        ->getStyle('A5:AW6')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN);

        // $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(90, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(90, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(73, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(73, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(73, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(73, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(73, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(73, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(73, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(73, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(73, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(108, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(140, 'px');
        // $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(220, 'px');

        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setWidth(90, 'px');
            // $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $spreadsheet->getActiveSheet()->getStyle('A5:AW6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:AW6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('A5:AW6')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getStyle('A3:D3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('F3:J3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        
        $sheet = $spreadsheet->getActiveSheet();
        
        // HEADER
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', $titleOrg);
        $sheet->mergeCells('A2:D2');
        $sheet->setCellValue('A2', $titleSite);
        $sheet->mergeCells('A3:D3');
        $sheet->setCellValue('A3', 'HM RUNNING MACHINE');

        // $sheet->mergeCells('F3:J3');
        // $sheet->setCellValue('F3', 'HM RUNNING MACHINE');

        // $sheet->setCellValue('M1', 'HARI/TANGGAL');
        // $sheet->setCellValue('M2', 'SHIFT');
        // $sheet->setCellValue('M3', 'JAM KERJA');
        
        // $sheet->setCellValue('N1', ': '.$hari.','.$data_db['TDATE']);
        // $sheet->setCellValue('N2', ': ');
        // $sheet->setCellValue('N3', ': ');
        // BATAS HEADER

        // TABLE HEADER
        $sheet->mergeCells('A5:A6');
        $sheet->setCellValue('A5', 'TANGGAL');

        $sheet->mergeCells('B5:E5');
        $sheet->setCellValue('B5', 'LOADING RAMP STATION');
        $sheet->setCellValue('B6', 'CONV. 1.1');
        $sheet->setCellValue('C6', 'CONV.1.2');
        $sheet->setCellValue('D6', 'CONV.2.1');
        $sheet->setCellValue('E6', 'BUNC SPLITTER');
        
        $sheet->mergeCells('F5:I5');
        $sheet->setCellValue('F5', 'STERILIZER');
        $sheet->setCellValue('F6', 'FRUIT DISTRIBUTING CONV');
        $sheet->setCellValue('G6', 'STERILIZER FRUIT CONV');
        $sheet->setCellValue('H6', 'CONDNSAT PUMP 1');
        $sheet->setCellValue('I6', 'CONDNSAT PUMP 2');

        $sheet->mergeCells('J5:U5');
        $sheet->setCellValue('J5', 'THRESER STATION');
        $sheet->setCellValue('J6', 'THR 1');
        $sheet->setCellValue('K6', 'THR 2');
        $sheet->setCellValue('L6', 'THR 3');
        $sheet->setCellValue('M6', 'THR 4');
        $sheet->setCellValue('N6', 'CROS CONV.1');
        $sheet->setCellValue('O6', 'CROS CONV.2');
        $sheet->setCellValue('P6', 'BUNCH CRUISER 1');
        $sheet->setCellValue('Q6', 'BUNCH PRESS 1');
        $sheet->setCellValue('R6', 'BUNCH PRESS 2');
        $sheet->setCellValue('S6', 'STATIC CRANE');
        $sheet->setCellValue('T6', 'PUMP 1');
        $sheet->setCellValue('U6', 'PUMP 2');

        $sheet->mergeCells('V5:AG5');
        $sheet->setCellValue('V5', 'PRESS STATION');
        $sheet->setCellValue('V6', 'DIGISTER 1');
        $sheet->setCellValue('W6', 'DIGISTER 2');
        $sheet->setCellValue('X6', 'DIGISTER 3');
        $sheet->setCellValue('Y6', 'DIGISTER 4');
        $sheet->setCellValue('Z6', 'DIGISTER 5');
        $sheet->setCellValue('AA6', 'SCREW PRESS 1');
        $sheet->setCellValue('AB6', 'SCREW PRESS 2');
        $sheet->setCellValue('AC6', 'SCREW PRESS 3');
        $sheet->setCellValue('AD6', 'SCREW PRESS 4');
        $sheet->setCellValue('AE6', 'SCREW PRESS 5');
        $sheet->setCellValue('AF6', 'CAKE BRAKE CONV.1');
        $sheet->setCellValue('AG6', 'CAKE BRAKE CONV.2');

        $sheet->mergeCells('AH5:AM5');
        $sheet->setCellValue('AH5', 'CLARIFICATION');
        $sheet->setCellValue('AH6', 'DECANTER 1');
        $sheet->setCellValue('AI6', 'DECANTER 2');
        $sheet->setCellValue('AJ6', 'DOUBLE SANDCYCLONE REC.1');
        $sheet->setCellValue('AK6', 'DOUBLE SANDCYCLONE REC.2');
        $sheet->setCellValue('AL6', 'TRIPLE SANDCYCLONE BUF. TANK 1');
        $sheet->setCellValue('AM6', 'SEPARATOR 2');

        $sheet->mergeCells('AN5:AW5');
        $sheet->setCellValue('AN5', 'KERNEL');
        $sheet->setCellValue('AN6', 'RIPPLE MILL 1');
        $sheet->setCellValue('AO6', 'RIPPLE MILL 2');
        $sheet->setCellValue('AP6', 'RIPPLE MILL 3');
        $sheet->setCellValue('AQ6', 'RIPPLE MILL 4');
        $sheet->setCellValue('AR6', 'HYDROCYCLONE 1.1');
        $sheet->setCellValue('AS6', 'HYDROCYCLONE 1.2');
        $sheet->setCellValue('AT6', 'HYDROCYCLONE 1.3');
        $sheet->setCellValue('AU6', 'HYDROCYCLONE 2.1');
        $sheet->setCellValue('AV6', 'HYDROCYCLONE 2.2');
        $sheet->setCellValue('AW6', 'HYDROCYCLONE 2.3');

        // $sheet->mergeCells('E5:E6');
        // $spreadsheet->getActiveSheet()->getStyle('E5:E6')->getAlignment()->setWrapText(true);
        // $sheet->setCellValue('E5', 'WAKTU');


        // BATAS TABLE HEADER

        $rows = 7;

        $numData=0;
        foreach ($data_parameter as $val) {
            $spreadsheet
            ->getActiveSheet()
            ->getStyle('A7:AW' . $rows)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

            $numData++;

            $sheet->setCellValue('A' . $rows, $val['LHPDT']);
            $sheet->setCellValue('B' . $rows, substr($val['LDRCVR11'],0,strlen($val['LDRCVR11'])-4).'.'.substr($val['LDRCVR11'],strlen($val['LDRCVR11'])-4,2).'.'.substr($val['LDRCVR11'],strlen($val['LDRCVR11'])-2,2));
            $sheet->setCellValue('C' . $rows, substr($val['LDRCVR12'],0,strlen($val['LDRCVR12'])-4).'.'.substr($val['LDRCVR12'],strlen($val['LDRCVR12'])-4,2).'.'.substr($val['LDRCVR12'],strlen($val['LDRCVR12'])-2,2));
            $sheet->setCellValue('D' . $rows, substr($val['LDRCVR21'],0,strlen($val['LDRCVR21'])-4).'.'.substr($val['LDRCVR21'],strlen($val['LDRCVR21'])-4,2).'.'.substr($val['LDRCVR21'],strlen($val['LDRCVR21'])-2,2));
            $sheet->setCellValue('E' . $rows, substr($val['LDRBSP11'],0,strlen($val['LDRBSP11'])-4).'.'.substr($val['LDRBSP11'],strlen($val['LDRBSP11'])-4,2).'.'.substr($val['LDRBSP11'],strlen($val['LDRBSP11'])-2,2));
            $sheet->setCellValue('F' . $rows, substr($val['STZFDC01'],0,strlen($val['STZFDC01'])-4).'.'.substr($val['STZFDC01'],strlen($val['STZFDC01'])-4,2).'.'.substr($val['STZFDC01'],strlen($val['STZFDC01'])-2,2));
            $sheet->setCellValue('G' . $rows, substr($val['STZSFC01'],0,strlen($val['STZSFC01'])-4).'.'.substr($val['STZSFC01'],strlen($val['STZSFC01'])-4,2).'.'.substr($val['STZSFC01'],strlen($val['STZSFC01'])-2,2));
            $sheet->setCellValue('H' . $rows, substr($val['STZCPMP1'],0,strlen($val['STZCPMP1'])-4).'.'.substr($val['STZCPMP1'],strlen($val['STZCPMP1'])-4,2).'.'.substr($val['STZCPMP1'],strlen($val['STZCPMP1'])-2,2));
            $sheet->setCellValue('I' . $rows, substr($val['STZCPMP2'],0,strlen($val['STZCPMP2'])-4).'.'.substr($val['STZCPMP2'],strlen($val['STZCPMP2'])-4,2).'.'.substr($val['STZCPMP2'],strlen($val['STZCPMP2'])-2,2));
            $sheet->setCellValue('J' . $rows, substr($val['THRTHR01'],0,strlen($val['THRTHR01'])-4).'.'.substr($val['THRTHR01'],strlen($val['THRTHR01'])-4,2).'.'.substr($val['THRTHR01'],strlen($val['THRTHR01'])-2,2));
            $sheet->setCellValue('K' . $rows, substr($val['THRTHR02'],0,strlen($val['THRTHR02'])-4).'.'.substr($val['THRTHR02'],strlen($val['THRTHR02'])-4,2).'.'.substr($val['THRTHR02'],strlen($val['THRTHR02'])-2,2));
            $sheet->setCellValue('L' . $rows, substr($val['THRTHR03'],0,strlen($val['THRTHR03'])-4).'.'.substr($val['THRTHR03'],strlen($val['THRTHR03'])-4,2).'.'.substr($val['THRTHR03'],strlen($val['THRTHR03'])-2,2));
            $sheet->setCellValue('M' . $rows, substr($val['THRTHR04'],0,strlen($val['THRTHR04'])-4).'.'.substr($val['THRTHR04'],strlen($val['THRTHR04'])-4,2).'.'.substr($val['THRTHR04'],strlen($val['THRTHR04'])-2,2));
            $sheet->setCellValue('N' . $rows, substr($val['THRCRC01'],0,strlen($val['THRCRC01'])-4).'.'.substr($val['THRCRC01'],strlen($val['THRCRC01'])-4,2).'.'.substr($val['THRCRC01'],strlen($val['THRCRC01'])-2,2));
            $sheet->setCellValue('O' . $rows, substr($val['THRCRC02'],0,strlen($val['THRCRC02'])-4).'.'.substr($val['THRCRC02'],strlen($val['THRCRC02'])-4,2).'.'.substr($val['THRCRC02'],strlen($val['THRCRC02'])-2,2));
            $sheet->setCellValue('P' . $rows, substr($val['THRBNC01'],0,strlen($val['THRBNC01'])-4).'.'.substr($val['THRBNC01'],strlen($val['THRBNC01'])-4,2).'.'.substr($val['THRBNC01'],strlen($val['THRBNC01'])-2,2));
            $sheet->setCellValue('Q' . $rows, substr($val['THRBNP01'],0,strlen($val['THRBNP01'])-4).'.'.substr($val['THRBNP01'],strlen($val['THRBNP01'])-4,2).'.'.substr($val['THRBNP01'],strlen($val['THRBNP01'])-2,2));
            $sheet->setCellValue('R' . $rows, substr($val['THRBNP02'],0,strlen($val['THRBNP02'])-4).'.'.substr($val['THRBNP02'],strlen($val['THRBNP02'])-4,2).'.'.substr($val['THRBNP02'],strlen($val['THRBNP02'])-2,2));
            $sheet->setCellValue('S' . $rows, substr($val['THRSTC01'],0,strlen($val['THRSTC01'])-4).'.'.substr($val['THRSTC01'],strlen($val['THRSTC01'])-4,2).'.'.substr($val['THRSTC01'],strlen($val['THRSTC01'])-2,2));
            $sheet->setCellValue('T' . $rows, substr($val['THRPMP01'],0,strlen($val['THRPMP01'])-4).'.'.substr($val['THRPMP01'],strlen($val['THRPMP01'])-4,2).'.'.substr($val['THRPMP01'],strlen($val['THRPMP01'])-2,2));
            $sheet->setCellValue('U' . $rows, substr($val['THRPMP02'],0,strlen($val['THRPMP02'])-4).'.'.substr($val['THRPMP02'],strlen($val['THRPMP02'])-4,2).'.'.substr($val['THRPMP02'],strlen($val['THRPMP02'])-2,2));
            $sheet->setCellValue('V' . $rows, substr($val['PRSDIG01'],0,strlen($val['PRSDIG01'])-4).'.'.substr($val['PRSDIG01'],strlen($val['PRSDIG01'])-4,2).'.'.substr($val['PRSDIG01'],strlen($val['PRSDIG01'])-2,2));
            $sheet->setCellValue('W' . $rows, substr($val['PRSDIG02'],0,strlen($val['PRSDIG02'])-4).'.'.substr($val['PRSDIG02'],strlen($val['PRSDIG02'])-4,2).'.'.substr($val['PRSDIG02'],strlen($val['PRSDIG02'])-2,2));
            $sheet->setCellValue('X' . $rows, substr($val['PRSDIG03'],0,strlen($val['PRSDIG03'])-4).'.'.substr($val['PRSDIG03'],strlen($val['PRSDIG03'])-4,2).'.'.substr($val['PRSDIG03'],strlen($val['PRSDIG03'])-2,2));
            $sheet->setCellValue('Y' . $rows, substr($val['PRSDIG04'],0,strlen($val['PRSDIG04'])-4).'.'.substr($val['PRSDIG04'],strlen($val['PRSDIG04'])-4,2).'.'.substr($val['PRSDIG04'],strlen($val['PRSDIG04'])-2,2));
            $sheet->setCellValue('Z' . $rows, substr($val['PRSDIG05'],0,strlen($val['PRSDIG05'])-4).'.'.substr($val['PRSDIG05'],strlen($val['PRSDIG05'])-4,2).'.'.substr($val['PRSDIG05'],strlen($val['PRSDIG05'])-2,2));
            $sheet->setCellValue('AA' . $rows, substr($val['PRSPRS01'],0,strlen($val['PRSPRS01'])-4).'.'.substr($val['PRSPRS01'],strlen($val['PRSPRS01'])-4,2).'.'.substr($val['PRSPRS01'],strlen($val['PRSPRS01'])-2,2));
            $sheet->setCellValue('AB' . $rows, substr($val['PRSPRS02'],0,strlen($val['PRSPRS02'])-4).'.'.substr($val['PRSPRS02'],strlen($val['PRSPRS02'])-4,2).'.'.substr($val['PRSPRS02'],strlen($val['PRSPRS02'])-2,2));
            $sheet->setCellValue('AC' . $rows, substr($val['PRSPRS03'],0,strlen($val['PRSPRS03'])-4).'.'.substr($val['PRSPRS03'],strlen($val['PRSPRS03'])-4,2).'.'.substr($val['PRSPRS03'],strlen($val['PRSPRS03'])-2,2));
            $sheet->setCellValue('AD' . $rows, substr($val['PRSPRS04'],0,strlen($val['PRSPRS04'])-4).'.'.substr($val['PRSPRS04'],strlen($val['PRSPRS04'])-4,2).'.'.substr($val['PRSPRS04'],strlen($val['PRSPRS04'])-2,2));
            $sheet->setCellValue('AE' . $rows, substr($val['PRSPRS05'],0,strlen($val['PRSPRS05'])-4).'.'.substr($val['PRSPRS05'],strlen($val['PRSPRS05'])-4,2).'.'.substr($val['PRSPRS05'],strlen($val['PRSPRS05'])-2,2));
            $sheet->setCellValue('AF' . $rows, substr($val['PRSCBC01'],0,strlen($val['PRSCBC01'])-4).'.'.substr($val['PRSCBC01'],strlen($val['PRSCBC01'])-4,2).'.'.substr($val['PRSCBC01'],strlen($val['PRSCBC01'])-2,2));
            $sheet->setCellValue('AG' . $rows, substr($val['PRSCBC02'],0,strlen($val['PRSCBC02'])-4).'.'.substr($val['PRSCBC02'],strlen($val['PRSCBC02'])-4,2).'.'.substr($val['PRSCBC02'],strlen($val['PRSCBC02'])-2,2));
            $sheet->setCellValue('AH' . $rows, substr($val['CLRDCT01'],0,strlen($val['CLRDCT01'])-4).'.'.substr($val['CLRDCT01'],strlen($val['CLRDCT01'])-4,2).'.'.substr($val['CLRDCT01'],strlen($val['CLRDCT01'])-2,2));
            $sheet->setCellValue('AI' . $rows, substr($val['CLRDCT02'],0,strlen($val['CLRDCT02'])-4).'.'.substr($val['CLRDCT02'],strlen($val['CLRDCT02'])-4,2).'.'.substr($val['CLRDCT02'],strlen($val['CLRDCT02'])-2,2));
            $sheet->setCellValue('AJ' . $rows, substr($val['CLRDSR01'],0,strlen($val['CLRDSR01'])-4).'.'.substr($val['CLRDSR01'],strlen($val['CLRDSR01'])-4,2).'.'.substr($val['CLRDSR01'],strlen($val['CLRDSR01'])-2,2));
            $sheet->setCellValue('AK' . $rows, substr($val['CLRDSR02'],0,strlen($val['CLRDSR02'])-4).'.'.substr($val['CLRDSR02'],strlen($val['CLRDSR02'])-4,2).'.'.substr($val['CLRDSR02'],strlen($val['CLRDSR02'])-2,2));
            $sheet->setCellValue('AL' . $rows, substr($val['CLRTST01'],0,strlen($val['CLRTST01'])-4).'.'.substr($val['CLRTST01'],strlen($val['CLRTST01'])-4,2).'.'.substr($val['CLRTST01'],strlen($val['CLRTST01'])-2,2));
            $sheet->setCellValue('AM' . $rows, substr($val['CLRSPR2'],0,strlen($val['CLRSPR2'])-4).'.'.substr($val['CLRSPR2'],strlen($val['CLRSPR2'])-4,2).'.'.substr($val['CLRSPR2'],strlen($val['CLRSPR2'])-2,2));
            $sheet->setCellValue('AN' . $rows, substr($val['KERRPM1'],0,strlen($val['KERRPM1'])-4).'.'.substr($val['KERRPM1'],strlen($val['KERRPM1'])-4,2).'.'.substr($val['KERRPM1'],strlen($val['KERRPM1'])-2,2));
            $sheet->setCellValue('AO' . $rows, substr($val['KERRPM2'],0,strlen($val['KERRPM2'])-4).'.'.substr($val['KERRPM2'],strlen($val['KERRPM2'])-4,2).'.'.substr($val['KERRPM2'],strlen($val['KERRPM2'])-2,2));
            $sheet->setCellValue('AP' . $rows, substr($val['KERRPM3'],0,strlen($val['KERRPM3'])-4).'.'.substr($val['KERRPM3'],strlen($val['KERRPM3'])-4,2).'.'.substr($val['KERRPM3'],strlen($val['KERRPM3'])-2,2));
            $sheet->setCellValue('AQ' . $rows, substr($val['KERRPM4'],0,strlen($val['KERRPM4'])-4).'.'.substr($val['KERRPM4'],strlen($val['KERRPM4'])-4,2).'.'.substr($val['KERRPM4'],strlen($val['KERRPM4'])-2,2));
            $sheet->setCellValue('AR' . $rows, substr($val['KERHDC11'],0,strlen($val['KERHDC11'])-4).'.'.substr($val['KERHDC11'],strlen($val['KERHDC11'])-4,2).'.'.substr($val['KERHDC11'],strlen($val['KERHDC11'])-2,2));
            $sheet->setCellValue('AS' . $rows, substr($val['KERHDC12'],0,strlen($val['KERHDC12'])-4).'.'.substr($val['KERHDC12'],strlen($val['KERHDC12'])-4,2).'.'.substr($val['KERHDC12'],strlen($val['KERHDC12'])-2,2));
            $sheet->setCellValue('AT' . $rows, substr($val['KERHDC13'],0,strlen($val['KERHDC13'])-4).'.'.substr($val['KERHDC13'],strlen($val['KERHDC13'])-4,2).'.'.substr($val['KERHDC13'],strlen($val['KERHDC13'])-2,2));
            $sheet->setCellValue('AU' . $rows, substr($val['KERHDC21'],0,strlen($val['KERHDC21'])-4).'.'.substr($val['KERHDC21'],strlen($val['KERHDC21'])-4,2).'.'.substr($val['KERHDC21'],strlen($val['KERHDC21'])-2,2));
            $sheet->setCellValue('AV' . $rows, substr($val['KERHDC22'],0,strlen($val['KERHDC22'])-4).'.'.substr($val['KERHDC22'],strlen($val['KERHDC22'])-4,2).'.'.substr($val['KERHDC22'],strlen($val['KERHDC22'])-2,2));
            $sheet->setCellValue('AW' . $rows, substr($val['KERHDC23'],0,strlen($val['KERHDC23'])-4).'.'.substr($val['KERHDC23'],strlen($val['KERHDC23'])-4,2).'.'.substr($val['KERHDC23'],strlen($val['KERHDC23'])-2,2));


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

    public function indonesiaDays($longDays=''){

        if($longDays == 'Monday'){
            $indonesiaD = 'Senin';
        } else if($longDays == 'Tuesday'){
            $indonesiaD = 'Selasa';
        }  else if($longDays == 'Wednesday'){
            $indonesiaD = 'Rabu';
        }  else if($longDays == 'Thursday'){
            $indonesiaD = 'Kamis';
        }  else if($longDays == 'Friday'){
            $indonesiaD = 'Jumat';
        }  else if($longDays == 'Saturday'){
            $indonesiaD = 'Sabtu';
        }  else if($longDays == 'Sunday'){
            $indonesiaD = 'Minggu';
        } else {
            $indonesiaD = '';
        }

        return $indonesiaD;
        
    }

	public function cekPdfView(){
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

		echo view('Content/Report/HMMachine/pdfView.php', $data);
        
	}



	// batas pakai
	
	


		


}
