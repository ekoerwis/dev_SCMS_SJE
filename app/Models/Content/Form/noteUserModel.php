<?php

namespace App\Models\Content\Form;

class noteUserModel extends \App\Models\BaseModel
{
	protected $db2;

	public function __construct()
	{
		parent::__construct();
	}

	public function getList()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'POSTDT';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';

        $p_searchkeyword_ORI = isset($_POST['SEARCH_KEYWORD']) ? strval ($_POST['SEARCH_KEYWORD']) :'';
    	$p_searchkeyword=trim($p_searchkeyword_ORI," ");

		$limit = $page * $rows;
		$offset = ($page - 1) * $rows;

		$mainSql = "SELECT * FROM (
        SELECT CRTTS, CRTBY, UPDTS, UPDBY, POSTDT, TO_CHAR(POSTDT,'FXFMDD-Mon-yyyy') POSTDT2, USERID, STATIONID, ULGNOTE FROM SCD_USERLOG 
        ) 
        WHERE  ( LOWER(STATIONID)  LIKE LOWER('%$p_searchkeyword%') OR LOWER(ULGNOTE) LIKE LOWER('%$p_searchkeyword%') )  
         ";

		$result = array();

		$sql = "SELECT count(*) AS JUMLAH FROM ($mainSql)";
		$sql = $this->db->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM (SELECT CRTTS, CRTBY, UPDTS, UPDBY, POSTDT,POSTDT2, USERID, STATIONID, ULGNOTE, ROWNUM AS RNUM FROM (
        $mainSql ORDER BY $sort $order
        ) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";

		$data = $this->db->query($sql)->getResultArray();

		$result['rows'] = $data;

		return $result;
	}


	// Fungsi Save  -------------------------------------------------------------
	public function saveData()
	{

        $CRTTS = date("d/M/Y h:i:s A");
        $CRTBY = isset($_POST['CRTBY']) ? strval($_POST['CRTBY']) : '';
        $POSTDT = '';
        if(!empty($_POST['POSTDT'])){
			$POSTDT = date("d/M/Y", strtotime($_POST['POSTDT']));
		}
        $USERID = isset($_POST['USERID']) ? strval($_POST['USERID']) : '';
        $STATIONID = isset($_POST['STATIONID']) ? strval($_POST['STATIONID']) : '';
        $ULGNOTE=isset($_POST['ULGNOTE']) ? strval($_POST['ULGNOTE']) : '';

		
		try {
			$sqlInput = "INSERT INTO SCD_USERLOG (CRTTS, CRTBY, POSTDT, USERID, STATIONID, ULGNOTE)  VALUES 
			('$CRTTS', '$CRTBY',  '$POSTDT', '$USERID', '$STATIONID', '$ULGNOTE')";
			
			$input = $this->db->query($sqlInput);

			if ($input) {
				$this->db->query('COMMIT');
				$result['msg']['status'] = 'ok';
				$result['msg']['content'] = 'Data Berhasil Disimpan';
				
			}
		} catch (\Exception $e) {
			$result['msg']['status'] = 'error';
			$result['msg']['content'] = 'Data Gagal Disimpan : '.$sqlInput;
		}

		return $result;
	}
	


	// BATAS PAKAI


	

    public function getDataHeader()
	{
		
		$id = isset($_GET['id']) ? strval($_GET['id']) : '';
		
		$mainSql = "  SELECT ID, KODE_REPORT, NAMA_REPORT, LABEL_REPORT, KETERANGAN, URL, ID_MODULEAPPS, ID_SUBMODULEAPPS, SEQ, INACTIVE, INACTIVEDATE,  TO_CHAR(INACTIVEDATE,'FXFMDD-Mon-yyyy') INACTIVEDATE2 FROM REPORT_APPS WHERE ID = '$id' ";

		$result = array();

		$result = $this->db->query($mainSql)->getRowArray();

		return $result;
	}

	
	// Fungsi Update  -------------------------------------------------------------
	public function updateData()
	{
		

		$ID = isset($_POST['ID']) ? strval($_POST['ID']) : '';
		$KODE_REPORT = isset($_POST['KODE_REPORT']) ? strval($_POST['KODE_REPORT']) : '';
		$NAMA_REPORT = isset($_POST['NAMA_REPORT']) ? strval($_POST['NAMA_REPORT']) : '';

		$LABEL_REPORT = isset($_POST['LABEL_REPORT']) ? strval($_POST['LABEL_REPORT']) : '';
		$KETERANGAN = isset($_POST['KETERANGAN']) ? strval($_POST['KETERANGAN']) : '';
		$URL = isset($_POST['URL']) ? strval($_POST['URL']) : '';
		$ID_MODULEAPPS = isset($_POST['ID_MODULEAPPS']) ? strval($_POST['ID_MODULEAPPS']) : '';
		$ID_SUBMODULEAPPS = isset($_POST['ID_SUBMODULEAPPS']) ? strval($_POST['ID_SUBMODULEAPPS']) : '';
		$SEQ = isset($_POST['SEQ']) ? intval($_POST['SEQ']) : 0;


		$INACTIVE = isset($_POST['INACTIVE']) ? intval($_POST['INACTIVE']) : 0;
		$INACTIVEDATE = '';
		if(!empty($_POST['INACTIVEDATE'])){
			$INACTIVEDATE = date("d/M/Y", strtotime($_POST['INACTIVEDATE']));
		}
		
		try {
			$sqlInput = "UPDATE REPORT_APPS SET KODE_REPORT = '$KODE_REPORT' , NAMA_REPORT = '$NAMA_REPORT', LABEL_REPORT='$LABEL_REPORT', KETERANGAN = '$KETERANGAN', URL='$URL' , ID_MODULEAPPS = '$ID_MODULEAPPS', ID_SUBMODULEAPPS='$ID_SUBMODULEAPPS' , SEQ=$SEQ, INACTIVE='$INACTIVE', INACTIVEDATE='$INACTIVEDATE' WHERE ID = $ID";
			
			$input = $this->db->query($sqlInput);

			if ($input) {
				$this->db->query('COMMIT');
				$result['msg']['status'] = 'ok';
				$result['msg']['content'] = 'Data Berhasil Disimpan';
				$result['msg']['ID'] = $ID;
			}
		} catch (\Exception $e) {
			$result['msg']['status'] = 'error';
			$result['msg']['content'] = 'Data Gagal Disimpan : '.$sqlInput;
		}

		return $result;
	}

		// Fungsi Delete  -------------------------------------------------------------
		public function deleteData()
		{
			$id = isset($_POST['id']) ? strval($_POST['id']) : '';
	
			try {    
				$sqlDelete = "DELETE FROM REPORT_APPS WHERE  ID  = $id ";
				$delete = $this->db->query($sqlDelete);
	
				if ($delete) {
					$this->db->query('COMMIT');

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

    public function getRVDetailPerNo($noDoc = '')
	{
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'JOBCODE';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		if ($noDoc == '') {
			$id = isset($_GET['id']) ? strval($_GET['id']) : '';
		} else {
			$id = $noDoc;
		}

		$mainSql = "SELECT * FROM (
        SELECT A.VOUCHERCODE, A.LOCATIONTYPE, B.LOCATIONTYPENAME, A.LOCATIONCODE,  C.DESCRIPTION LOCATIONNAME,
A.JOBCODE,  D.JOBDESCRIPTION, A.AMOUNT, A.REFERENCE, 
A.REMARKS, A.APPLIED, A.CASHFLOWCODE, E.DESCRIPTION CASHFLOWNAME, A.COMP_ID, A.SITE_ID, 
A.INPUTBY, A.INPUTDATE, A.UPDATEBY, A.UPDATEDATE, 
A.DELETED_FLAG FROM ReportMasterDETAIL_DRAFT_VO A, LOCATIONTYPE B, LOCATION_VO C, JOB_VO D, CASHFLOW_VO E
WHERE A.LOCATIONTYPE = B.LOCATIONTYPECODE
AND A.LOCATIONTYPE = C.LOCATIONTYPECODE AND A.LOCATIONCODE = C.LOCATIONCODE
AND A.JOBCODE = D.JOBCODE AND A.CASHFLOWCODE = E.CASHFLOWCODE AND A.VOUCHERCODE = '$id'
        ) ORDER BY $sort $order
         ";

		$result = array();

		$userOrganisasi = $this->session->get('userOrganisasi');
		$sql_security = "CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('" . $userOrganisasi['LOGINID'] . "', '" . $userOrganisasi['PASSWORD'] . "', '" . $userOrganisasi['COMPANYID'] . "', '" . $userOrganisasi['COMPANYSITEID'] . "');";
		$this->db2->query($sql_security);


		$result = $this->db2->query($mainSql)->getResultArray();

		return $result;
	}

	public function getCgBank(){

		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'BANKCODE';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		$limit = $page*$rows;
		$offset = ($page-1)*$rows;
		$result = array();

		$userOrganisasi=$this->session->get('userOrganisasi');
		$sql_security="CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('".$userOrganisasi['LOGINID']."', '".$userOrganisasi['PASSWORD']."', '".$userOrganisasi['COMPANYID']."', '".$userOrganisasi['COMPANYSITEID']."');";
		$this->db2->query($sql_security);

		$tdate = isset($_GET['tdate']) ? strval($_GET['tdate']) : '';

		$mainSql = "SELECT * FROM (
			SELECT bankcode, bankname  BANKNAME, CURRENCY
		FROM bank_vo a
		WHERE NVL (inactivedate, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
			AND EXISTS (
				SELECT *
					FROM accessrightsloc_vo b
					WHERE b.modulecode = 11
					AND b.submodulecode = 1
					AND b.authorized = 1
					AND b.loginid =
							app_security_pkg.get_sessioninfo_f ('LOGINID')
					AND a.bankcode = b.locationcode)
		)
		WHERE LOWER(BANKNAME) LIKE LOWER('%$q%') OR LOWER(BANKCODE) LIKE LOWER('%$q%')";

		$sql = "SELECT count(*) AS JUMLAH FROM ($mainSql)";

		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];
		
		$sql = "SELECT * FROM (
						SELECT BANKCODE, BANKNAME, CURRENCY, ROWNUM AS RNUM FROM (
						$mainSql ORDER BY $sort $order)
						WHERE ROWNUM <= $limit)
			WHERE RNUM > $offset ";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;

	}

	public function getOpeningBalance(){

		$userOrganisasi=$this->session->get('userOrganisasi');
		$sql_security="CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('".$userOrganisasi['LOGINID']."', '".$userOrganisasi['PASSWORD']."', '".$userOrganisasi['COMPANYID']."', '".$userOrganisasi['COMPANYSITEID']."');";
		$this->db2->query($sql_security);

		$tdate = isset($_GET['tdate']) ? strval($_GET['tdate']) : '';
		$bankcode = isset($_GET['bankcode']) ? strval($_GET['bankcode']) : '';

		$resultSql = array();
		
		$sqlOpeningBalance = " SELECT NVL (A.OPENINGBALANCE, 0) OPENINGBALANCE, B.PERIODSEQ, B.ACCYEAR
		FROM BANKBALANCE_VO A , (SELECT P.PERIODSEQ, P.ACCYEAR
				FROM PERIODCTLMST_VO P
			   WHERE     P.STARTDATE <= '$tdate'
					 AND P.ENDDATE >= '$tdate') B
		WHERE A.BANKCODE = '$bankcode' AND A.MONTH = B.PERIODSEQ AND A.YEAR = B.ACCYEAR
		";
		
		$resultSqlOpeningBalance = $this->db2->query($sqlOpeningBalance)->getRowArray();

		$OPENINGBALANCE =  isset($resultSqlOpeningBalance['OPENINGBALANCE']) ? strval($resultSqlOpeningBalance['OPENINGBALANCE']) : '0';
		$PERIODSEQ =  isset($resultSqlOpeningBalance['PERIODSEQ']) ? intval($resultSqlOpeningBalance['PERIODSEQ']) : 0;
		$ACCYEAR =  isset($resultSqlOpeningBalance['ACCYEAR']) ? intval($resultSqlOpeningBalance['ACCYEAR']) : 0;
		
		$result['OPENINGBALANCE'] = $OPENINGBALANCE;

		$sqlOpeningStartDate = "SELECT P.STARTDATE V_STARTDATE, P.ENDDATE V_ENDDATE FROM PERIODCTLMST_VO P WHERE P.PERIODSEQ = $PERIODSEQ  AND P.ACCYEAR = $ACCYEAR ";

		$resultOpeningStartDate = $this->db2->query($sqlOpeningStartDate)->getRowArray();

		$V_STARTDATE = isset($resultOpeningStartDate['V_STARTDATE']) ? $resultOpeningStartDate['V_STARTDATE'] : '';
		$V_ENDDATE = isset($resultOpeningStartDate['V_ENDDATE']) ? $resultOpeningStartDate['V_ENDDATE']: '';

		$sqlTotalRecampt = "SELECT NVL (SUM (RV.TOTALAMOUNT), 0) V_TOTALRECAMT FROM ReportMaster_VO RV WHERE RV.BANKCODE = '$bankcode' AND RV.DATECREATED BETWEEN '$V_STARTDATE' AND '$tdate' ";
		$resultTotalRecampt = $this->db2->query($sqlTotalRecampt)->getRowArray();

		$V_TOTALRECAMT = isset($resultTotalRecampt['V_TOTALRECAMT']) ? floatval($resultTotalRecampt['V_TOTALRECAMT']) : 0;

		$result['V_TOTALRECAMT'] = $V_TOTALRECAMT;

		$sqlTotalPayment = "SELECT NVL (SUM (PV.TOTALAMOUNT), 0) V_TOTALPAYAMT
        FROM PAYMENTVOUCHER_VO PV WHERE PV.BANKCODE = '$bankcode' AND PROCESS_FLAG = 'APPROVED' AND APPROVEDATE IS NOT NULL AND PV.DATETRANSACTION BETWEEN '$V_STARTDATE' AND '$tdate' ";
		$resultTotalPayment = $this->db2->query($sqlTotalPayment)->getRowArray();

		$V_TOTALPAYAMT = isset($resultTotalPayment['V_TOTALPAYAMT']) ? floatval($resultTotalPayment['V_TOTALPAYAMT']) : 0;

		$result['V_TOTALPAYAMT'] = $V_TOTALPAYAMT;

		return $result;

	}
	
	public function getCbPaymentType()
	{

		$userOrganisasi=$this->session->get('userOrganisasi');
		$sql_security="CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('".$userOrganisasi['LOGINID']."', '".$userOrganisasi['PASSWORD']."', '".$userOrganisasi['COMPANYID']."', '".$userOrganisasi['COMPANYSITEID']."');";
		$this->db2->query($sql_security);
		
		$sql = "SELECT 'CASH' CODE, 'CASH' DESCRIPTION, 1 IS_DEFAULT FROM DUAL
		UNION ALL
		SELECT 'CHEQUE_BG'  CODE, 'CHEQUE_BG' DESCRIPTION, 0 IS_DEFAULT FROM DUAL
		UNION ALL
		SELECT 'TRANSFER'  CODE, 'TRANSFER' DESCRIPTION, 0 IS_DEFAULT FROM DUAL";

		$result = $this->db2->query($sql)->getResultArray();
		return $result;
	
	}

	public function getCbVoucherType()
	{

		$userOrganisasi=$this->session->get('userOrganisasi');
		$sql_security="CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('".$userOrganisasi['LOGINID']."', '".$userOrganisasi['PASSWORD']."', '".$userOrganisasi['COMPANYID']."', '".$userOrganisasi['COMPANYSITEID']."');";
		$this->db2->query($sql_security);
		
		$sql = "SELECT '1' CODE, 'AP Supplier' DESCRIPTION, 1 IS_DEFAULT FROM DUAL
		UNION ALL
		SELECT '2'  CODE, ' AP Contractor' DESCRIPTION, 0 IS_DEFAULT FROM DUAL
		UNION ALL
		SELECT '3'  CODE, 'Non AP / AR' DESCRIPTION, 0 IS_DEFAULT FROM DUAL
		UNION ALL
		SELECT '4'  CODE, 'AR Customer' DESCRIPTION, 0 IS_DEFAULT FROM DUAL";

		$result = $this->db2->query($sql)->getResultArray();
		return $result;
	
	}

	public function getCbProcessFlag()
	{

		$userOrganisasi=$this->session->get('userOrganisasi');
		$sql_security="CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('".$userOrganisasi['LOGINID']."', '".$userOrganisasi['PASSWORD']."', '".$userOrganisasi['COMPANYID']."', '".$userOrganisasi['COMPANYSITEID']."');";
		$this->db2->query($sql_security);
		
		$sql = "SELECT 'DRAFT' CODE, 'DRAFT' DESCRIPTION, 1 IS_DEFAULT FROM DUAL
		UNION ALL
		SELECT 'SUBMITED'  CODE, 'SUBMITED' DESCRIPTION, 0 IS_DEFAULT FROM DUAL";

		$result = $this->db2->query($sql)->getResultArray();
		return $result;
	
	}

	public function getCgSuppCont(){

		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'SUPPLIERCODE';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		$limit = $page*$rows;
		$offset = ($page-1)*$rows;
		$result = array();

		$userOrganisasi=$this->session->get('userOrganisasi');
		$sql_security="CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('".$userOrganisasi['LOGINID']."', '".$userOrganisasi['PASSWORD']."', '".$userOrganisasi['COMPANYID']."', '".$userOrganisasi['COMPANYSITEID']."');";
		$this->db2->query($sql_security);

		$tdate = isset($_GET['tdate']) ? strval($_GET['tdate']) : '';
		$vType = isset($_GET['vType']) ? strval($_GET['vType']) : '';

		$mainSql = "SELECT * FROM (
			SELECT   suppliercode, suppliername
    FROM (SELECT suppliercode, suppliername
            FROM supplier_vo
           WHERE '$vType' = '1'
             AND NVL (inactivedate, TO_DATE ('01012099', 'ddmmyyyy')) >'$tdate'
             AND suppliercode NOT IN (
                    SELECT suppliercode
                      FROM (SELECT suppliercode
                              FROM supplier_ffb_vo
                             WHERE NVL (inactivedate,
                                        TO_DATE ('01012099', 'ddmmyyyy')
                                       ) >'$tdate'
                            UNION
                            SELECT contractorcode
                              FROM contractor_vo
                             WHERE NVL (inactivedate,
                                        TO_DATE ('01012099', 'ddmmyyyy')
                                       ) >'$tdate'))
          UNION
          SELECT suppliercode, suppliername
            FROM supplier_ffb_vo
           WHERE '$vType' in ( '1','3')
             AND NVL (inactivedate, TO_DATE ('01012099', 'ddmmyyyy')) > '$tdate'
          UNION
          SELECT contractorcode, contractorname
            FROM contractor_vo
           WHERE '$vType' in ( '2','3')
             AND NVL (inactivedate, TO_DATE ('01012099', 'ddmmyyyy')) > '$tdate'
          UNION
          SELECT customercode, description
            FROM customer_vo
           WHERE '$vType' = '4'
             AND NVL (inactivedate, TO_DATE ('31129999', 'ddmmyyyy')) > '$tdate')
		)
		WHERE LOWER(SUPPLIERNAME) LIKE LOWER('%$q%') OR LOWER(SUPPLIERCODE) LIKE LOWER('%$q%')";

		$sql = "SELECT count(*) AS JUMLAH FROM ($mainSql)";

		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];
		
		$sql = "SELECT * FROM (
						SELECT SUPPLIERCODE, SUPPLIERNAME, ROWNUM AS RNUM FROM (
						$mainSql ORDER BY $sort $order)
						WHERE ROWNUM <= $limit)
			WHERE RNUM > $offset ";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;

	}

	public function getCgPaymentToBank(){

		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'ACCOUNTNO';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		$limit = $page*$rows;
		$offset = ($page-1)*$rows;
		$result = array();

		$userOrganisasi=$this->session->get('userOrganisasi');
		$sql_security="CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('".$userOrganisasi['LOGINID']."', '".$userOrganisasi['PASSWORD']."', '".$userOrganisasi['COMPANYID']."', '".$userOrganisasi['COMPANYSITEID']."');";
		$this->db2->query($sql_security);

		$tdate = isset($_GET['tdate']) ? strval($_GET['tdate']) : '';
		$vType = isset($_GET['vType']) ? strval($_GET['vType']) : '';
		$bankCode = isset($_GET['bankCode']) ? strval($_GET['bankCode']) : '';
		$suppContCode = isset($_GET['suppContCode']) ? strval($_GET['suppContCode']) : '';

		$mainSql = "SELECT * FROM (
			 SELECT ACCOUNTNO,
         BANKCODE,
         BANKNAME,
         BANKACCNAME
    FROM (SELECT BANKNAME            BANKNAME,
                 BANKCODE            BANKCODE,
                 BANKACCOUNTCODE     ACCOUNTNO,
                 CONTACTPERSON       BANKACCNAME
            FROM BANK
           WHERE     NVL (INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > '$tdate'
                 AND COMP_ID = APP_SECURITY_PKG.GET_SESSIONINFO_F ('COMPANYID')
                 AND '$vType' = 3
                 AND BANKCODE != NVL ( '$bankCode', BANKCODE)
          UNION ALL
          SELECT BANKNAME      BANKNAME,
                 BANKCODE      BANKCODE,
                 BANKACCNO     ACCOUNTNO,
                 BANKACCNAME
            FROM SUPPLIERBANK
           WHERE     SUPPLIERCODE = '$suppContCode'
                 AND '$vType' IN('1','2'))
		)
		WHERE LOWER(BANKCODE) LIKE LOWER('%$q%') OR LOWER(BANKNAME) LIKE LOWER('%$q%')";

		$sql = "SELECT count(*) AS JUMLAH FROM ($mainSql)";

		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];
		
		$sql = "SELECT * FROM (
						SELECT ACCOUNTNO, BANKCODE, BANKNAME, BANKACCNAME, ROWNUM AS RNUM FROM (
						$mainSql ORDER BY $sort $order)
						WHERE ROWNUM <= $limit)
			WHERE RNUM > $offset ";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;

	}

		public function getCgLocType()
	{

		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'LOCATIONTYPECODE';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		$limit = $page * $rows;
		$offset = ($page - 1) * $rows;
		$result = array();

		$userOrganisasi = $this->session->get('userOrganisasi');
		$sql_security = "CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('" . $userOrganisasi['LOGINID'] . "', '" . $userOrganisasi['PASSWORD'] . "', '" . $userOrganisasi['COMPANYID'] . "', '" . $userOrganisasi['COMPANYSITEID'] . "');";
		$this->db2->query($sql_security);

		$COMP_ID = $_SESSION['userOrganisasi']['COMPANYID'];
		$SITE_ID = $_SESSION['userOrganisasi']['COMPANYSITEID'];

        $tdate = isset($_GET['tdate']) ? strval($_GET['tdate']) : '';
        $vType = isset($_GET['vType']) ? strval($_GET['vType']) : '';
        
        $mainSql = "SELECT * FROM 
		  (
			SELECT DISTINCT A.TARGET LOCATIONTYPECODE, B.LOCATIONTYPENAME
           FROM ACTIVITY_LOCATION_CONTROL_VO A, LOCATIONTYPE_VO B
          WHERE A.TARGET = B.LOCATIONTYPECODE
            AND A.SOURCE = 'CS'
            AND NVL (A.INACTIVEDATE, TO_DATE ('01012099', 'ddmmyyyy')) > '$tdate'
            AND (   ('$vType' = 1 AND A.TARGET = 'AP')
                 OR ('$vType' = 2 AND A.TARGET = 'CA')
                 OR ('$vType' = 3 AND A.TARGET  NOT IN ('AP', 'AR','CA'))
OR ('$vType' = 4 AND A.TARGET = 'AR')
                 OR (    NVL ('$vType', 10) = 10
                     AND A.TARGET NOT IN ('AP', 'CA')
                    )
                )
		  )    WHERE ROWNUM > 0 AND ( LOWER(LOCATIONTYPECODE) LIKE LOWER('%$q%') OR LOWER(LOCATIONTYPENAME) LIKE LOWER('%$q%')  )
		  ";
        

		

		$sql = "SELECT COUNT(*) as JUMLAH FROM ($mainSql) ";

		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM 
		(
			SELECT LOCATIONTYPECODE, LOCATIONTYPENAME, ROWNUM AS RNUM FROM 
			(
			   $mainSql ORDER BY  $sort $order
			)
			WHERE ROWNUM <= $limit
		  )
		WHERE RNUM > $offset";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;
	}
	
	public function getCgLocCode()
	{

		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'LOCATIONCODE';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		$limit = $page * $rows;
		$offset = ($page - 1) * $rows;
		$result = array();

		$userOrganisasi = $this->session->get('userOrganisasi');
		$sql_security = "CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('" . $userOrganisasi['LOGINID'] . "', '" . $userOrganisasi['PASSWORD'] . "', '" . $userOrganisasi['COMPANYID'] . "', '" . $userOrganisasi['COMPANYSITEID'] . "');";
		$this->db2->query($sql_security);

		$COMP_ID = $_SESSION['userOrganisasi']['COMPANYID'];
		$SITE_ID = $_SESSION['userOrganisasi']['COMPANYSITEID'];

        $tdate = isset($_GET['tdate']) ? strval($_GET['tdate']) : '';
        $loctype = isset($_GET['loctype']) ? strval($_GET['loctype']) : '';
        $suppcontcode = isset($_GET['suppcontcode']) ? strval($_GET['suppcontcode']) : '';

        $mainSql = "SELECT * FROM 
        (
            SELECT   LOCATIONCODE, DESCRIPTION
    FROM LOCATION_VO
   WHERE LOCATIONTYPECODE = '$loctype'
     AND NVL (INACTIVEDATE, TO_DATE ('01012099', 'ddmmyyyy')) > '$tdate'
     AND LOCATIONCODE =
            CASE
               WHEN '$loctype' IN ('AR', 'AP','CA')
                  THEN '$suppcontcode'
               ELSE LOCATIONCODE
            END
        )    WHERE ROWNUM > 0 AND ( LOWER(LOCATIONCODE) LIKE LOWER('%$q%') OR LOWER(DESCRIPTION) LIKE LOWER('%$q%')  )
        ";

		

		$sql = "SELECT COUNT(*) as JUMLAH FROM ($mainSql) ";

		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM 
		(
			SELECT LOCATIONCODE, DESCRIPTION, ROWNUM AS RNUM FROM 
			(
			   $mainSql ORDER BY  $sort $order
			)
			WHERE ROWNUM <= $limit
		  )
		WHERE RNUM > $offset";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;
	}

	public function getCgJobCode()
	{

		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'JOBCODE';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		$limit = $page * $rows;
		$offset = ($page - 1) * $rows;
		$result = array();

		$userOrganisasi = $this->session->get('userOrganisasi');
		$sql_security = "CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('" . $userOrganisasi['LOGINID'] . "', '" . $userOrganisasi['PASSWORD'] . "', '" . $userOrganisasi['COMPANYID'] . "', '" . $userOrganisasi['COMPANYSITEID'] . "');";
		$this->db2->query($sql_security);

		$COMP_ID = $_SESSION['userOrganisasi']['COMPANYID'];
		$SITE_ID = $_SESSION['userOrganisasi']['COMPANYSITEID'];

		$loctype = isset($_GET['loctype']) ? strval($_GET['loctype']) : '';
		$tdate = isset($_GET['tdate']) ? strval($_GET['tdate']) : '';
		$vType = isset($_GET['vType']) ? strval($_GET['vType']) : '';

		$mainSql = "SELECT * FROM 
			(
			SELECT   A.ACTIVITY JOBCODE, B.JOBDESCRIPTION
FROM ACTIVITY_LOCATION_CONTROL_VO A, JOB_VO B
WHERE A.ACTIVITY = B.JOBCODE
	AND A.SOURCE = 'CS'
	AND A.TARGET = '$loctype'
	AND NVL (A.INACTIVEDATE, TO_DATE ('01012099', 'ddmmyyyy')) > '$tdate'
	AND NVL (B.INACTIVEDATE, TO_DATE ('01012099', 'ddmmyyyy')) > '$tdate'
	AND B.OPERATIONAL = '1'
AND (
		('$vType' <> 4)
		OR
		( '$vType' = 4 AND A.ACTIVITY IN (SELECT DISTINCT JOBCODE
			FROM CONTROLJOB_VO 
			WHERE '$vType' = '4'
			AND UPPER(CONTROLSYSTEM) = 'SALES' 
			AND ITEMCODE = 17) )
		)
			)    WHERE ROWNUM > 0 AND ( LOWER(JOBCODE) LIKE LOWER('%$q%') OR LOWER(JOBDESCRIPTION) LIKE LOWER('%$q%')  )
			";

		$sql = "SELECT COUNT(*) as JUMLAH FROM ($mainSql) ";

		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM 
		(
			SELECT JOBCODE, JOBDESCRIPTION, ROWNUM AS RNUM FROM 
			(
				$mainSql ORDER BY  $sort $order
			)
			WHERE ROWNUM <= $limit
			)
		WHERE RNUM > $offset";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;
	}

	public function getCgCashFlow()
	{

		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'CASHFLOWCODE';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		$limit = $page * $rows;
		$offset = ($page - 1) * $rows;
		$result = array();

		$userOrganisasi = $this->session->get('userOrganisasi');
		$sql_security = "CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('" . $userOrganisasi['LOGINID'] . "', '" . $userOrganisasi['PASSWORD'] . "', '" . $userOrganisasi['COMPANYID'] . "', '" . $userOrganisasi['COMPANYSITEID'] . "');";
		$this->db2->query($sql_security);

		$COMP_ID = $_SESSION['userOrganisasi']['COMPANYID'];
		$SITE_ID = $_SESSION['userOrganisasi']['COMPANYSITEID'];

		$loctype = isset($_GET['loctype']) ? strval($_GET['loctype']) : '';
		$tdate = isset($_GET['tdate']) ? strval($_GET['tdate']) : '';
		$vType = isset($_GET['vType']) ? strval($_GET['vType']) : '';

		$mainSql = "SELECT * FROM 
			(
				SELECT   CASHFLOWCODE, DESCRIPTION CASHFLOWDESC
    FROM CASHFLOW_VO
   WHERE CASHFLOWTYPE = 'O' AND GROUPCODE LIKE 'D%'
ORDER BY CASHFLOWCODE
)    WHERE ROWNUM > 0 AND ( LOWER(CASHFLOWCODE) LIKE LOWER('%$q%') OR LOWER(CASHFLOWDESC) LIKE LOWER('%$q%')  )
			";

		$sql = "SELECT COUNT(*) as JUMLAH FROM ($mainSql) ";

		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM 
		(
			SELECT CASHFLOWCODE, CASHFLOWDESC, ROWNUM AS RNUM FROM 
			(
				$mainSql ORDER BY  $sort $order
			)
			WHERE ROWNUM <= $limit
			)
		WHERE RNUM > $offset";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;
	}

	public function getCgReference()
	{

		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'INVOICECODE';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		$limit = $page * $rows;
		$offset = ($page - 1) * $rows;
		$result = array();

		$userOrganisasi = $this->session->get('userOrganisasi');
		$sql_security = "CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('" . $userOrganisasi['LOGINID'] . "', '" . $userOrganisasi['PASSWORD'] . "', '" . $userOrganisasi['COMPANYID'] . "', '" . $userOrganisasi['COMPANYSITEID'] . "');";
		$this->db2->query($sql_security);

		$COMP_ID = $_SESSION['userOrganisasi']['COMPANYID'];
		$SITE_ID = $_SESSION['userOrganisasi']['COMPANYSITEID'];

		$loctype = isset($_GET['loctype']) ? strval($_GET['loctype']) : '';
		$loccode = isset($_GET['loccode']) ? strval($_GET['loccode']) : '';
		$tdate = isset($_GET['tdate']) ? strval($_GET['tdate']) : '';
		$currency = isset($_GET['currency']) ? strval($_GET['currency']) : '';
		$vCode = isset($_GET['vCode']) ? strval($_GET['vCode']) : '';

		$mainSql = "SELECT * FROM 
			(
				SELECT INVOICECODE,
         REF_DOC,
         INVOICE_AMOUNT,
         PAYMENT_AMOUNT,
         DN_AMOUNT,
         NULL,
         INVOICE_AMOUNT - PAYMENT_AMOUNT - DN_AMOUNT     NETBAL_AMOUNT
    FROM (  SELECT I.INVOICECODE,
                   REF_DOC,
                   SUM (AMOUNT)               INVOICE_AMOUNT,
                   NVL (PAYMENTAMOUNT, 0)     PAYMENT_AMOUNT,
                   NVL (D.DN_AMOUNT, 0)       DN_AMOUNT
              FROM (SELECT INVOICECODE, REF_DOC, AMOUNT
                      FROM INVOICE_ALL_VIEW B
                     WHERE     B.SUPPLIERCODE = '$loccode'
                           AND B.INVOICEDATE <= '$tdate'
                           AND B.CURRCODE = NVL ( '$currency', 'IDR')
                           AND LOCATIONTYPE = '$loctype') I,
                   (  SELECT REFERENCE, SUM (AMOUNT) PAYMENTAMOUNT
                        FROM PAYMENTVOUCHER_VO A, PAYMENTVOUCHERDETAIL_VO B
                       WHERE     A.VOUCHERCODE = B.VOUCHERCODE
                             AND A.DATETRANSACTION <= '$tdate'
                             AND A.PROCESS_FLAG NOT IN ('REJECTED')
                             AND NVL (A.VOUCHERCODE, 'XXXX') !=
                                 NVL ( '$vCode', 'XXXX')
                             AND (GET_MULTIPV (1) = 0 OR GET_MULTIPV (2) = 0)
                    GROUP BY REFERENCE
                    UNION ALL
                      SELECT REFERENCE, SUM (AMOUNT) PAYMENTAMOUNT
                        FROM PAYMENTVOUCHER A, PAYMENTVOUCHERDETAIL B
                       WHERE     A.VOUCHERCODE = B.VOUCHERCODE
                             AND A.DATECREATED <= '$tdate'
                             AND A.PROCESS_FLAG NOT IN ('REJECTED')
                             AND NVL (A.VOUCHERCODE, 'XXXX') !=
                                 NVL ( '$vCode', 'XXXX')
                             AND (   GET_MULTIPV (1) = 1
                                  OR     GET_MULTIPV (2) = 1
                                     AND A.COMP_ID =
                                         APP_SECURITY_PKG.GET_SESSIONINFO_F ('COMPANYID'))
                    GROUP BY REFERENCE) P,
                   (  SELECT INVCODEREF                INVOICECODE,
                             SUM (DRINVAMTAPPLIED)     DN_AMOUNT
                        FROM DRNOTE_VO D
                       WHERE     D.DRNOTEDATE <= '$tdate'
                             AND CURRID = NVL ( '$currency', 'IDR')
                             AND (GET_MULTIPV (1) = 0 OR GET_MULTIPV (2) = 0)
                    GROUP BY INVCODEREF
                    UNION ALL
                      SELECT INVCODEREF                INVOICECODE,
                             SUM (DRINVAMTAPPLIED)     DN_AMOUNT
                        FROM DRNOTE D
                       WHERE     D.DRNOTEDATE <= '$tdate'
                             AND CURRID = NVL ( '$currency', 'IDR')
                             AND (   GET_MULTIPV (1) = 1
                                  OR     GET_MULTIPV (2) = 1
                                     AND D.COMP_ID =
                                         APP_SECURITY_PKG.GET_SESSIONINFO_F ('COMPANYID'))
                    GROUP BY INVCODEREF) D
             WHERE     I.INVOICECODE = P.REFERENCE(+)
                   AND I.INVOICECODE = D.INVOICECODE(+)
                   AND   NVL (I.AMOUNT, 0)
                       - NVL (P.PAYMENTAMOUNT, 0)
                       - NVL (DN_AMOUNT, 0) >
                       0
          GROUP BY I.INVOICECODE,
                   REF_DOC,
                   PAYMENTAMOUNT,
                   DN_AMOUNT)
)    WHERE ROWNUM > 0 AND ( LOWER(INVOICECODE) LIKE LOWER('%$q%') OR LOWER(REF_DOC) LIKE LOWER('%$q%')  )
			";

		$sql = "SELECT COUNT(*) as JUMLAH FROM ($mainSql) ";

		$sql = $this->db2->query($sql)->getRowArray();
		$result["total"] = $sql['JUMLAH'];

		$sql = "SELECT * FROM 
		(
			SELECT INVOICECODE, REF_DOC, INVOICE_AMOUNT, PAYMENT_AMOUNT, DN_AMOUNT, NULL, NETBAL_AMOUNT, ROWNUM AS RNUM FROM 
			(
				$mainSql ORDER BY  $sort $order
			)
			WHERE ROWNUM <= $limit
			)
		WHERE RNUM > $offset";

		$sql = $this->db2->query($sql)->getResultArray();
		$result['rows'] = $sql;
		return $result;
	}

	

	public function cekPKReportMasterHeader($VOUCHERID='')
	{
		$userOrganisasi = $this->session->get('userOrganisasi');
		$sql_security = "CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('" . $userOrganisasi['LOGINID'] . "', '" . $userOrganisasi['PASSWORD'] . "', '" . $userOrganisasi['COMPANYID'] . "', '" . $userOrganisasi['COMPANYSITEID'] . "');";
		$this->db2->query($sql_security);

		$sql = "SELECT * FROM PAYMENTVOUCHER_VO WHERE COMP_ID = '".$userOrganisasi['COMPANYID']."' AND SITE_ID ='" . $userOrganisasi['COMPANYSITEID']. "' AND VOUCHERID = '$VOUCHERID' ";

		$result = $this->db2->query($sql)->getRowArray();

		return $result;
	}

	public function cekPKReportMasterDetail($VOUCHERCODE='', $VOUCHERID='', $LOCTYPE_DETAILS='', $LOCATIONCODE_DETAILS='', $JOBCODE_DETAILS='', $REFERENCE_DETAILS='', $AMOUNT_DETAILS=0, $CASHFLOWCODE_DETAILS='', $REMARKS_DETAILS='')
	{
		$userOrganisasi = $this->session->get('userOrganisasi');
		$sql_security = "CALL APP_SECURITY_PKG.SET_USERAPPLICATION_P('" . $userOrganisasi['LOGINID'] . "', '" . $userOrganisasi['PASSWORD'] . "', '" . $userOrganisasi['COMPANYID'] . "', '" . $userOrganisasi['COMPANYSITEID'] . "');";
		$this->db2->query($sql_security);

		$sql = "SELECT * FROM PAYMENTVOUCHERDETAIL_VO WHERE COMP_ID = '".$userOrganisasi['COMPANYID']."' AND SITE_ID ='" . $userOrganisasi['COMPANYSITEID']. "' AND VOUCHERCODE = '$VOUCHERCODE' AND VOUCHERID = '$VOUCHERID' AND LOCATIONTYPE = '$LOCTYPE_DETAILS' AND LOCATIONCODE = '$LOCATIONCODE_DETAILS'  AND JOBCODE = '$JOBCODE_DETAILS'  AND REFERENCE = '$REFERENCE_DETAILS' AND AMOUNT = $AMOUNT_DETAILS   AND CASHFLOWCODE = '$CASHFLOWCODE_DETAILS' AND REMARKS = '$REMARKS_DETAILS' ";

		$result = $this->db2->query($sql)->getRowArray();

		return $result;
	}
		
	
	
	
    

}
