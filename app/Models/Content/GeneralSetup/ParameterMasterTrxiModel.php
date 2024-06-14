<?php

namespace App\Models\Content\GeneralSetup;

class ParameterMasterTrxiModel extends \App\Models\BaseModel
{
	protected $db2;

	public function __construct()
	{
		parent::__construct();
		$this->db2 = db_connect("default");
	}

	public function getList()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'PARAMETERCODE ';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		$w_modulecode = '';
        $MODULECODE = isset($_POST['MODULECODE']) ? strval ($_POST['MODULECODE']) :'';
		
		if($MODULECODE !=''){
			$w_modulecode = " AND GROUPINIT = '$MODULECODE' ";
		}

        $p_searchkeyword_ORI = isset($_POST['SEARCH_KEYWORD']) ? strval ($_POST['SEARCH_KEYWORD']) :'';
    	$p_searchkeyword=trim($p_searchkeyword_ORI," ");

		$limit = $page * $rows;
		$offset = ($page - 1) * $rows;

		$mainSql = "SELECT * FROM (
            SELECT PARAMETERCODE, PARAMETERNAME, CONTROLSYSTEM, INPUTBY, INPUTDATE, UPDATEBY, UPDATEDATE, UOM, VALUE1, VALUE2, VALUE3, INACTIVE, INACTIVEDATE , SUBSTR(PARAMETERCODE,1,LENGTH(PARAMETERCODE)-NVL(LENGTH(REGEXP_REPLACE(PARAMETERCODE, '[^[:digit:]]', '')),0)) GROUPINIT FROM PARAMETER
        ) 
        WHERE  ( LOWER(PARAMETERCODE)  LIKE LOWER('%$p_searchkeyword%') OR LOWER(PARAMETERNAME) LIKE LOWER('%$p_searchkeyword%') ) $w_modulecode 
         ";

		$result = array();

		$sql = "SELECT count(*) AS JUMLAH FROM ($mainSql)";
		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM (SELECT PARAMETERCODE, PARAMETERNAME, CONTROLSYSTEM, INPUTBY, INPUTDATE, UPDATEBY, UPDATEDATE, UOM, VALUE1, VALUE2, VALUE3, INACTIVE, INACTIVEDATE, ROWNUM AS RNUM FROM (
        $mainSql ORDER BY $sort $order
        ) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";

        $dataFull = array();
		$data = $this->db2->query($sql)->getResultArray();

        foreach ($data as $data) {
            // $dataPlot['dataDetail'] = array();
			$dataDetail['dataDetail'] = $this->getDetailParameterMasterTrxi($data['PARAMETERCODE']);

			$data = array_merge($data, $dataDetail);

			array_push($dataFull, $data);
		}

		$result['rows'] = $dataFull;

		return $result;
	}

    public function getDetailParameterMasterTrxi($idReport = '')
	{
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'PARAMETERCODE,SEQ_NO, PARAMETERVALUECODE';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		if ($idReport == '') {
			$id = isset($_GET['id']) ? strval($_GET['id']) : '';
		} else {
			$id = $idReport;
		}

		$mainSql = "SELECT * FROM (
           SELECT A.PARAMETERCODE, A.PARAMETERVALUECODE, A.PARAMETERVALUE, A.INPUTBY, A.INPUTDATE, A.UPDATEBY, A.UPDATEDATE, A.UOM, A.SEQ_NO, A.RATE, A.INACTIVE, A.INACTIVEDATE, A.MIN, A.MAX, A.VALUE1, A.VALUE_TEXT, A.VALUE2 FROM PARAMETERVALUE A
        ) WHERE PARAMETERCODE = '$id' ORDER BY $sort $order
         ";

		$result = array();

		$result = $this->db2->query($mainSql)->getResultArray();

		return $result;
	}

	

	public function getModuleList()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'CODE';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';

		$limit = $page * $rows;
		$offset = ($page - 1) * $rows;

        // $userOrganisasi=$this->session->get('userOrganisasi');
		// $sql_security="CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('".$userOrganisasi['LOGINID']."', '".$userOrganisasi['PASSWORD']."', '".$userOrganisasi['COMPANYID']."', '".$userOrganisasi['COMPANYSITEID']."');";
		

		$mainSql = "SELECT * FROM (
        SELECT DISTINCT substr(parametercode,1,length(PARAMETERCODE)-nvl(length(regexp_replace(parametercode, '[^[:digit:]]', '')),0)) CODE FROM PARAMETER
        ) 
        WHERE  LOWER(CODE) LIKE LOWER('%$q%')
         ";

		$result = array();

		$sql = "SELECT count(*) AS JUMLAH FROM ($mainSql)";
		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM (SELECT CODE, ROWNUM AS RNUM FROM (
        $mainSql ORDER BY $sort $order
        ) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";

		$data = $this->db2->query($sql)->getResultArray();

		$result['rows'] = $data;

		return $result;
	}


    public function getParameterById($id='')
	{
		$mainSql = "SELECT A.PARAMETERCODE, A.PARAMETERNAME, A.CONTROLSYSTEM, A.INPUTBY, A.INPUTDATE, A.UPDATEBY, A.UPDATEDATE, A.UOM, A.VALUE1, A.VALUE2, A.VALUE3, A.INACTIVE, A.INACTIVEDATE  FROM PARAMETER A  WHERE PARAMETERCODE = '$id'";

		$result = array();
        
        $data = $this->db2->query($mainSql)->getResultArray();

		$result  = $data;

		return $result;
	}

    public function getUOM()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'UNITOFMEASURECODE';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';

		$limit = $page * $rows;
		$offset = ($page - 1) * $rows;

        // $userOrganisasi=$this->session->get('userOrganisasi');
		// $sql_security="CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('".$userOrganisasi['LOGINID']."', '".$userOrganisasi['PASSWORD']."', '".$userOrganisasi['COMPANYID']."', '".$userOrganisasi['COMPANYSITEID']."');";
		

		$mainSql = "SELECT * FROM (
        SELECT 'UOM1' UNITOFMEASURECODE,'UOM 01' UNITOFMEASUREDESC FROM DUAL
		UNION ALL 
		SELECT 'UOM2' UNITOFMEASURECODE,'UOM 02' UNITOFMEASUREDESC FROM DUAL
        ) 
        WHERE  LOWER(UNITOFMEASURECODE) LIKE LOWER('%$q%') OR LOWER(UNITOFMEASUREDESC) LIKE LOWER('%$q%')
         ";

		$result = array();

		$sql = "SELECT count(*) AS JUMLAH FROM ($mainSql)";
		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM (SELECT UNITOFMEASURECODE, UNITOFMEASUREDESC, ROWNUM AS RNUM FROM (
        $mainSql ORDER BY $sort $order
        ) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";

		$data = $this->db2->query($sql)->getResultArray();

		$result['rows'] = $data;

		return $result;
	}

	


    public function getHeaderById($id='')
	{
		$mainSql = "SELECT XX.PARAMETERCODE, XX.PARAMETERNAME, XX.CONTROLSYSTEM, XX.INPUTBY, XX.INPUTDATE, XX.UPDATEBY, XX.UPDATEDATE, XX.UOM, XX.UOM UOMDESC, XX.VALUE1, XX.VALUE2, XX.VALUE3, XX.INACTIVE, XX.INACTIVEDATE 
		FROM PARAMETER XX WHERE PARAMETERCODE = '$id'";

		$result = array();
        
        $data = $this->db2->query($mainSql)->getRowArray();

		$result  = $data;

		return $result;
	}

	
    public function getDetailById($id='')
	{
		$mainSql = "SELECT * FROM PARAMETERVALUE WHERE PARAMETERCODE = '$id'";

		$result = array();
        
        $data = $this->db2->query($mainSql)->getResultArray();

		$result  = $data;

		return $result;
	}

	
    public function getDetailByIdForm($id='')
	{
		$mainSql = "SELECT PARAMETERCODE, PARAMETERVALUECODE, PARAMETERVALUE, UOM UOM_D, SEQ_NO SEQ_NO_D, RATE RATE_D, INACTIVE INACTIVE_D, INACTIVEDATE INACTIVEDATE_D, MIN MIN_D, MAX MAX_D, VALUE1 VALUE1_D, VALUE2 VALUE2_D, VALUE_TEXT VALUE_TEXT_D, INPUTBY, INPUTDATE, UPDATEBY, UPDATEDATE FROM PARAMETERVALUE WHERE PARAMETERCODE = '$id' ORDER BY SEQ_NO, PARAMETERVALUECODE";

		$result = array();
        
        $data = $this->db2->query($mainSql)->getResultArray();

		$result  = $data;

		return $result;
	}

	
    public function getDetailByPK($PARAMETERCODE='',$PARAMETERVALUECODE='')
	{
		$mainSql = "SELECT PARAMETERCODE, PARAMETERVALUECODE, PARAMETERVALUE, UOM UOM_D, SEQ_NO SEQ_NO_D, RATE RATE_D, INACTIVE INACTIVE_D, INACTIVEDATE INACTIVEDATE_D, MIN MIN_D, MAX MAX_D, VALUE1 VALUE1_D, VALUE2 VALUE2_D, VALUE_TEXT VALUE_TEXT_D, INPUTBY, INPUTDATE, UPDATEBY, UPDATEDATE FROM PARAMETERVALUE WHERE PARAMETERCODE = '$PARAMETERCODE' AND PARAMETERVALUECODE = '$PARAMETERVALUECODE'";

		$result = array();
        
        $data = $this->db2->query($mainSql)->getRowArray();

		$result  = $data;

		return $result;
	}

	// Fungsi Update  -------------------------------------------------------------
	public function updateData()
	{
		

		$PARAMETERCODE = isset($_POST['PARAMETERCODE']) ? strval($_POST['PARAMETERCODE']) : '';
		$PARAMETERNAME = isset($_POST['PARAMETERNAME']) ? strval($_POST['PARAMETERNAME']) : '';

		$CONTROLSYSTEM = isset($_POST['CONTROLSYSTEM']) ? strval($_POST['CONTROLSYSTEM']) : '';
		$UOM = isset($_POST['UOM']) ? strval($_POST['UOM']) : '';
		// $URL = isset($_POST['URL']) ? strval($_POST['URL']) : '';
		// $ID_MODULEAPPS = isset($_POST['ID_MODULEAPPS']) ? strval($_POST['ID_MODULEAPPS']) : '';
		// $ID_SUBMODULEAPPS = isset($_POST['ID_SUBMODULEAPPS']) ? strval($_POST['ID_SUBMODULEAPPS']) : '';
		$VALUE1 = isset($_POST['VALUE1']) ? intval($_POST['VALUE1']) : 0;
		$VALUE2 = isset($_POST['VALUE2']) ? intval($_POST['VALUE2']) : 0;
		$VALUE3 = isset($_POST['VALUE3']) ? intval($_POST['VALUE3']) : 0;

		$INACTIVE = isset($_POST['INACTIVE']) ? strval($_POST['INACTIVE']) : '';
		$INACTIVE2='';
		
		if($INACTIVE == 0){
			$INACTIVE2='';
		}
		$INACTIVEDATE = '';
		
		if($INACTIVE !==''){
			if(!empty($_POST['INACTIVEDATE'])){
				$INACTIVEDATE = date("d/M/Y", strtotime($_POST['INACTIVEDATE']));
			}
		}
		
		$sqlInput_detail= '-';
		// $this->db2->transBegin();
		$listDetailForm=array();
		$statDetailUpdate = 0;
		$implodeListDetailForm = "";
		$errorDeleteDetailNotinForm=0;
		$statHeaderUpdate = 0;


		try {
			
			// $userOrganisasi = $this->session->get('userOrganisasi');
			// $sql_security = "CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('" . $userOrganisasi['LOGINID'] . "', '" . $userOrganisasi['PASSWORD'] . "', '" . $userOrganisasi['COMPANYID'] . "', '" . $userOrganisasi['COMPANYSITEID'] . "');";
			// $this->db2->query($sql_security);

			$sqlInput = "UPDATE PARAMETER SET PARAMETERNAME = '$PARAMETERNAME', CONTROLSYSTEM = '$CONTROLSYSTEM' , UOM = '$UOM', VALUE1=$VALUE1, VALUE2 = $VALUE2, VALUE3=$VALUE3, INACTIVE='$INACTIVE2', INACTIVEDATE='$INACTIVEDATE'
			WHERE PARAMETERCODE = '$PARAMETERCODE'";
			
			$input = $this->db2->query($sqlInput);

			if ($input) {
				$this->db2->query('COMMIT;');
				$statHeaderUpdate++;

				$jumdetail = count($_POST['PARAMETERVALUECODE']);

				echo "<script>console.log('$jumdetail');</script>";

				if ($jumdetail > 0) {

				  for ($i = 0; $i < $jumdetail; $i++) {
					$PARAMETERVALUECODE = isset($_POST['PARAMETERVALUECODE'][$i]) ? strval($_POST['PARAMETERVALUECODE'][$i]) : '';
					$PARAMETERVALUE = isset($_POST['PARAMETERVALUE'][$i]) ? strval($_POST['PARAMETERVALUE'][$i]) : '';
					$UOM_D = isset($_POST['UOM_D'][$i]) ? strval($_POST['UOM_D'][$i]) : '';
					$MIN_D = isset($_POST['MIN_D'][$i]) ? strval($_POST['MIN_D'][$i]) : '';
					$MAX_D = isset($_POST['MAX_D'][$i]) ? strval($_POST['MAX_D'][$i]) : '';
					$SEQ_NO_D = isset($_POST['SEQ_NO_D'][$i]) ? strval($_POST['SEQ_NO_D'][$i]) : '';
					$VALUE1_D = isset($_POST['VALUE1_D'][$i]) ? strval($_POST['VALUE1_D'][$i]) : '';
					$VALUE2_D = isset($_POST['VALUE2_D'][$i]) ? strval($_POST['VALUE2_D'][$i]) : '';
					$VALUE_TEXT_D = isset($_POST['VALUE_TEXT_D'][$i]) ? strval($_POST['VALUE_TEXT_D'][$i]) : '';

					$cekpkDetail = $this->getDetailByPK($PARAMETERCODE, $PARAMETERVALUECODE);

					if(!isset($cekpkDetail)){
						try {
							$sqlInput = "INSERT INTO PARAMETERVALUE ( PARAMETERCODE, PARAMETERVALUECODE, PARAMETERVALUE, UOM, SEQ_NO, MIN, MAX, VALUE1, VALUE2, VALUE_TEXT)  VALUES 
							('$PARAMETERCODE', '$PARAMETERVALUECODE',  '$PARAMETERVALUE', '$UOM_D', '$SEQ_NO_D', '$MIN_D', '$MAX_D',  '$VALUE1_D', '$VALUE2_D', '$VALUE_TEXT_D')";
							$input = $this->db2->query($sqlInput);
		
							if ($input) {
								$this->db2->query('COMMIT;');
								$statDetailUpdate++;
							}
						} catch (\Exception $e) {
							$statDetailGagalUpdate++;
						}
					} else {
						try {
							$sqlUpdate = "UPDATE PARAMETERVALUE SET  PARAMETERVALUE = '$PARAMETERVALUE', UOM = '$UOM_D', SEQ_NO='$SEQ_NO_D', MIN='$MIN_D', MAX='$MAX_D', VALUE1='$VALUE1_D', VALUE2='$VALUE2_D', VALUE_TEXT = '$VALUE_TEXT_D'
							WHERE PARAMETERCODE = '$PARAMETERCODE' AND PARAMETERVALUECODE = '$PARAMETERVALUECODE'";

							$Update = $this->db2->query($sqlUpdate);
		
							if ($Update) {
								$this->db2->query('COMMIT;');
								$statDetailUpdate++;
							}
						} catch (\Exception $e) {
							$statDetailGagalUpdate++;
						}
					}

					array_push($listDetailForm,"'".$PARAMETERVALUECODE."'");
				  }

				  if(count($listDetailForm) > 0 && $jumdetail == $statDetailUpdate){
						$implodeListDetailForm = implode(" , ",$listDetailForm);
						try {
							$sqlDelete = "DELETE FROM PARAMETERVALUE WHERE PARAMETERCODE = '$PARAMETERCODE'  AND PARAMETERVALUE NOT IN ($implodeListDetailForm)";
							$delete = $this->db2->query($sqlDelete);

							if ($delete) {
								$this->db2->query('COMMIT');
							}
						} catch (\Exception $e) {
							$result['msg']['status'] = 'error';
							$result['msg']['content'] = 'Proses Update Gagal, Delete Detail Gagal';
							
							$errorDeleteDetailNotinForm++;
						}
					}
				}
			  
			} else {
				$result['msg']['status'] = 'error';
				$result['msg']['content'] = 'Data Gagal Disimpan : '.$sqlInput .'----'.$sqlInput_detail;
			}

		} catch (\Exception $e) {
			$result['msg']['status'] = 'error';
			$result['msg']['content'] = 'Data Gagal Disimpan : '.$sqlInput .'----'.$sqlInput_detail;
		}

		
		if($statHeaderUpdate == 1 ){
			if ($jumdetail == $statDetailUpdate){
				if($errorDeleteDetailNotinForm > 0){
					$result['msg']['status'] = 'warning';
					$result['msg']['content'] = ' Data Berhasil PARAMETER : '.$PARAMETERCODE.' ( Masuk : ' . $statDetailUpdate . ' Detail )<br> Pembersihan Data Lama gagal Dilakukan';
					$result['msg']['ID'] = $PARAMETERCODE;
				} else {
					$result['msg']['status'] = 'ok';
					$result['msg']['content'] = 'Data Berhasil PARAMETER  : '.$PARAMETERCODE.' ( Masuk : ' . $statDetailUpdate . ' Detail )';
					$result['msg']['ID'] = $PARAMETERCODE;

				}
			} else {
				$result['msg']['status'] = 'warning';
				$result['msg']['content'] = 'Sebagian Data Berhasil PARAMETER : '.$PARAMETERCODE.' ( Masuk : ' . $statDetailUpdate . ' Detail )<br> Silahkan Gunakan Fitur Edit - '.$jumdetail.' == '.$statDetailUpdate;
				$result['msg']['ID'] = $PARAMETERCODE;

			}
		}

		return $result;
	
	}


	// BATAS PAKAI


	// Fungsi Save  -------------------------------------------------------------
	public function saveData()
	{

		$PARAMETERCODE = isset($_POST['PARAMETERCODE']) ? strval($_POST['PARAMETERCODE']) : '';
		$PARAMETERNAME = isset($_POST['PARAMETERNAME']) ? strval($_POST['PARAMETERNAME']) : '';

		$CONTROLSYSTEM = isset($_POST['CONTROLSYSTEM']) ? strval($_POST['CONTROLSYSTEM']) : '';
		$UOM = isset($_POST['UOM']) ? strval($_POST['UOM']) : '';
		// $URL = isset($_POST['URL']) ? strval($_POST['URL']) : '';
		// $ID_MODULEAPPS = isset($_POST['ID_MODULEAPPS']) ? strval($_POST['ID_MODULEAPPS']) : '';
		// $ID_SUBMODULEAPPS = isset($_POST['ID_SUBMODULEAPPS']) ? strval($_POST['ID_SUBMODULEAPPS']) : '';
		$VALUE1 = isset($_POST['VALUE1']) ? intval($_POST['VALUE1']) : 0;
		$VALUE2 = isset($_POST['VALUE2']) ? intval($_POST['VALUE2']) : 0;
		$VALUE3 = isset($_POST['VALUE3']) ? intval($_POST['VALUE3']) : 0;

		$INACTIVE = isset($_POST['INACTIVE']) ? strval($_POST['INACTIVE']) : '';
		$INACTIVE2='';
		
		if($INACTIVE == 0){
			$INACTIVE2='';
		}
		$INACTIVEDATE = '';
		
		if($INACTIVE !==''){
			if(!empty($_POST['INACTIVEDATE'])){
				$INACTIVEDATE = date("d/M/Y", strtotime($_POST['INACTIVEDATE']));
			}
		}
		
		$sqlInput_detail= '-';
		// $this->db2->transBegin();
		try {
			
			// $userOrganisasi = $this->session->get('userOrganisasi');
			// $sql_security = "CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('" . $userOrganisasi['LOGINID'] . "', '" . $userOrganisasi['PASSWORD'] . "', '" . $userOrganisasi['COMPANYID'] . "', '" . $userOrganisasi['COMPANYSITEID'] . "');";
			// $this->db2->query($sql_security);

			$sqlInput = "INSERT INTO PARAMETER (PARAMETERCODE, PARAMETERNAME, CONTROLSYSTEM, UOM, VALUE1, VALUE2, VALUE3, INACTIVE, INACTIVEDATE)  VALUES 
			('$PARAMETERCODE', '$PARAMETERNAME',  '$CONTROLSYSTEM', '$UOM', $VALUE1, $VALUE2, $VALUE3, '$INACTIVE2', '$INACTIVEDATE')";
			
			$input = $this->db2->query($sqlInput);

			if ($input) {
				$this->db2->query('COMMIT;');
				$jumdetail = count($_POST['PARAMETERVALUECODE']);

				echo "<script>console.log('$jumdetail');</script>";

				if ($jumdetail > 0) {

				  for ($i = 0; $i < $jumdetail; $i++) {
					$PARAMETERVALUECODE = isset($_POST['PARAMETERVALUECODE'][$i]) ? strval($_POST['PARAMETERVALUECODE'][$i]) : '';
					$PARAMETERVALUE = isset($_POST['PARAMETERVALUE'][$i]) ? strval($_POST['PARAMETERVALUE'][$i]) : '';
					$UOM_D = isset($_POST['UOM_D'][$i]) ? strval($_POST['UOM_D'][$i]) : '';
					$MIN_D = isset($_POST['MIN_D'][$i]) ? strval($_POST['MIN_D'][$i]) : '';
					$MAX_D = isset($_POST['MAX_D'][$i]) ? strval($_POST['MAX_D'][$i]) : '';
					$SEQ_NO_D = isset($_POST['SEQ_NO_D'][$i]) ? strval($_POST['SEQ_NO_D'][$i]) : '';
					$VALUE1_D = isset($_POST['VALUE1_D'][$i]) ? strval($_POST['VALUE1_D'][$i]) : '';
					$VALUE2_D = isset($_POST['VALUE2_D'][$i]) ? strval($_POST['VALUE2_D'][$i]) : '';
					$VALUE_TEXT_D = isset($_POST['VALUE_TEXT_D'][$i]) ? strval($_POST['VALUE_TEXT_D'][$i]) : '';
					$sqlInput_detail = "INSERT INTO PARAMETERVALUE ( PARAMETERCODE, PARAMETERVALUECODE, PARAMETERVALUE, UOM, SEQ_NO, MIN, MAX, VALUE1, VALUE2, VALUE_TEXT)  VALUES 
						('$PARAMETERCODE', '$PARAMETERVALUECODE',  '$PARAMETERVALUE', '$UOM_D', '$SEQ_NO_D', '$MIN_D', '$MAX_D',  '$VALUE1_D', '$VALUE2_D', '$VALUE_TEXT_D')";
						
					$inputDetail = $this->db2->query($sqlInput_detail);

					if(!$inputDetail){
						$result['msg']['status'] = 'error';
						$result['msg']['content'] = 'Data Gagal Disimpan : '.$sqlInput_detail;
						return $result;
					}
					else{
						$this->db2->query('COMMIT;');
	  
						$result['msg']['status'] = 'ok';
						$result['msg']['content'] = 'Data berhasil disimpan';
						$result['ID'] = $PARAMETERCODE;

					}
				  }
				}
			  
			}

		} catch (\Exception $e) {
			$result['msg']['status'] = 'error';
			$result['msg']['content'] = 'Data Gagal Disimpan : '.$sqlInput .'----'.$sqlInput_detail;
		}

		return $result;
	}


	

	
		// Fungsi Delete  -------------------------------------------------------------
		public function deleteData()
		{
			$id = isset($_POST['id']) ? strval($_POST['id']) : '';
	
			try {    
				$sqlDelete = "DELETE FROM PARAMETERVALUE WHERE  PARAMETERCODE  = '$id' ";
				$delete = $this->db2->query($sqlDelete);

				$sqlDeleteRole = "DELETE FROM PARAMETER WHERE PARAMETERCODE  = '$id' ";
				$deleteRole = $this->db2->query($sqlDeleteRole);
	
				if ($delete) {
					$this->db2->query('COMMIT');

					$result['msg']['status'] = 'ok';
					$result['msg']['content'] = 'Proses Delete Berhasil';
				}
			} catch (\Exception $e) {
				$result['msg']['status'] = 'error';
				$result['msg']['content'] = 'Proses Delete Detail Gagal';
				// die($e->getMessage());
			} 

			
			
			return $result;
		}
	

}
