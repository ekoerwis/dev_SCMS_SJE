<?php 

namespace App\Controllers\Builtin;

use App\Controllers\BaseController;
use App\Models\Builtin\UserImportEPMSModel;
use App\Config\Database;

class UserImportEPMS extends BaseController
{
	protected $UserImportEPMSModel;

	public function __construct() {
		
		parent::__construct();
		$this->mustLoggedIn();
		
		$this->UserImportEPMSModel = new UserImportEPMSModel;
		$this->data['site_title'] = 'xxxx';

		$this->addStyle ( $this->config->baseURL.'public/vendors/jquery-easyui-1.9.12/themes/icon.css');
		$this->addStyle ( $this->config->baseURL.'public/vendors/jquery-easyui-1.9.12/themes/bootstrap/easyui.css');
		$this->addJs ( $this->config->baseURL.'public/vendors/jquery-easyui-1.9.12/jquery.min.js');
		$this->addJs ( $this->config->baseURL.'public/vendors/jquery-easyui-1.9.12/jquery.easyui.min.js');
		$this->addJs ( $this->config->baseURL.'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-groupview.js');

		$this->addJs ( $this->config->baseURL.'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-detailview.js');


		// menghilangkan error overlay ketika di F12. (belum tw efek langsung nya kemana)
		$this->addJs ( $this->config->baseURL.'public/vendors/overlayscrollbars/jquery.overlayScrollbars.min.js');

		$this->addJs ( $this->config->baseURL.'public/themes/modern/js/message-easyui-custom.js');

		$this->addStyle ( $this->config->baseURL . 'public/themes/modern/css/easyui-custom.css');
		
		helper(['cookie', 'form','stringSQLrep']);
	}

	public function index()
	{
		$this->cekHakAkses('READ_DATA');
		$data = $this->data;
		$data['stat_EPMS']=$this->tipeLoginCompSite;

		$tinggiContent = 0;
		$data['tinggi_dg']='';
		$tinggiContent = $this->session->get('dg_height');
		
		if(intval($tinggiContent) > 0) {
			$data['tinggi_dg']= 'height:'.$tinggiContent.'px';
		}

		$this->view('Builtin/UserImportEPMSView.php', $data);
	}

	public function dataList(){
        $this->cekHakAkses('READ_DATA'); 
		echo json_encode($this->UserImportEPMSModel->dataList());        
	}

	public function importProses(){
		$countData = 0;
		$countSuccess = 0;
		$countError = 0;
		$statUpload = '';
		$msg='';

		if(isset($_POST['barisData']) or !empty($_POST['barisData'])){
			$data = $_POST['barisData'];
			$jumlahData = count($data);

			for($i=0 ; $i<$jumlahData; $i++){
				$countData++;
				$input = $this->UserImportEPMSModel->importProses($data[$i]);

				if(strtoupper($input) == 'OK'){
					$countSuccess++;
				} else {
					$countError++;
				}
			}

			if($countError > 0){
				$statUpload = 'Warning';
			} else {
				$statUpload = 'Success';
			}

			$msgUpload['status'] = $statUpload;
			$msgUpload['countSuccess'] = $countSuccess;
			$msgUpload['countError'] = $countError;
			$msgUpload['msg'] = 'Data Masuk : '.$countSuccess. ' , Data Error : '.$countError.'';

		} else {
			$msgUpload['status'] = 'Error';
			$msgUpload['countSuccess'] = 0;
			$msgUpload['countError'] = 0;
			$msgUpload['msg'] = 'Data Kosong';
		}

		echo json_encode($msgUpload);
    }
 
	//--------------------------------------------------------------------

}



