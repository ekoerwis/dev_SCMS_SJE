<?php

namespace App\Controllers\Content\Report\dailyLogSheet;
use App\Models\Content\Report\dailyLogSheet\dailyLSPressStationModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;



class dailyLSPressStation extends \App\Controllers\BaseController
{
    public $dailyLSPressStationModel;

	public function __construct() {

		parent::__construct();
		
		$this->dailyLSPressStationModel = new dailyLSPressStationModel;

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

		$this->view('Content/Report/dailyLogSheet/dailyLSPressStation/dailyLSPressStationView.php', $data);
	}

    public function getPress(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->dailyLSPressStationModel->getPress());     
    }

    public function dataList(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->dailyLSPressStationModel->dataList());        
	}

    

    public function cekDataexportExcelFile(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->dailyLSPressStationModel->dataListExcel());        
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

        $titleOrg =$this->dailyLSPressStationModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->dailyLSPressStationModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];

		$data['Judul'] = 'Laporan '.$this->data['site_title'];
		$data['data_sql'] = $this->dailyLSPressStationModel->dataListExcel();

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
                PRESSING STATION <br> DAILY LOGSHEET
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

        $html = view('Content/Report/dailyLogSheet/dailyLSPressStation/pdfView.php', $data);
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
        $data_parameter = $this->dailyLSPressStationModel->dataListExcel();

        
        if (empty($_GET['TDATE'])) {
			$data_db['TDATE'] = '';
		} else {
			$data_db['TDATE'] =  date("d-M-y", strtotime($_GET['TDATE']));

            $hari = $this->indonesiaDays(date("l", strtotime($_GET['TDATE'])));
		}
        

        $userOrganisasi = $this->session->get('userOrganisasi');
        $userid = $userOrganisasi['LOGINID'];

        $titleOrg =$this->dailyLSPressStationModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->dailyLSPressStationModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];
        

        $fileName = 'writable/filedownload/dailyLSPressStation_'.$userid.'.xlsx';
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setShowGridlines(false);

        $spreadsheet
        ->getActiveSheet()
        ->getStyle('A5:AO7')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(100, 'px');
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
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(50, 'px');
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
        $spreadsheet->getActiveSheet()->getColumnDimension('AO')->setWidth(90, 'px');

        $spreadsheet->getActiveSheet()->getStyle('A5:AO7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:AO7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:AO7')->getFont()->setBold(true);

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
        $sheet->setCellValue('F3', 'PRESS STATION DAILY LOG SHEET');

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
        $sheet->setCellValue('A5', 'TANGGAL');

        $sheet->mergeCells('B5:B7');
        $sheet->setCellValue('B5', 'JAM');

        $sheet->mergeCells('C5:G6');
        $sheet->setCellValue('C5', 'DIGESTER MASS TEMP( oC )');
        $sheet->setCellValue('C7', 'NO.1');
        $sheet->setCellValue('D7', 'NO.2');
        $sheet->setCellValue('E7', 'NO.3');
        $sheet->setCellValue('F7', 'NO.4');
        $sheet->setCellValue('G7', 'NO.5');

        $sheet->mergeCells('H5:L6');
        $sheet->setCellValue('H5', 'DIGESTER LOAD (AMP)');
        $sheet->setCellValue('H7', 'NO.1');
        $sheet->setCellValue('I7', 'NO.2');
        $sheet->setCellValue('J7', 'NO.3');
        $sheet->setCellValue('K7', 'NO.4');
        $sheet->setCellValue('L7', 'NO.5');        

        $sheet->mergeCells('M5:Q6');
        $sheet->setCellValue('M5', 'PRESS CONE PRESSURE (BAR)');
        $sheet->setCellValue('M7', 'NO.1');
        $sheet->setCellValue('N7', 'NO.2');
        $sheet->setCellValue('O7', 'NO.3');
        $sheet->setCellValue('P7', 'NO.4');
        $sheet->setCellValue('Q7', 'NO.5');

        $sheet->mergeCells('R5:AO5');
        $sheet->setCellValue('R5', 'RUNNING HOUR');

        $sheet->mergeCells('R6:S6');
        $sheet->setCellValue('R6', 'PRESS NO.1');
        $sheet->mergeCells('T6:U6');
        $sheet->setCellValue('T6', 'PRESS NO.2');
        $sheet->mergeCells('V6:W6');
        $sheet->setCellValue('V6', 'PRESS NO.3');
        $sheet->mergeCells('X6:Y6');
        $sheet->setCellValue('X6', 'PRESS NO.4');
        $sheet->mergeCells('Z6:AA6');
        $sheet->setCellValue('Z6', 'PRESS NO.5');

        $sheet->mergeCells('AB6:AC6');
        $sheet->setCellValue('AB6', 'DIGESTER NO.1');
        $sheet->mergeCells('AD6:AE6');
        $sheet->setCellValue('AD6', 'DIGESTER NO.2');
        $sheet->mergeCells('AF6:AG6');
        $sheet->setCellValue('AF6', 'DIGESTER NO.3');
        $sheet->mergeCells('AH6:AI6');
        $sheet->setCellValue('AH6', 'DIGESTER NO.4');
        $sheet->mergeCells('AJ6:AK6');
        $sheet->setCellValue('AJ6', 'DIGESTER NO.5');
        
        $sheet->mergeCells('AL6:AM6');
        $sheet->setCellValue('AL6', 'CBC NO.1');
        $sheet->mergeCells('AN6:AO6');
        $sheet->setCellValue('AN6', 'CBC NO.2');

        $sheet->setCellValue('R7', 'START');
        $sheet->setCellValue('S7', 'STOP');
        $sheet->setCellValue('T7', 'START');
        $sheet->setCellValue('U7', 'STOP');
        $sheet->setCellValue('V7', 'START');
        $sheet->setCellValue('W7', 'STOP');
        $sheet->setCellValue('X7', 'START');
        $sheet->setCellValue('Y7', 'STOP');
        $sheet->setCellValue('Z7', 'START');
        $sheet->setCellValue('AA7', 'STOP');
        $sheet->setCellValue('AB7', 'START');
        $sheet->setCellValue('AC7', 'STOP');
        $sheet->setCellValue('AD7', 'START');
        $sheet->setCellValue('AE7', 'STOP');
        $sheet->setCellValue('AF7', 'START');
        $sheet->setCellValue('AG7', 'STOP');
        $sheet->setCellValue('AH7', 'START');
        $sheet->setCellValue('AI7', 'STOP');
        $sheet->setCellValue('AJ7', 'START');
        $sheet->setCellValue('AK7', 'STOP');
        $sheet->setCellValue('AL7', 'START');
        $sheet->setCellValue('AM7', 'STOP');
        $sheet->setCellValue('AN7', 'START');
        $sheet->setCellValue('AO7', 'STOP');



        
        // $sheet->mergeCells('L5:L6');
        // $spreadsheet->getActiveSheet()->getStyle('L5:L6')->getAlignment()->setWrapText(true);
        // $sheet->setCellValue('L5', 'TOTAL WAKTU');
        // BATAS TABLE HEADER

        $rows = 8;

        $numData=0;
        foreach ($data_parameter as $val) {
            $spreadsheet
            ->getActiveSheet()
            ->getStyle('A8:AO' . $rows)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

            $numData++;

            $sheet->setCellValue('A' . $rows, $val['POSTDT']);
            $sheet->setCellValue('B' . $rows, $val['TIME_DISP']);
            $sheet->setCellValue('C' . $rows, $val['PRSDG_TMP1']);
            $sheet->setCellValue('D' . $rows, $val['PRSDG_TMP2']);
            $sheet->setCellValue('E' . $rows, $val['PRSDG_TMP3']);
            $sheet->setCellValue('F' . $rows, $val['PRSDG_TMP4']);
            $sheet->setCellValue('G' . $rows, $val['PRSDG_TMP5']);
            $sheet->setCellValue('H' . $rows, $val['PRSDG_AMP1']);
            $sheet->setCellValue('I' . $rows, $val['PRSDG_AMP2']);
            $sheet->setCellValue('J' . $rows, $val['PRSDG_AMP3']);
            $sheet->setCellValue('K' . $rows, $val['PRSDG_AMP4']);
            $sheet->setCellValue('L' . $rows, $val['PRSDG_AMP5']);
            $sheet->setCellValue('M' . $rows, $val['PRSSP_CNP1']);
            $sheet->setCellValue('N' . $rows, $val['PRSSP_CNP2']);
            $sheet->setCellValue('O' . $rows, $val['PRSSP_CNP3']);
            $sheet->setCellValue('P' . $rows, $val['PRSSP_CNP4']);
            $sheet->setCellValue('Q' . $rows, $val['PRSSP_CNP5']);
            $sheet->setCellValue('R' . $rows, $this->hmFormat($val['PRSSP_HMS1']));
            $sheet->setCellValue('S' . $rows, $this->hmFormat($val['PRSSP_HME1']));
            $sheet->setCellValue('T' . $rows, $this->hmFormat($val['PRSSP_HMS2']));
            $sheet->setCellValue('U' . $rows, $this->hmFormat($val['PRSSP_HME2']));
            $sheet->setCellValue('V' . $rows, $this->hmFormat($val['PRSSP_HMS3']));
            $sheet->setCellValue('W' . $rows, $this->hmFormat($val['PRSSP_HME3']));
            $sheet->setCellValue('X' . $rows, $this->hmFormat($val['PRSSP_HMS4']));
            $sheet->setCellValue('Y' . $rows, $this->hmFormat($val['PRSSP_HME4']));
            $sheet->setCellValue('Z' . $rows, $this->hmFormat($val['PRSSP_HMS5']));
            $sheet->setCellValue('AA' . $rows, $this->hmFormat($val['PRSSP_HME5']));
            $sheet->setCellValue('AB' . $rows, $this->hmFormat($val['PRSDG_HMS1']));
            $sheet->setCellValue('AC' . $rows, $this->hmFormat($val['PRSDG_HME1']));
            $sheet->setCellValue('AD' . $rows, $this->hmFormat($val['PRSDG_HMS2']));
            $sheet->setCellValue('AE' . $rows, $this->hmFormat($val['PRSDG_HME2']));
            $sheet->setCellValue('AF' . $rows, $this->hmFormat($val['PRSDG_HMS3']));
            $sheet->setCellValue('AG' . $rows, $this->hmFormat($val['PRSDG_HME3']));
            $sheet->setCellValue('AH' . $rows, $this->hmFormat($val['PRSDG_HMS4']));
            $sheet->setCellValue('AI' . $rows, $this->hmFormat($val['PRSDG_HME4']));
            $sheet->setCellValue('AJ' . $rows, $this->hmFormat($val['PRSDG_HMS5']));
            $sheet->setCellValue('AK' . $rows, $this->hmFormat($val['PRSDG_HME5']));
            $sheet->setCellValue('AL' . $rows, $this->hmFormat($val['PRSCB_HMS1']));
            $sheet->setCellValue('AM' . $rows, $this->hmFormat($val['PRSCB_HME1']));
            $sheet->setCellValue('AN' . $rows, $this->hmFormat($val['PRSCB_HMS2']));
            $sheet->setCellValue('AO' . $rows, $this->hmFormat($val['PRSCB_HME2']));


            $rows++;
        }
        $spreadsheet->getActiveSheet()->getStyle('A8:B'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('R8:AO'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('C8:Q' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
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

		echo view('Content/Report/dailyLogSheet/dailyLSPressStation/pdfView.php', $data);
        
	}


	// batas pakai
	
	


		


}
