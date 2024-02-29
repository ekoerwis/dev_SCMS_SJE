<?php

namespace App\Controllers\Content\LogSheet;
use App\Models\Content\LogSheet\logSheetPressStationModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;



class logSheetPressStation extends \App\Controllers\BaseController
{
    public $logSheetPressStationModel;

	public function __construct() {

		parent::__construct();
		
		$this->logSheetPressStationModel = new logSheetPressStationModel;

		$this->data['site_title'] = 'LogSheet Press Station ';

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

		$this->view('Content/LogSheet/logSheetPressStation/logSheetPressStationView.php', $data);
	}

    public function getPress(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->logSheetPressStationModel->getPress());     
    }

    public function dataList(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->logSheetPressStationModel->dataList());        
	}

    

    public function cekDataexportExcelFile(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->logSheetPressStationModel->dataListExcel());        
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

        $titleOrg =$this->logSheetPressStationModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->logSheetPressStationModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];

		$data['Judul'] = 'Laporan '.$this->data['site_title'];
		$data['data_sql'] = $this->logSheetPressStationModel->dataListExcel();

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
                PRESSING STATION
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
        $mpdf->SetHTMLFooter($footerPdf);

        $mpdf->AddPage();

        $html = view('Content/LogSheet/logSheetPressStation/pdfView.php', $data);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($data['Judul'].'.pdf', 'I'); // opens in browser
        //$mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
        //return view('welcome_message');
		
    }


	public function exportExcelFile()
    {
        $this->cekHakAkses('READ_DATA');
        $data = $this->data;
        $data_parameter = $this->logSheetPressStationModel->dataListExcel();

        
        if (empty($_GET['TDATE'])) {
			$data_db['TDATE'] = '';
		} else {
			$data_db['TDATE'] =  date("d-M-y", strtotime($_GET['TDATE']));

            $hari = $this->indonesiaDays(date("l", strtotime($_GET['TDATE'])));
		}

        $userOrganisasi = $this->session->get('userOrganisasi');
        $userid = $userOrganisasi['LOGINID'];

        $titleOrg =$this->logSheetPressStationModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->logSheetPressStationModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];
        

        $fileName = 'writable/filedownload/logSheetPressStation_'.$userid.'.xlsx';
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setShowGridlines(false);

        $spreadsheet
        ->getActiveSheet()
        ->getStyle('A5:AN7')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(50, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AI')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AJ')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AK')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AL')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AM')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('AN')->setWidth(90, 'px');

        $spreadsheet->getActiveSheet()->getStyle('A5:AN7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:AN7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:AN7')->getFont()->setBold(true);

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
        $sheet->setCellValue('F3', 'PRESS STATION LOG SHEET');

        $sheet->mergeCells('M1:O1');
        $sheet->mergeCells('M2:O2');
        $sheet->mergeCells('M3:O3');

        $sheet->setCellValue('M1', 'HARI/TANGGAL');
        $sheet->setCellValue('M2', 'SHIFT');
        $sheet->setCellValue('M3', 'JAM KERJA');
        
        $sheet->setCellValue('P1', ': '.$hari.','.$data_db['TDATE']);
        $sheet->setCellValue('P2', ': ');
        $sheet->setCellValue('P3', ': ');
        // BATAS HEADER

        // TABLE HEADER
        $sheet->mergeCells('A5:A7');
        $sheet->setCellValue('A5', 'JAM');

        $sheet->mergeCells('B5:F7');
        $sheet->setCellValue('B5', 'DIGESTER MASS TEMP( oC )');
        $sheet->setCellValue('B7', 'NO.1');
        $sheet->setCellValue('C7', 'NO.2');
        $sheet->setCellValue('D7', 'NO.3');
        $sheet->setCellValue('E7', 'NO.4');
        $sheet->setCellValue('F7', 'NO.5');

        $sheet->mergeCells('G5:K7');
        $sheet->setCellValue('G5', 'DIGESTER LOAD (AMP)');
        $sheet->setCellValue('G7', 'NO.1');
        $sheet->setCellValue('H7', 'NO.2');
        $sheet->setCellValue('I7', 'NO.3');
        $sheet->setCellValue('J7', 'NO.4');
        $sheet->setCellValue('K7', 'NO.5');        

        $sheet->mergeCells('L5:P7');
        $sheet->setCellValue('L5', 'PRESS CONE PRESSURE (BAR)');
        $sheet->setCellValue('L7', 'NO.1');
        $sheet->setCellValue('M7', 'NO.2');
        $sheet->setCellValue('N7', 'NO.3');
        $sheet->setCellValue('O7', 'NO.4');
        $sheet->setCellValue('P7', 'NO.5');

        $sheet->mergeCells('Q5:AN5');
        $sheet->setCellValue('Q5', 'RUNNING HOUR');

        $sheet->mergeCells('Q6:R6');
        $sheet->setCellValue('Q6', 'PRESS NO.1');
        $sheet->mergeCells('S6:T6');
        $sheet->setCellValue('S6', 'PRESS NO.2');
        $sheet->mergeCells('U6:V6');
        $sheet->setCellValue('U6', 'PRESS NO.3');
        $sheet->mergeCells('W6:X6');
        $sheet->setCellValue('W6', 'PRESS NO.4');
        $sheet->mergeCells('Y6:Z6');
        $sheet->setCellValue('Y6', 'PRESS NO.5');

        $sheet->mergeCells('AA6:AB6');
        $sheet->setCellValue('AA6', 'DIGESTER NO.1');
        $sheet->mergeCells('AC6:AD6');
        $sheet->setCellValue('AC6', 'DIGESTER NO.2');
        $sheet->mergeCells('AE6:AF6');
        $sheet->setCellValue('AE6', 'DIGESTER NO.3');
        $sheet->mergeCells('AG6:AH6');
        $sheet->setCellValue('AG6', 'DIGESTER NO.4');
        $sheet->mergeCells('AI6:AJ6');
        $sheet->setCellValue('AI6', 'DIGESTER NO.5');
        
        $sheet->mergeCells('AK6:AL6');
        $sheet->setCellValue('AK6', 'CBC NO.1');
        $sheet->mergeCells('AM6:AN6');
        $sheet->setCellValue('AM6', 'CBC NO.2');

        $sheet->setCellValue('Q7', 'START');
        $sheet->setCellValue('R7', 'STOP');
        $sheet->setCellValue('S7', 'START');
        $sheet->setCellValue('T7', 'STOP');
        $sheet->setCellValue('U7', 'START');
        $sheet->setCellValue('V7', 'STOP');
        $sheet->setCellValue('W7', 'START');
        $sheet->setCellValue('X7', 'STOP');
        $sheet->setCellValue('Y7', 'START');
        $sheet->setCellValue('Z7', 'STOP');
        $sheet->setCellValue('AA7', 'START');
        $sheet->setCellValue('AB7', 'STOP');
        $sheet->setCellValue('AC7', 'START');
        $sheet->setCellValue('AD7', 'STOP');
        $sheet->setCellValue('AE7', 'START');
        $sheet->setCellValue('AF7', 'STOP');
        $sheet->setCellValue('AG7', 'START');
        $sheet->setCellValue('AH7', 'STOP');
        $sheet->setCellValue('AI7', 'START');
        $sheet->setCellValue('AJ7', 'STOP');
        $sheet->setCellValue('AK7', 'START');
        $sheet->setCellValue('AL7', 'STOP');
        $sheet->setCellValue('AM7', 'START');
        $sheet->setCellValue('AN7', 'STOP');



        
        // $sheet->mergeCells('L5:L6');
        // $spreadsheet->getActiveSheet()->getStyle('L5:L6')->getAlignment()->setWrapText(true);
        // $sheet->setCellValue('L5', 'TOTAL WAKTU');
        // BATAS TABLE HEADER

        $rows = 8;

        $numData=0;
        foreach ($data_parameter as $val) {
            $spreadsheet
            ->getActiveSheet()
            ->getStyle('A8:AN' . $rows)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

            $numData++;

            $sheet->setCellValue('A' . $rows, $val['TIME_DISP']);
            $sheet->setCellValue('B' . $rows, $val['PRSDG_TMP1']);
            $sheet->setCellValue('C' . $rows, $val['PRSDG_TMP2']);
            $sheet->setCellValue('D' . $rows, $val['PRSDG_TMP3']);
            $sheet->setCellValue('E' . $rows, $val['PRSDG_TMP4']);
            $sheet->setCellValue('F' . $rows, $val['PRSDG_TMP5']);
            $sheet->setCellValue('G' . $rows, $val['PRSDG_AMP1']);
            $sheet->setCellValue('H' . $rows, $val['PRSDG_AMP2']);
            $sheet->setCellValue('I' . $rows, $val['PRSDG_AMP3']);
            $sheet->setCellValue('J' . $rows, $val['PRSDG_AMP4']);
            $sheet->setCellValue('K' . $rows, $val['PRSDG_AMP5']);
            $sheet->setCellValue('L' . $rows, $val['PRSSP_CNP1']);
            $sheet->setCellValue('M' . $rows, $val['PRSSP_CNP2']);
            $sheet->setCellValue('N' . $rows, $val['PRSSP_CNP3']);
            $sheet->setCellValue('O' . $rows, $val['PRSSP_CNP4']);
            $sheet->setCellValue('P' . $rows, $val['PRSSP_CNP5']);
            $sheet->setCellValue('Q' . $rows, $this->hmFormat($val['PRSSP_HMS1']));
            $sheet->setCellValue('R' . $rows, $this->hmFormat($val['PRSSP_HME1']));
            $sheet->setCellValue('S' . $rows, $this->hmFormat($val['PRSSP_HMS2']));
            $sheet->setCellValue('T' . $rows, $this->hmFormat($val['PRSSP_HME2']));
            $sheet->setCellValue('U' . $rows, $this->hmFormat($val['PRSSP_HMS3']));
            $sheet->setCellValue('V' . $rows, $this->hmFormat($val['PRSSP_HME3']));
            $sheet->setCellValue('W' . $rows, $this->hmFormat($val['PRSSP_HMS4']));
            $sheet->setCellValue('X' . $rows, $this->hmFormat($val['PRSSP_HME4']));
            $sheet->setCellValue('Y' . $rows, $this->hmFormat($val['PRSSP_HMS5']));
            $sheet->setCellValue('Z' . $rows, $this->hmFormat($val['PRSSP_HME5']));
            $sheet->setCellValue('AA' . $rows, $this->hmFormat($val['PRSDG_HMS1']));
            $sheet->setCellValue('AB' . $rows, $this->hmFormat($val['PRSDG_HME1']));
            $sheet->setCellValue('AC' . $rows, $this->hmFormat($val['PRSDG_HMS2']));
            $sheet->setCellValue('AD' . $rows, $this->hmFormat($val['PRSDG_HME2']));
            $sheet->setCellValue('AE' . $rows, $this->hmFormat($val['PRSDG_HMS3']));
            $sheet->setCellValue('AF' . $rows, $this->hmFormat($val['PRSDG_HME3']));
            $sheet->setCellValue('AG' . $rows, $this->hmFormat($val['PRSDG_HMS4']));
            $sheet->setCellValue('AH' . $rows, $this->hmFormat($val['PRSDG_HME4']));
            $sheet->setCellValue('AI' . $rows, $this->hmFormat($val['PRSDG_HMS5']));
            $sheet->setCellValue('AJ' . $rows, $this->hmFormat($val['PRSDG_HME5']));
            $sheet->setCellValue('AK' . $rows, $this->hmFormat($val['PRSCB_HMS1']));
            $sheet->setCellValue('AL' . $rows, $this->hmFormat($val['PRSCB_HME1']));
            $sheet->setCellValue('AM' . $rows, $this->hmFormat($val['PRSCB_HMS2']));
            $sheet->setCellValue('AN' . $rows, $this->hmFormat($val['PRSCB_HME2']));


            $rows++;
        }
        $spreadsheet->getActiveSheet()->getStyle('A8:A'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('Q8:AN'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('B8:P' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
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

		echo view('Content/LogSheet/logSheetPressStation/pdfView.php', $data);
        
	}


	// batas pakai
	
	


		


}
