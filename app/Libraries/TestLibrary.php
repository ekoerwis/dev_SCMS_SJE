<?php

namespace app\Libraries;
use App\Models\test\workflowCoreModel;

Class TestLibrary {

	public $db;
	public $db2;
	public $coreWF;

	public function __construct(){
		$this->db = \Config\Database::connect();
		$this->db2 = \Config\Database::connect('dbtrxi');
		$this->coreWF = new workflowCoreModel();
		helper('stringSQLrep');
	}
	
	public function testsimple(){
		return '<b>This is simple sample from custom library !</b>';
	}

	public function displayData(){
		return '<b>This is from displayData Function !</b>';
	}

	public function roleData(){

		$sql = "SELECT * FROM {prefix_portal}role ";
		$sql = ubahPrefix($sql);
		$data = $this->db->query($sql)->getResultArray();

		return $data;
	}

	public function logData(){
		$sql = 'select * from "SCH_TRXI".workflowlog';
		$data = $this->db2->query($sql)->getResultArray();

		return $data;
	}

	public function dataLibraryModelTest(){

		return $this->coreWF->getWorkflow(1);
	}
}