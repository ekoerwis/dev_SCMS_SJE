<?php

namespace App\Controllers\Content\LogSheet;
use App\Models\Content\LogSheet\logSheetClarificationModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;



class logSheetClarification extends \App\Controllers\BaseController
{
    public $logSheetClarificationModel;

	public function __construct() {

		parent::__construct();
		
		$this->logSheetClarificationModel = new logSheetClarificationModel;

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

		$this->view('Content/LogSheet/logSheetClarification/logSheetClarificationView.php', $data);
	}

    public function getStationID(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->logSheetClarificationModel->getStationID());     
    }

    public function dataList(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->logSheetClarificationModel->dataList());        
	}

    

    public function cekDataexportExcelFile(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->logSheetClarificationModel->dataListExcel());        
	}


    public function exportPDFFile()
    {
        $this->cekHakAkses('READ_DATA');

        if (empty($_GET['TDATE'])) {
			$TDATE = '';
		} else {
			$TDATE =  date("d-M-y", strtotime($_GET['TDATE']));

            $hari = $this->indonesiaDays(date("l", strtotime($_GET['TDATE'])));
		}

        // $STG_ID = isset($_GET['STG_ID']) ? strval($_GET['STG_ID']) : '';

        $titleOrg =$this->logSheetClarificationModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->logSheetClarificationModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];
		
        $data = $this->data;

		$data['imagesPath'] = $this->config->imagesPath;
		$data['Judul'] = 'Laporan '.$this->data['site_title'];
		$data['data_sql'] = $this->logSheetClarificationModel->dataListExcel();

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
                CLARIFICATION STATION
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

        $html = view('Content/LogSheet/logSheetClarification/pdfView.php', $data);
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

		echo view('Content/LogSheet/logSheetClarification/pdfView.php', $data);
        
	}

    public function exportExcelFile()
    {
        $this->cekHakAkses('READ_DATA');
        $data = $this->data;
        $data_parameter = $this->logSheetClarificationModel->dataListExcel();

        
        if (empty($_GET['TDATE'])) {
			$data_db['TDATE'] = '';
		} else {
			$data_db['TDATE'] =  date("d-M-y", strtotime($_GET['TDATE']));

            $hari = $this->indonesiaDays(date("l", strtotime($_GET['TDATE'])));
		}

        $userOrganisasi = $this->session->get('userOrganisasi');
        $userid = $userOrganisasi['LOGINID'];

        $titleOrg =$this->logSheetClarificationModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->logSheetClarificationModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];
        

        $fileName = 'writable/filedownload/logSheetClarification_'.$userid.'.xlsx';
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setShowGridlines(false);

        $spreadsheet
        ->getActiveSheet()
        ->getStyle('A5:AH7')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(100, 'px');
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

        $spreadsheet->getActiveSheet()->getStyle('A5:AH7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:AH7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:AH7')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A5:AH7')->getFont()->setBold(true);

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
        $sheet->setCellValue('B5', 'JAM');
        
        $sheet->mergeCells('C5:F6');
        $sheet->setCellValue('C5', 'TEMP  ( °C )');
        $sheet->setCellValue('C7', 'DCO');
        $sheet->setCellValue('D7', 'COT');
        $sheet->setCellValue('E7', 'OIL TANK 1');
        $sheet->setCellValue('F7', 'OIL TANK 2');
        // $sheet->mergeCells('E5:E6');
        // $spreadsheet->getActiveSheet()->getStyle('E5:E6')->getAlignment()->setWrapText(true);
        // $sheet->setCellValue('E5', 'WAKTU');

        $sheet->mergeCells('G5:G6');
        $sheet->setCellValue('G5', 'VACUM 1');
        $sheet->setCellValue('G7', 'mmHg');

        $sheet->mergeCells('H5:H6');
        $sheet->setCellValue('H5', 'VACUM 2');
        $sheet->setCellValue('H7', 'mmHg');
        
        $sheet->mergeCells('I5:I6');
        $sheet->setCellValue('I5', 'ROT');
        $sheet->setCellValue('I7', ' ( °C )');
        // $sheet->mergeCells('H5:H6');
        // $spreadsheet->getActiveSheet()->getStyle('H5:H6')->getAlignment()->setWrapText(true);

        $sheet->mergeCells('J5:O5');
        $sheet->setCellValue('J5', 'CONTINOUS SETLING TANK');
        $sheet->mergeCells('J6:L6');
        $sheet->setCellValue('J6', 'TEMP  ( °C )');
        $sheet->setCellValue('J7', 'NO.1');
        $sheet->setCellValue('K7', 'NO.2');
        $sheet->setCellValue('L7', 'NO.3');
        $sheet->mergeCells('M6:O6');
        $sheet->setCellValue('M6', 'TEMP  ( °C )');
        $sheet->setCellValue('M7', 'NO.1');
        $sheet->setCellValue('N7', 'NO.2');
        $sheet->setCellValue('O7', 'NO.3');
        
        $sheet->mergeCells('P5:Q5');
        $sheet->setCellValue('P5', 'SAND TRAP TANK');
        $sheet->mergeCells('P6:Q6');
        $sheet->setCellValue('P6', 'TEMP ( °C )');
        $sheet->setCellValue('P7', 'NO.1');
        $sheet->setCellValue('Q7', 'NO.2');

        $sheet->mergeCells('R5:S5');
        $sheet->setCellValue('R5', 'SLUDGE TANK');
        $sheet->mergeCells('R6:S6');
        $sheet->setCellValue('R6', 'TEMP ( °C )');
        $sheet->setCellValue('R7', 'NO.1');
        $sheet->setCellValue('S7', 'NO.2');

        $sheet->mergeCells('T5:U5');
        $sheet->setCellValue('T5', 'TEMP SLUDGE SEPARATOR');
        $sheet->mergeCells('T6:U6');
        $sheet->setCellValue('T6', 'TEMP ( °C )');
        $sheet->setCellValue('T7', '-');
        $sheet->setCellValue('U7', '-');

        $sheet->mergeCells('V5:W6');
        $sheet->setCellValue('V5', 'DECANTER IN OPERATION');
        $sheet->setCellValue('V7', 'NO.1');
        $sheet->setCellValue('W7', 'NO.2');

        $sheet->mergeCells('X5:X6');
        $sheet->setCellValue('X5', 'TEMP DECANTER');
        $sheet->setCellValue('X7', '-');

        $sheet->mergeCells('Y5:Y6');
        $sheet->setCellValue('Y5', 'PROCESS HOT WATER');
        $sheet->setCellValue('Y7', 'TEMP ( °C )');

        $sheet->mergeCells('Z5:AC5');
        $sheet->setCellValue('Z5', 'HM SEPARATOR');
        $sheet->mergeCells('Z6:AA6');
        $sheet->setCellValue('Z6', 'HSS NO.1');
        $sheet->setCellValue('Z7', 'START');
        $sheet->setCellValue('AA7', 'STOP');
        $sheet->mergeCells('AB6:AC6');
        $sheet->setCellValue('AB6', 'HSS NO.2');
        $sheet->setCellValue('AB7', 'START');
        $sheet->setCellValue('AC7', 'STOP');

        $sheet->mergeCells('AD5:AG5');
        $sheet->setCellValue('AD5', 'HM DECANTER');
        $sheet->mergeCells('AD6:AE6');
        $sheet->setCellValue('AD6', 'DECANTER NO 1');
        $sheet->setCellValue('AD7', 'START');
        $sheet->setCellValue('AE7', 'STOP');
        $sheet->mergeCells('AF6:AG6');
        $sheet->setCellValue('AF6', 'DECANTER NO 2');
        $sheet->setCellValue('AF7', 'START');
        $sheet->setCellValue('AG7', 'STOP');

        $sheet->mergeCells('AH5:AH7');
        $sheet->setCellValue('AH5', 'OUTLET SANDCYCLONE');
        // BATAS TABLE HEADER

        $rows = 8;

        $numData=0;
        foreach ($data_parameter as $val) {
            $spreadsheet
            ->getActiveSheet()
            ->getStyle('A7:AH' . $rows)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

            $numData++;

            $val_DECACT1= 'X';
            $val_DECACT2= 'X';

            if($val['DECACT1'] > 0){
                $val_DECACT1= 'V';
            } else{
                $spreadsheet->getActiveSheet()->getStyle('V'. $rows.':'.'V'. $rows)->getFont()->getColor()->setARGB('FFFF0000');
            }

            if($val['DECACT2'] > 0){
                $val_DECACT2= 'V';
            } else{
                $spreadsheet->getActiveSheet()->getStyle('W'. $rows.':'.'W'. $rows)->getFont()->getColor()->setARGB('FFFF0000');
            }

            $sheet->setCellValue('A' . $rows, $numData);
            $sheet->setCellValue('B' . $rows, $val['TIME_DISP']);
            $sheet->setCellValue('C' . $rows, $val['DOC']);
            $sheet->setCellValue('D' . $rows, $val['COTTMP1']);
            $sheet->setCellValue('E' . $rows, $val['OITTMP1']);
            $sheet->setCellValue('F' . $rows, $val['OITTMP2']);
            $sheet->setCellValue('G' . $rows, $val['VCMCH1']);
            $sheet->setCellValue('H' . $rows, $val['VCMCH2']);
            $sheet->setCellValue('I' . $rows, $val['ROTTMP1']);
            $sheet->setCellValue('J' . $rows, $val['CSTTMP1']);
            $sheet->setCellValue('K' . $rows, $val['CSTTMP2']);
            $sheet->setCellValue('L' . $rows, $val['CSTTMP3']);
            $sheet->setCellValue('M' . $rows, $val['CSTOLY1']);
            $sheet->setCellValue('N' . $rows, $val['CSTOLY2']);
            $sheet->setCellValue('O' . $rows, $val['CSTOLY3']);
            $sheet->setCellValue('P' . $rows, $val['SDTTMP1']);
            $sheet->setCellValue('Q' . $rows, $val['SDTTMP2']);
            $sheet->setCellValue('R' . $rows, $val['SGTTMP1']);
            $sheet->setCellValue('S' . $rows, $val['SGTTMP2']);
            $sheet->setCellValue('T' . $rows, $val['SSPTMP1']);
            $sheet->setCellValue('U' . $rows, $val['SSPTMP2']);
            $sheet->setCellValue('V' . $rows, $val_DECACT1);
            $sheet->setCellValue('W' . $rows, $val_DECACT2);
            $sheet->setCellValue('X' . $rows, $val['DECTMP1']);
            $sheet->setCellValue('Y' . $rows, $val['HWTTMP1']);
            $sheet->setCellValue('Z' . $rows, $this->hmFormat($val['SPHMS1']));
            $sheet->setCellValue('AA' . $rows, $this->hmFormat($val['SPHME1']));
            $sheet->setCellValue('AB' . $rows, $this->hmFormat($val['SPHMS2']));
            $sheet->setCellValue('AC' . $rows, $this->hmFormat($val['SPHME2']));
            $sheet->setCellValue('AD' . $rows, $this->hmFormat($val['DCHMS1']));
            $sheet->setCellValue('AE' . $rows, $this->hmFormat($val['DCHME1']));
            $sheet->setCellValue('AF' . $rows, $this->hmFormat($val['DCHMS2']));
            $sheet->setCellValue('AG' . $rows, $this->hmFormat($val['DCHME2']));
            $sheet->setCellValue('AH' . $rows, $val['OSS1']);
            

            $spreadsheet->getActiveSheet()->getStyle('A'. $rows.':AH'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $rows++;
        }

        

        $spreadsheet->getActiveSheet()->getStyle('V8:W'. $rows)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('C8:L' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('M8:O' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('P8:U' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('X8:Y' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
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
