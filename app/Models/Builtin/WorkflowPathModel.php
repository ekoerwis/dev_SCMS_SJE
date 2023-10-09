<?php

namespace App\Models\Builtin;

class WorkflowPathModel extends \App\Models\BaseModel
{

	public function __construct() {
		parent::__construct();
    $this->db2 = db_connect("dbtrxi");

	}


  // Fungsi List  --------------------------------------------------------------
	public function getWorkflowPath()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'wfpath_id';
    $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		//$$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		// $p_wfdesc= isset($_POST['wf_id']) ? pg_escape_string ($_POST['wf_id']) :'';
		$offset = ($page-1)*$rows;
		$result = array();

		$sql = "SELECT count(*)jumlah FROM {prefix_trxi}workflowpath";
		$sql = $this->ubahPrefix($sql);
		$sql = $this->db2->query($sql)->getRowArray();

		$result["total"] = $sql['jumlah'];

		$sql = "SELECT  wfpath_id, a.wf_id, b.wf_desc,role_id, wf_lvl
						FROM {prefix_trxi}workflowpath a,{prefix_trxi}workflow b
						WHERE a.wf_id = b.wf_id
		ORDER BY b.wf_desc,wf_lvl, $sort $order  LIMIT $rows OFFSET $offset";

		$sql=$this->ubahPrefix($sql);
		$sql = $this->db2->query($sql)->getResultArray();

		$data = array();

		foreach ($sql as $key ) {

			$sqldetail = "SELECT id_role, nama_role, judul_role, keterangan, id_module
										FROM {prefix_portal}role WHERE id_role = '".$key['role_id']."'
										ORDER BY id_role";
			$sqldetail = $this->ubahPrefix($sqldetail);
			$sqldetail = $this->db->query($sqldetail)->getRowArray();

			$datadetailrow = ['nama_role' => $sqldetail['nama_role']];

			$datalengkaprow = array_merge($key,$datadetailrow);

			$data[] =  $datalengkaprow;
		}

		$result['rows'] = $data;
		return $result;

	}
	// Fungsi Select Row  -------------------------------------------------------
	public function getworkflowPathById($id) {

		$sql = 'SELECT * FROM {prefix_trxi}workflowpath WHERE wfpath_id = ?';
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

		$sql = "SELECT count(*)jumlah FROM {prefix_trxi}workflowpath
						WHERE lower(wf_desc) like '%$q%'";
		$sql = $this->ubahPrefix($sql);
		$sql = $this->db2->query($sql)->getRowArray();

		$result["total"] = $sql['jumlah'];

		$sql = "SELECT * FROM {prefix_trxi}workflowpath
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
		$tablename = '{prefix_trxi}workflowpath';
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
		$data_db['wf_id'] = $_POST['wf_id'];
		$data_db['role_id'] = $_POST['role_id'];
		$data_db['wf_lvl'] = $_POST['wf_lvl'];

		$tablename = '{prefix_trxi}workflowpath';
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
			$data_db['wfpath_id'] = $_POST['wfpath_id'];
  		$data_db['wf_id'] = $_POST['wf_id'];
  		$data_db['role_id'] = $_POST['role_id'];
  		$data_db['wf_lvl'] = $_POST['wf_lvl'];

  		$tablename = '{prefix_trxi}workflowpath';
  		$tablename=$this->ubahPrefix($tablename);
  		$input = $this->db2->table($tablename)->update($data_db,['wfpath_id' => $_POST['wfpath_id']]);

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
		$tablename ='{prefix_trxi}workflowpath';
		$tablename=$this->ubahPrefix($tablename);
		$result = $this->db2->table($tablename)->delete(['wfpath_id' => $_POST['id']]);
	}

}
?>
