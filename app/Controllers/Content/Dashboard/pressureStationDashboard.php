<?php

namespace App\Controllers\Content\Dashboard;
use App\Models\Content\Dashboard\pressureStationDashboardModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;


class pressureStationDashboard extends \App\Controllers\BaseController
{
    public $pressureStationDashboardModel;

	public function __construct() {

		parent::__construct();
		
		$this->pressureStationDashboardModel = new pressureStationDashboardModel;

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
        // $this->addJs (  $this->config->baseURL . 'public/vendors/mqttws/mqttws31.js');
        // $this->addJs (  $this->config->baseURL . 'public/vendors/mqttws/paramConnectionSMA.js');
        $this->addJs (  $this->config->baseURL . 'public/vendors/paho-mqtt/paho-mqtt.js');
		
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

        // $data['dataGraph']=$this->pressureStationDashboardModel->dataGraph();

        $data['hostname_mqtt']= "10.20.38.199";
        $data['port_mqtt']="9001";
        $data['clientID_mqtt']="HARI_TEST_WS1"."_".$this->user['ID_USER'].'_' .strtotime('now');
        $data['topic_mqtt_PRSTMPDIG1']="PRSTMPDIG1";
        $data['topic_mqtt_PRSPSSSCP1']="PRSPSSSCP1";
        $data['topic_mqtt_PRSAMPDIG1']="PRSAMPDIG1";

		$data['topic_mqtt_PRSTMPDIG2']="PRSTMPDIG2";
        $data['topic_mqtt_PRSPSSSCP2']="PRSPSSSCP2";
        $data['topic_mqtt_PRSAMPDIG2']="PRSAMPDIG2";

		$data['topic_mqtt_PRSTMPDIG3']="PRSTMPDIG3";
        $data['topic_mqtt_PRSPSSSCP3']="PRSPSSSCP3";
        $data['topic_mqtt_PRSAMPDIG3']="PRSAMPDIG3";

		$data['topic_mqtt_PRSTMPDIG4']="PRSTMPDIG4";
        $data['topic_mqtt_PRSPSSSCP4']="PRSPSSSCP4";
        $data['topic_mqtt_PRSAMPDIG4']="PRSAMPDIG4";

		$data['topic_mqtt_PRSTMPDIG5']="PRSTMPDIG5";
        $data['topic_mqtt_PRSPSSSCP5']="PRSPSSSCP5";
        $data['topic_mqtt_PRSAMPDIG5']="PRSAMPDIG5";

		$data['topic_mqtt_PRSTMPDIG6']="PRSTMPDIG6";
        $data['topic_mqtt_PRSPSSSCP6']="PRSPSSSCP6";
        $data['topic_mqtt_PRSAMPDIG6']="PRSAMPDIG6";

        // $xxx=strtotime('now');
        // echo "<script>console.log('".$this->user['ID_USER'].'_' .strtotime('now')."')</script>";

		$this->view('Content/Dashboard/pressureStationDashboard/pressureStationDashboardView.php', $data);
	}

    public function getData(){
		$this->cekHakAkses('READ_DATA');
		
        echo json_encode($this->pressureStationDashboardModel->dataGraph());

	}

	public function getDataBpv(){
		$this->cekHakAkses('READ_DATA');
		
        echo json_encode($this->pressureStationDashboardModel->getDataBpv());

	}

	public function getDataTurbin(){
		$this->cekHakAkses('READ_DATA');
		
        echo json_encode($this->pressureStationDashboardModel->getDataTurbin());

	}

    // batas pakai


}
