<?php

namespace App\Controllers\Content\Report\dailyLogSheet;
use App\Models\Content\Report\dailyLogSheet\dailyLSClarificationModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;



class dailyLSClarification extends \App\Controllers\BaseController
{
    public $dailyLSClarificationModel;

	public function __construct() {

		parent::__construct();
		
		$this->dailyLSClarificationModel = new dailyLSClarificationModel;

		$this->data['site_title'] = 'LogSheet Clarification ';

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

		$this->view('Content/Report/dailyLogSheet/dailyLSClarification/dailyLSClarificationView.php', $data);
	}

    public function dataList(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->dailyLSClarificationModel->dataList());        
	}

    
    public function cekDataexportExcelFile(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->dailyLSClarificationModel->dataListExcel());        
	}


    public function exportPDFFile()
    {
        $this->cekHakAkses('READ_DATA');


        ini_set('memory_limit', '1500000M');
        ini_set("pcre.backtrack_limit", "3000000");

        if (empty($_GET['TDATE'])) {
			$TDATE = '';
		} else {
			$TDATE =  date("d-M-y", strtotime($_GET['TDATE']));

            $hari = $this->indonesiaDays(date("l", strtotime($_GET['TDATE'])));
		}

        // $STG_ID = isset($_GET['STG_ID']) ? strval($_GET['STG_ID']) : '';

        $titleOrg =$this->dailyLSClarificationModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->dailyLSClarificationModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];
		
        $data = $this->data;

		$data['imagesPath'] = $this->config->imagesPath;
		$data['Judul'] = 'Laporan '.$this->data['site_title'];
		$data['data_sql'] = $this->dailyLSClarificationModel->dataListExcel();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 
            'format' => 'A4-L', 
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
                CLARIFICATION STATION <br> DAILY LOGSHEET 
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

        $footerPdf = '<table style="width:100%;font-size: 6pt; border-collapse: collapse;">
        <tr>
            <td colspan=2 style=" width:12.5%; text-align: center;border: 1px solid black;">Dibuat</td>
            <td colspan=2 style=" width:12.5%; text-align: center;border: 1px solid black;">Diperiksa</td>
            <td style=" width:12.5%; text-align: center;border: 1px solid black;">Disetujui </td>
            <td style=" width:12.5%; text-align: center;border: 1px solid black;">Diketahui</td>
            <td colspan=2 style=" width:12.5%; text-align: center;"> </td>
        </tr>
        <tr>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td colspan=2 style="width:12.5%;height:60px; text-align: center;vertical-align: top;">FM Condensate</td>
        </tr>
        <tr>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Opt. Proses A</td>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Opt. Proses B</td>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Ast. Proses A</td>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Ast. Proses B</td>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Asst Mill</td>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Mill Manager</td>
            <td style=" width:12.5%;"></td>
            <td style=" width:12.5%;"></td>
        </tr>
        </table>
        ';

        // <tr><td style="text-align:left;">Jam Kerja</td><td>:</td><td>{PAGENO} of {nbpg}</td></tr>

        // dimatikan karena tidak tahu footernya apa
        // $mpdf->SetHTMLFooter($footerPdf);

        $mpdf->AddPage();

        $html = view('Content/Report/dailyLogSheet/dailyLSClarification/pdfView.php', $data);
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

		echo view('Content/Report/dailyLogSheet/dailyLSClarification/pdfView.php', $data);
        
	}

    public function exportExcelFile()
    {
        $this->cekHakAkses('READ_DATA');
        $data = $this->data;
        $data_parameter = $this->dailyLSClarificationModel->dataListExcel();

        
        if (empty($_GET['TDATE'])) {
			$data_db['TDATE'] = '';
		} else {
			$data_db['TDATE'] =  date("d-M-y", strtotime($_GET['TDATE']));

            $hari = $this->indonesiaDays(date("l", strtotime($_GET['TDATE'])));
		}

        $userOrganisasi = $this->session->get('userOrganisasi');
        $userid = $userOrganisasi['LOGINID'];

        $titleOrg =$this->dailyLSClarificationModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->dailyLSClarificationModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];
        

        $fileName = 'writable/filedownload/logSheetClarification_'.$userid.'.xlsx';
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setShowGridlines(false);

        $spreadsheet
        ->getActiveSheet()
        ->getStyle('A5:AI7')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AI')->setWidth(100, 'px');

        $spreadsheet->getActiveSheet()->getStyle('A5:AI7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:AI7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:AI7')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A5:AI7')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle('F3:J3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('F3:J3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        
        $sheet = $spreadsheet->getActiveSheet();
        
        // HEADER
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', $titleOrg);
        $sheet->mergeCells('A2:D2');
        $sheet->setCellValue('A2', $titleSite);
        $sheet->mergeCells('A3:D3');
        $sheet->setCellValue('A3', 'PALM OIL MILL');

        $sheet->mergeCells('F3:J3');
        $sheet->setCellValue('F3', 'CLARIFICATION STATION LOG SHEET');

        $sheet->setCellValue('M1', 'HARI/TANGGAL');
        $sheet->setCellValue('M2', 'SHIFT');
        $sheet->setCellValue('M3', 'JAM KERJA');
        
        $sheet->setCellValue('N1', ': '.$hari.','.$data_db['TDATE']);
        $sheet->setCellValue('N2', ': ');
        $sheet->setCellValue('N3', ': ');
        // BATAS HEADER

        // TABLE HEADER
        $sheet->mergeCells('A5:A7');
        $sheet->setCellValue('A5', 'NO');
        $sheet->mergeCells('B5:B7');
        $sheet->setCellValue('B5', 'TANGGAL');
        $sheet->mergeCells('C5:C7');
        $sheet->setCellValue('C5', 'JAM');
        
        $sheet->mergeCells('D5:G6');
        $sheet->setCellValue('D5', 'TEMP  ( °C )');
        $sheet->setCellValue('D7', 'DCO');
        $sheet->setCellValue('E7', 'COT');
        $sheet->setCellValue('F7', 'OIL TANK 1');
        $sheet->setCellValue('G7', 'OIL TANK 2');
        // $sheet->mergeCells('E5:E6');
        // $spreadsheet->getActiveSheet()->getStyle('E5:E6')->getAlignment()->setWrapText(true);
        // $sheet->setCellValue('E5', 'WAKTU');

        $sheet->mergeCells('H5:H6');
        $sheet->setCellValue('H5', 'VACUM 1');
        $sheet->setCellValue('H7', 'mmHg');

        $sheet->mergeCells('I5:I6');
        $sheet->setCellValue('I5', 'VACUM 2');
        $sheet->setCellValue('I7', 'mmHg');
        
        $sheet->mergeCells('J5:J6');
        $sheet->setCellValue('J5', 'ROT');
        $sheet->setCellValue('J7', ' ( °C )');
        // $sheet->mergeCells('H5:H6');
        // $spreadsheet->getActiveSheet()->getStyle('H5:H6')->getAlignment()->setWrapText(true);

        $sheet->mergeCells('K5:P5');
        $sheet->setCellValue('K5', 'CONTINOUS SETLING TANK');
        $sheet->mergeCells('K6:M6');
        $sheet->setCellValue('K6', 'TEMP  ( °C )');
        $sheet->setCellValue('K7', 'NO.1');
        $sheet->setCellValue('L7', 'NO.2');
        $sheet->setCellValue('M7', 'NO.3');
        $sheet->mergeCells('N6:P6');
        $sheet->setCellValue('N6', 'TEMP  ( °C )');
        $sheet->setCellValue('N7', 'NO.1');
        $sheet->setCellValue('O7', 'NO.2');
        $sheet->setCellValue('P7', 'NO.3');
        
        $sheet->mergeCells('Q5:R5');
        $sheet->setCellValue('Q5', 'SAND TRAP TANK');
        $sheet->mergeCells('Q6:R6');
        $sheet->setCellValue('Q6', 'TEMP ( °C )');
        $sheet->setCellValue('Q7', 'NO.1');
        $sheet->setCellValue('R7', 'NO.2');

        $sheet->mergeCells('S5:T5');
        $sheet->setCellValue('S5', 'SLUDGE TANK');
        $sheet->mergeCells('S6:T6');
        $sheet->setCellValue('S6', 'TEMP ( °C )');
        $sheet->setCellValue('S7', 'NO.1');
        $sheet->setCellValue('T7', 'NO.2');

        $sheet->mergeCells('U5:V5');
        $sheet->setCellValue('U5', 'TEMP SLUDGE SEPARATOR');
        $sheet->mergeCells('U6:V6');
        $sheet->setCellValue('U6', 'TEMP ( °C )');
        $sheet->setCellValue('U7', '-');
        $sheet->setCellValue('V7', '-');

        $sheet->mergeCells('W5:X6');
        $sheet->setCellValue('W5', 'DECANTER IN OPERATION');
        $sheet->setCellValue('W7', 'NO.1');
        $sheet->setCellValue('X7', 'NO.2');

        $sheet->mergeCells('Y5:Y6');
        $sheet->setCellValue('Y5', 'TEMP DECANTER');
        $sheet->setCellValue('Y7', '-');

        $sheet->mergeCells('Z5:Z6');
        $sheet->setCellValue('Z5', 'PROCESS HOT WATER');
        $sheet->setCellValue('Z7', 'TEMP ( °C )');

        $sheet->mergeCells('AA5:AD5');
        $sheet->setCellValue('AA5', 'HM SEPARATOR');
        $sheet->mergeCells('AA6:AB6');
        $sheet->setCellValue('AA6', 'HSS NO.1');
        $sheet->setCellValue('AA7', 'START');
        $sheet->setCellValue('AB7', 'STOP');
        $sheet->mergeCells('AC6:AD6');
        $sheet->setCellValue('AC6', 'HSS NO.2');
        $sheet->setCellValue('AC7', 'START');
        $sheet->setCellValue('AD7', 'STOP');

        $sheet->mergeCells('AE5:AH5');
        $sheet->setCellValue('AE5', 'HM DECANTER');
        $sheet->mergeCells('AE6:AF6');
        $sheet->setCellValue('AE6', 'DECANTER NO 1');
        $sheet->setCellValue('AE7', 'START');
        $sheet->setCellValue('AF7', 'STOP');
        $sheet->mergeCells('AG6:AH6');
        $sheet->setCellValue('AG6', 'DECANTER NO 2');
        $sheet->setCellValue('AG7', 'START');
        $sheet->setCellValue('AH7', 'STOP');

        $sheet->mergeCells('AI5:AI7');
        $sheet->setCellValue('AI5', 'OUTLET SANDCYCLONE');
        // BATAS TABLE HEADER

        $rows = 8;

        $numData=0;
        foreach ($data_parameter as $val) {
            $spreadsheet
            ->getActiveSheet()
            ->getStyle('A7:AI' . $rows)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

            $numData++;

            $val_DECACT1= 'X';
            $val_DECACT2= 'X';

            if($val['DECACT1'] > 0){
                $val_DECACT1= 'V';
            } else{
                $spreadsheet->getActiveSheet()->getStyle('W'. $rows.':'.'W'. $rows)->getFont()->getColor()->setARGB('FFFF0000');
            }

            if($val['DECACT2'] > 0){
                $val_DECACT2= 'V';
            } else{
                $spreadsheet->getActiveSheet()->getStyle('X'. $rows.':'.'X'. $rows)->getFont()->getColor()->setARGB('FFFF0000');
            }

            $sheet->setCellValue('A' . $rows, $numData);
            $sheet->setCellValue('B' . $rows, $val['POSTDT']);
            $sheet->setCellValue('C' . $rows, $val['TIME_DISP']);
            $sheet->setCellValue('D' . $rows, $val['DOC']);
            $sheet->setCellValue('E' . $rows, $val['COTTMP1']);
            $sheet->setCellValue('F' . $rows, $val['OITTMP1']);
            $sheet->setCellValue('G' . $rows, $val['OITTMP2']);
            $sheet->setCellValue('H' . $rows, $val['VCMCH1']);
            $sheet->setCellValue('I' . $rows, $val['VCMCH2']);
            $sheet->setCellValue('J' . $rows, $val['ROTTMP1']);
            $sheet->setCellValue('K' . $rows, $val['CSTTMP1']);
            $sheet->setCellValue('L' . $rows, $val['CSTTMP2']);
            $sheet->setCellValue('M' . $rows, $val['CSTTMP3']);
            $sheet->setCellValue('N' . $rows, $val['CSTOLY1']);
            $sheet->setCellValue('O' . $rows, $val['CSTOLY2']);
            $sheet->setCellValue('P' . $rows, $val['CSTOLY3']);
            $sheet->setCellValue('Q' . $rows, $val['SDTTMP1']);
            $sheet->setCellValue('R' . $rows, $val['SDTTMP2']);
            $sheet->setCellValue('S' . $rows, $val['SGTTMP1']);
            $sheet->setCellValue('T' . $rows, $val['SGTTMP2']);
            $sheet->setCellValue('U' . $rows, $val['SSPTMP1']);
            $sheet->setCellValue('V' . $rows, $val['SSPTMP2']);
            $sheet->setCellValue('W' . $rows, $val_DECACT1);
            $sheet->setCellValue('X' . $rows, $val_DECACT2);
            $sheet->setCellValue('Y' . $rows, $val['DECTMP1']);
            $sheet->setCellValue('Z' . $rows, $val['HWTTMP1']);
            $sheet->setCellValue('AA' . $rows, $this->hmFormat($val['SPHMS1']));
            $sheet->setCellValue('AB' . $rows, $this->hmFormat($val['SPHME1']));
            $sheet->setCellValue('AC' . $rows, $this->hmFormat($val['SPHMS2']));
            $sheet->setCellValue('AD' . $rows, $this->hmFormat($val['SPHME2']));
            $sheet->setCellValue('AE' . $rows, $this->hmFormat($val['DCHMS1']));
            $sheet->setCellValue('AF' . $rows, $this->hmFormat($val['DCHME1']));
            $sheet->setCellValue('AG' . $rows, $this->hmFormat($val['DCHMS2']));
            $sheet->setCellValue('AH' . $rows, $this->hmFormat($val['DCHME2']));
            $sheet->setCellValue('AI' . $rows, $val['OSS1']);
            

            $spreadsheet->getActiveSheet()->getStyle('A'. $rows.':AH'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $rows++;
        }

        

        $spreadsheet->getActiveSheet()->getStyle('W8:X'. $rows)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('D8:M' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('N8:P' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('Q8:V' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('Y8:Z' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('A1:A1')->getNumberFormat()->setFormatCode('@');

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

    public function hmFormat($value=''){
        
        $returnVal= '';

        $lengthVal = strlen($value);

        if($value != null){

            $Jam = substr($value,0,$lengthVal-4);
            $Menit = substr($value,$lengthVal-4,2);
            $Detik = substr($value,$lengthVal-2,2);


            $returnVal = $Jam.'.'.$Menit.'.'.$Detik;
        } 
        return  $returnVal;
    }


	// batas pakai
	
	


		


}
