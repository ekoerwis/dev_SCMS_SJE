<?php

namespace App\Controllers\Content\Report\dailyLogSheet;
use App\Models\Content\Report\dailyLogSheet\dailyLSNetModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;



class dailyLSNet extends \App\Controllers\BaseController
{
    public $dailyLSNetModel;

	public function __construct() {

		parent::__construct();
		
		$this->dailyLSNetModel = new dailyLSNetModel;

		$this->data['site_title'] = 'LogSheet Net ';

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

		$this->view('Content/Report/dailyLogSheet/dailyLSNet/dailyLSNetView.php', $data);
	}

    public function dataList(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->dailyLSNetModel->dataList());        
	}

    

    public function cekDataexportExcelFile(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->dailyLSNetModel->dataListExcel());        
	}

    public function getNetAdd(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->dailyLSNetModel->getNetAdd());     
    }


	public function exportExcelFile()
    {
        $this->cekHakAkses('READ_DATA');
        $data = $this->data;
        $data_parameter = $this->dailyLSNetModel->dataListExcel();

        
        if (empty($_GET['TDATE'])) {
			$data_db['TDATE'] = '';
		} else {
			$data_db['TDATE'] =  date("d-M-y", strtotime($_GET['TDATE']));

            $hari = $this->indonesiaDays(date("l", strtotime($_GET['TDATE'])));
		}

        $userOrganisasi = $this->session->get('userOrganisasi');
        $userid = $userOrganisasi['LOGINID'];

        

        $titleOrg =$this->dailyLSNetModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->dailyLSNetModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];
        

        $fileName = 'writable/filedownload/dailyLSNet_'.$userid.'.xlsx';
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setShowGridlines(false);

        $spreadsheet
        ->getActiveSheet()
        ->getStyle('A5:O6')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(33, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(108,'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(140, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(220, 'px');

        $spreadsheet->getActiveSheet()->getStyle('A5:O6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:O6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('F3:J3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('F3:J3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        
        $sheet = $spreadsheet->getActiveSheet();
        
        // HEADER
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', $titleOrg);
        $sheet->mergeCells('A2:D2');
        $sheet->setCellValue('A2', $titleSite);
        $sheet->mergeCells('A3:D3');
        $sheet->setCellValue('A3', 'PALM OIL MILL');

        $sheet->mergeCells('F3:J3');
        $sheet->setCellValue('F3', 'STERILIZER STATION LOG SHEET');

        $sheet->setCellValue('M1', 'HARI/TANGGAL');
        $sheet->setCellValue('M2', 'SHIFT');
        $sheet->setCellValue('M3', 'JAM KERJA');
        
        $sheet->setCellValue('N1', ': '.$hari.','.$data_db['TDATE']);
        $sheet->setCellValue('N2', ': ');
        $sheet->setCellValue('N3', ': ');
        // BATAS HEADER

        // TABLE HEADER
        $sheet->mergeCells('A5:A6');
        $sheet->setCellValue('A5', 'NO');
        $sheet->mergeCells('B5:B6');
        $sheet->setCellValue('B5', 'STERILIZER');
        
        $sheet->mergeCells('C5:E5');
        $sheet->setCellValue('C5', 'BUAH MASUK');
        $sheet->setCellValue('C6', 'START');
        $sheet->setCellValue('D6', 'STOP');
        $sheet->setCellValue('E6', 'WAKTU');
        // $sheet->mergeCells('E5:E6');
        // $spreadsheet->getActiveSheet()->getStyle('E5:E6')->getAlignment()->setWrapText(true);
        // $sheet->setCellValue('E5', 'WAKTU');

        $sheet->mergeCells('F5:H5');
        $sheet->setCellValue('F5', 'MEREBUS');
        $sheet->setCellValue('F6', 'START');
        $sheet->setCellValue('G6', 'STOP');
        // $sheet->mergeCells('H5:H6');
        // $spreadsheet->getActiveSheet()->getStyle('H5:H6')->getAlignment()->setWrapText(true);
        $sheet->setCellValue('H6', 'WAKTU');

        $sheet->mergeCells('I5:K5');
        $sheet->setCellValue('I5', 'BUAH KELUAR');
        $sheet->setCellValue('I6', 'START');
        $sheet->setCellValue('J6', 'STOP');
        // $sheet->mergeCells('K5:K6');
        // $spreadsheet->getActiveSheet()->getStyle('K5:K6')->getAlignment()->setWrapText(true);
        $sheet->setCellValue('K6', 'WAKTU');

        $sheet->mergeCells('L5:L6');
        $spreadsheet->getActiveSheet()->getStyle('L5:O6')->getAlignment()->setWrapText(true);
        $sheet->setCellValue('L5', 'TOTAL WAKTU');

        $sheet->mergeCells('M5:M6');
        $sheet->setCellValue('M5', 'TEMP '.'(C)');

        $sheet->mergeCells('N5:N6');
        $sheet->setCellValue('N5', 'PARAF MANDOR');

        $sheet->mergeCells('O5:O6');
        $sheet->setCellValue('O5', 'KETERANGAN');

        // BATAS TABLE HEADER

        $rows = 7;

        $numData=0;
        foreach ($data_parameter as $val) {
            $spreadsheet
            ->getActiveSheet()
            ->getStyle('A7:O' . $rows)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

            $numData++;

            $sheet->setCellValue('A' . $rows, $numData);
            $sheet->setCellValue('B' . $rows, $val['STZID']);
            $sheet->setCellValue('C' . $rows, $val['STZIN_ST_TIME']);
            $sheet->setCellValue('D' . $rows, $val['STZIN_ED_TIME']);
            $sheet->setCellValue('E' . $rows, $val['STZIN_MN']);
            $sheet->setCellValue('F' . $rows, $val['STZPRO_ST_TIME']);
            $sheet->setCellValue('G' . $rows, $val['STZPRO_ED_TIME']);
            $sheet->setCellValue('H' . $rows, $val['STZPRO_MN']);
            $sheet->setCellValue('I' . $rows, $val['STZOUT_ST_TIME']);
            $sheet->setCellValue('J' . $rows, $val['STZOUT_ED_TIME']);
            $sheet->setCellValue('K' . $rows, $val['STZOUT_MN']);
            $sheet->setCellValue('L' . $rows, $val['STZTM_TOT']);
            $sheet->setCellValue('M' . $rows, $val['STZTMP1']);
            $sheet->setCellValue('N' . $rows, $val['STZACC']);
            $sheet->setCellValue('O' . $rows, $val['STZNOTE']);


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

    public function exportPDFFile()
    {
        $this->cekHakAkses('READ_DATA');

		// $exportType=isset($_GET['exportType']) ? strval($_GET['exportType']) : '';
		// $BUDGETYEAR = isset($_GET['YEARNUMBER']) ? strval($_GET['YEARNUMBER']) : '';
		// $PERIOD = isset($_GET['MONTHNUMBER']) ? strval($_GET['MONTHNUMBER']) : '';
		// $SITE_ID = isset($_GET['SITE_ID']) ? strval($_GET['SITE_ID']) : '';
		// $TARGETTYPE = isset($_GET['TARGETTYPE']) ? strval($_GET['TARGETTYPE']) : '';
        ini_set('memory_limit', '1500000M');
        ini_set("pcre.backtrack_limit", "3000000");

        if (empty($_GET['TDATE'])) {
			$TDATE = '';
		} else {
			$TDATE =  date("d-M-y", strtotime($_GET['TDATE']));

            $hari = $this->indonesiaDays(date("l", strtotime($_GET['TDATE'])));
		}

        $titleOrg =$this->dailyLSNetModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->dailyLSNetModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];

		$data['Judul'] = 'Laporan '.$this->data['site_title'];
		$data['data_sql'] = $this->dailyLSNetModel->dataListExcel();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 
            'format' => 'A4-P', 
            'setAutoTopMargin' => 'stretch', 
            'setAutoBottomMargin' => 'stretch',
            'shrink_tables_to_fit'=>'false'
        ]);

        // $mpdf->shrink_tables_to_fit=-1;

        $headerPdf = '<table style="width:100%;">
        <tr>
            <td style=" width:33.33%; text-align: left;"> 
                <table style="font-size: 8pt;">
                    <tr><td  style="font-size: 7pt;color: #0000ff;"><b>'.$titleOrg.'</b></td></tr>
                    <tr><td>'.$titleSite.'</td></tr>
                    <tr><td>PALM OIL MILL</td></tr>
                </table>
            </td>
            <td style="width:33.33%; text-align:center;">  
                NET LOGSHEET <br> DAILY LOGSHEET 
            </td>
            <td style="width:33.33%; text-align:right;">  
                <table style="float:right;font-size: 8pt;">
                    <tr><td style="text-align:left;">Hari/Tanggal</td><td>:</td><td>'.$hari.', '.$TDATE.'</td></tr>
                    <tr><td style="text-align:left;">Shift</td><td>:</td><td style="text-align:left;">........</td></tr>
                    <tr><td style="text-align:left;">Jam Kerja</td><td>:</td><td style="text-align:left;">........</td></tr>
                </table>
            </td>
        </tr>
        </table>
        <hr style="height:2px;border-width:0;color:gray;background-color:gray">';

        // <tr><td style="text-align:left;">Jam Kerja</td><td>:</td><td>{PAGENO} of {nbpg}</td></tr>

        $mpdf->SetHTMLHeader($headerPdf);

        $footerPdf = '
        ';

        // <tr><td style="text-align:left;">Jam Kerja</td><td>:</td><td>{PAGENO} of {nbpg}</td></tr>

        // $mpdf->SetHTMLFooter($footerPdf);

        $mpdf->AddPage();

        $html = view('Content/Report/dailyLogSheet/dailyLSNet/pdfView.php', $data);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($data['Judul'].'.pdf', 'I'); // opens in browser
        //$mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
        //return view('welcome_message');
		
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


	// batas pakai
	
	


		


}
