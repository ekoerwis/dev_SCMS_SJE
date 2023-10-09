<?php

namespace App\Models\Builtin;

class WorkflowApprovalModel extends \App\Models\BaseModel
{

	public function __construct() {
		parent::__construct();
    $this->db2 = db_connect("dbtrxi");

	}
	public function cekjobcode(){
		$sql="SELECT CASE WHEN COUNT(jobcode) > 0
		THEN '1' ELSE '0' END jobcode
		FROM {prefix_trxi}workflow
		WHERE jobcode='".$jobcode."' ";
		$sql = $this->ubahPrefix($sql);
		$query=$this->db2->query($sql);
		return $query->getRow();
	}
  // Fungsi List  --------------------------------------------------------------
	public function getComboBox()
	{
		$sql = "SELECT * FROM {prefix_trxi}workflow
		ORDER BY wf_id";
		$sql=$this->ubahPrefix($sql);
		$sql = $this->db2->query($sql)->getResultArray();
		return $sql;
	}

	public function getWorkflow()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'wf_id';
    $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		//$$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$p_wfdesc= isset($_POST['wf_desc']) ? pg_escape_string ($_POST['wf_desc']) :'';
		$offset = ($page-1)*$rows;
		$result = array();


		$sql = "SELECT count(*)jumlah FROM {prefix_trxi}workflow";
		$sql = $this->ubahPrefix($sql);
		$sql = $this->db2->query($sql)->getRowArray();

		$result["total"] = $sql['jumlah'];

		$sql = "SELECT * FROM {prefix_trxi}workflow
		WHERE wf_desc like '$p_wfdesc%'
		ORDER BY $sort $order  LIMIT $rows OFFSET $offset";
		$sql=$this->ubahPrefix($sql);
		$sql = $this->db2->query($sql)->getResultArray();

		$items = array();
		//if(is_array($sql)){
		foreach($sql as $row ){
			$items = $row;
			//	}
		}

		$result['rows'] = $sql;
		return $result;
	}
	// Fungsi Select Row  -------------------------------------------------------
	public function getworkflowById($id) {

		$sql = 'SELECT * FROM {prefix_trxi}workflow WHERE wf_id = ?';
		$sql=$this->ubahPrefix($sql);
		$result = $this->db2->query($sql, trim($id))->getRowArray();
		return $result;
	}
	// Fungsi Filter  -----------------------------------------------------------
	public function getComboGrid()
	{
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

		$offset = ($page-1)*$rows;
		$result = array();

		$sql = "SELECT count(*)jumlah FROM {prefix_trxi}workflow
						WHERE lower(wf_desc) like '%$q%'";
		$sql = $this->ubahPrefix($sql);
		$sql = $this->db2->query($sql)->getRowArray();

		$result["total"] = $sql['jumlah'];

		$sql = "SELECT * FROM {prefix_trxi}workflow
		WHERE lower(wf_desc) like '%$q%'
		ORDER BY wf_desc  LIMIT $rows OFFSET $offset";
		$sql=$this->ubahPrefix($sql);
		$sql = $this->db2->query($sql)->getResultArray();

		$items = array();
		//if(is_array($sql)){
		foreach($sql as $row ){
			$items = $row;
			//	}
		}

		$result['rows'] = $sql;
		return $result;
	}
	// Fungsi Rule Validation  ---------------------------------------------------
	public function rules() {
		$tablename = '{prefix_trxi}workflow';
		$tablename=$this->ubahPrefix($tablename);
		//$tablename = $this->db2->table($tablename);
		//return $tablename->getRow();
		$validationRules = [
			'jobcode' => "required|is_unique_with_schemas[$tablename@jobcode]"
		];

		return $validationRules;
	}
	// Fungsi Save  -------------------------------------------------------------
	public function saveData()
	{
		//	session();
		//	$data_db['validation'] = \Config\Services::validation();
		$data_db['wf_desc'] = $_POST['wf_desc'];
		$data_db['wf_stepbystepdown'] = $_POST['wf_stepbystepdown'];
		$data_db['wf_stepbystepup'] = $_POST['wf_stepbystepup'];
		$data_db['wf_editable'] = $_POST['wf_editable'];
		$data_db['wf_lookup'] = $_POST['wf_lookup'];

		$tablename = '{prefix_trxi}workflow';
		$tablename=$this->ubahPrefix($tablename);
		$input = $this->db2->table($tablename)->insert($data_db);

		if ($input) {
					$result['msg']['status'] = 'ok';
					$result['msg']['content'] = 'Data berhasil disimpan';
		} else {
					$result['msg']['status'] = 'error';
					$result['msg']['content'] = 'Data gagal disimpan';
		}
	// }
	return $result;
	}

	// Fungsi Update  -----------------------------------------------------------
	public function updateData()
	{
			$data_db['wf_id'] = $_POST['wf_id'];
  		$data_db['wf_desc'] = $_POST['wf_desc'];
  		$data_db['wf_stepbystepdown'] = $_POST['wf_stepbystepdown'];
  		$data_db['wf_stepbystepup'] = $_POST['wf_stepbystepup'];
  		$data_db['wf_editable'] = $_POST['wf_editable'];
  		$data_db['wf_lookup'] = $_POST['wf_lookup'];

  		$tablename = '{prefix_trxi}workflow';
  		$tablename=$this->ubahPrefix($tablename);
  		$input = $this->db2->table($tablename)->update($data_db,['wf_id' => $_POST['wf_id']]);

  		if ($input) {
  					$result['msg']['status'] = 'ok';
  					$result['msg']['content'] = 'Data Berhasil di Update';
  		} else {
  					$result['msg']['status'] = 'error';
  					$result['msg']['content'] = 'Data Gagal di Update';
  		}
  	// }
  	return $result;
  	}

	// Fungsi Delete  -----------------------------------------------------------
	public function deleteData()
	{
		$tablename ='{prefix_trxi}workflow';
		$tablename=$this->ubahPrefix($tablename);
		$result = $this->db2->table($tablename)->delete(['wf_id' => $_POST['id']]);
	}

}
?>
