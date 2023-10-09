<?php

namespace App\Models\Content\Approval;

class ApprovalListLogsheetModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

         
    public function dataList($user_data)
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'IDMODULE';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');

        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        $sess_iduser = $user_data['ID_ROLE'];

        $MONTHNUMBER = isset($_POST['MONTHNUMBER']) ? intval($_POST['MONTHNUMBER']) : 0;
        $YEARNUMBER = isset($_POST['YEARNUMBER']) ? intval($_POST['YEARNUMBER']) : 0;

        $mainSql="SELECT * FROM (
            SELECT $MONTHNUMBER MONTHNUMBER, $YEARNUMBER YEARNUMBER, A.ID, A.IDHEADER, A.LVL, A.IDROLE, B.IDCONTENT, B.REMARKS, B.MAXLEVEL, 
            C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
            FROM MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
            WHERE A.IDROLE = $sess_iduser 
            AND A.IDHEADER=B.ID
            AND B.IDCONTENT=C.ID
            AND C.IDMODULE = D.ID_MODULE
            AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
        ) WHERE ROWNUM > 0";

        $limit = $page*$rows;
        $offset = ($page-1)*$rows;
        $result = array();
        
    $sql = "SELECT count(*) AS JUMLAH FROM 
                (
                    $mainSql
                )";
        $sql = $this->db->query($sql)->getRowArray();
        $result["total"] = $sql['JUMLAH'];
        

        $sql = "SELECT * FROM (SELECT MONTHNUMBER, YEARNUMBER, ID, IDHEADER, LVL, IDROLE, IDCONTENT, REMARKS, MAXLEVEL,
        IDMODULE, TABLECONTENT, NAMA_MODULE, JUDUL_MODULE, DESKRIPSI, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $dataRow = $this->db->query($sql)->getResultArray();

        $dataFull = array();

        foreach ($dataRow as $data) {
			$dataDetail['TOTALLSMONTH'] = $this->getTotalLS($MONTHNUMBER,$YEARNUMBER, $data['TABLECONTENT'])['COUNTDATAMOUNT'];
            $dataDetail['COUNTFINISHLS'] = $this->getCountFinishLS($MONTHNUMBER,$YEARNUMBER, $data['TABLECONTENT'])['COUNTFINISHLS'];
            $dataDetail['UNFINISHLS'] = $dataDetail['TOTALLSMONTH'] - $dataDetail['COUNTFINISHLS'] ;
            $dataDetail['COUNTNEEDACTION'] = $this->getCountNeedActionLS($MONTHNUMBER,$YEARNUMBER, $data['TABLECONTENT'],$data['LVL'])['COUNTNEEDACTION'];
			$data = array_merge($data, $dataDetail);

			array_push($dataFull, $data);
		}

        $result['rows'] = $dataFull;
    
        return $result;
    }

    public function getTotalLS($monthnumber,$yearnumber,  $tablename)
    {   
        $sql = "SELECT COUNT(DISTINCT(POSTDT)) COUNTDATAMOUNT FROM  $tablename WHERE EXTRACT (MONTH FROM POSTDT) = $monthnumber AND EXTRACT (YEAR FROM POSTDT) = $yearnumber";
        
        $sql = $this->db->query($sql)->getRowArray();

        $result = $sql;
    
        return $result;
    }

    public function FinishLSSqlString($monthnumber,$yearnumber,  $tablename){
        $sql = "SELECT * FROM (
            SELECT X.ID, X.ID_APPROVAL_DETAIL , X.LS_POSTDT, X.STATUS, X.REMARKS , A.IDHEADER, A.LVL, A.IDROLE, B.IDCONTENT, B.REMARKS REMARKS_HEADER, B.MAXLEVEL,
            C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
            FROM LIST_LS_STATUS_APPROVAL X , MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
            WHERE X.ID_APPROVAL_DETAIL  = A.ID
            --AND A.LVL >= :P_LVL_ROLE
            AND A.IDHEADER=B.ID
            AND B.IDCONTENT=C.ID
            AND C.IDMODULE = D.ID_MODULE
            AND  EXTRACT (MONTH FROM LS_POSTDT) = $monthnumber AND EXTRACT (YEAR FROM LS_POSTDT) = $yearnumber
            AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            ) A ,
            (SELECT MAX(LVL) MAXLVL
            FROM (
            SELECT A.ID, A.IDHEADER, A.LVL, A.IDROLE, B.IDCONTENT, B.REMARKS, B.MAXLEVEL,
            C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
            FROM MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
            WHERE 
            --A.IDROLE = :P_ID_ROLE AND 
            A.IDHEADER=B.ID
            AND B.IDCONTENT=C.ID
            AND C.IDMODULE = D.ID_MODULE
            AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            ) WHERE TABLECONTENT = '$tablename') B
             WHERE A.TABLECONTENT = '$tablename'
             AND A.LVL = B.MAXLVL";

        return $sql;
    
    }

    public function getCountFinishLS($monthnumber,$yearnumber,  $tablename)
    {   
        $sqlReport = $this->finishLSSqlString( $monthnumber,$yearnumber,  $tablename );

        $sql = "SELECT COUNT(*) COUNTFINISHLS FROM ( $sqlReport )";
        
        $sql = $this->db->query($sql)->getRowArray();

        $result = $sql;
    
        return $result;
    }

    public function dataListStatus($user_data)
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'POSTDT';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');

        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        $sess_iduser = $user_data['ID_ROLE'];

        $MONTHNUMBER=isset($_GET['MONTHNUMBER']) ? intval($_GET['MONTHNUMBER']) : 0;
		$YEARNUMBER=isset($_GET['YEARNUMBER']) ? intval($_GET['YEARNUMBER']) : 0;
		$IDMODULE=isset($_GET['IDMODULE']) ? intval($_GET['IDMODULE']) : 0;

        // $sqlModule = "SELECT ID_MODULE, NAMA_MODULE, JUDUL_MODULE, DESKRIPSI FROM MODULE WHERE ID_MODULE = $IDMODULE";
        // $dataModule = $this->db->query($sqlModule)->getRowArray();

        $mainSqlSatu="SELECT * FROM (
            SELECT $MONTHNUMBER MONTHNUMBER, $YEARNUMBER YEARNUMBER, A.ID, A.IDHEADER, A.LVL, A.IDROLE, B.IDCONTENT, B.REMARKS, B.MAXLEVEL, 
            C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
            FROM MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
            WHERE A.IDROLE = $sess_iduser 
            AND A.IDHEADER=B.ID
            AND B.IDCONTENT=C.ID
            AND C.IDMODULE = D.ID_MODULE
            AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
        ) WHERE ROWNUM > 0 AND IDMODULE = $IDMODULE";

        $dataSatu = $this->db->query($mainSqlSatu)->getRowArray();

        $nama_module = $dataSatu['NAMA_MODULE'];
        $judul_module = $dataSatu['JUDUL_MODULE'];
        $deskripsi_module = $dataSatu['DESKRIPSI'];

        // $sqlData = $this->needActionLSSqlString( $MONTHNUMBER,$YEARNUMBER,  $dataSatu['TABLECONTENT'], $dataSatu['LVL']  );

        // $mainSql = "SELECT DISTINCT POSTDT, TO_CHAR(POSTDT,'FXFMDD-Mon-YYYY') POSTDT2, ". $dataSatu['ID']." ID_MS_APPROVAL_DETAIL , '".$nama_module."' NAMA_MODULE   FROM ( $sqlData )";

        $mainSql ="SELECT DISTINCT POSTDT , TO_CHAR(POSTDT,'FXFMDD-Mon-YYYY') POSTDT2, '".$nama_module."' NAMA_MODULE  ,'".$judul_module."' JUDUL_MODULE, '".$deskripsi_module."' DESKRIPSI,
        CASE WHEN POSTDT IN (SELECT DISTINCT LS_POSTDT FROM (
                    SELECT X.ID, X.ID_APPROVAL_DETAIL , X.LS_POSTDT, X.STATUS, X.REMARKS , A.IDHEADER, A.LVL, A.IDROLE, B.IDCONTENT, B.REMARKS REMARKS_HEADER, B.MAXLEVEL,
                    C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
                    FROM LIST_LS_STATUS_APPROVAL X , MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
                    WHERE X.ID_APPROVAL_DETAIL  = A.ID
                    AND A.IDHEADER=B.ID
                    AND B.IDCONTENT=C.ID
                    AND C.IDMODULE = D.ID_MODULE
                    AND  EXTRACT (MONTH FROM LS_POSTDT) = $MONTHNUMBER AND EXTRACT (YEAR FROM LS_POSTDT) = $YEARNUMBER
                    AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
                    AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
                    ) A ,
                    (SELECT MAX(LVL) MAXLVL
                    FROM (
                    SELECT A.ID, A.IDHEADER, A.LVL, A.IDROLE, B.IDCONTENT, B.REMARKS, B.MAXLEVEL,
                    C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
                    FROM MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
                    WHERE 
                    A.IDHEADER=B.ID
                    AND B.IDCONTENT=C.ID
                    AND C.IDMODULE = D.ID_MODULE
                    AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
                    AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
                    ) WHERE TABLECONTENT = '".$dataSatu['TABLECONTENT']."') B
                     WHERE A.TABLECONTENT = '".$dataSatu['TABLECONTENT']."'
                     AND A.LVL = B.MAXLVL)
                     THEN 1 ELSE 0 END STATUS_FINISH
        FROM ".$dataSatu['TABLECONTENT']." 
        WHERE  EXTRACT (MONTH FROM POSTDT) = $MONTHNUMBER AND EXTRACT (YEAR FROM POSTDT) = $YEARNUMBER";

        $limit = $page*$rows;
        $offset = ($page-1)*$rows;
        $result = array();
        
    $sql = "SELECT count(*) AS JUMLAH FROM 
                (
                    $mainSql
                )";
        $sql = $this->db->query($sql)->getRowArray();
        $result["total"] = $sql['JUMLAH'];
        

        $sql = "SELECT * FROM (SELECT POSTDT, POSTDT2, NAMA_MODULE, JUDUL_MODULE, DESKRIPSI, STATUS_FINISH, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $dataRow = $this->db->query($sql)->getResultArray();

        $result['rows'] = $dataRow;
    
        return $result;
    }

    public function getModuleLS($id=0)
    {   
        $sqlModule = "SELECT ID_MODULE, NAMA_MODULE, JUDUL_MODULE, DESKRIPSI FROM MODULE WHERE ID_MODULE = $id";

        $dataModule = $this->db->query($sqlModule)->getRowArray();

    
        return $dataModule;
    }


    public function needActionLSSqlString($monthnumber,$yearnumber,  $tablename, $lvluser){
        $sql = "SELECT A.* FROM $tablename A 
        WHERE EXTRACT (MONTH FROM A.POSTDT) = $monthnumber 
        AND EXTRACT (YEAR FROM A.POSTDT) = $yearnumber 
        AND A.POSTDT NOT IN  ( SELECT DISTINCT LS_POSTDT FROM (
       SELECT X.ID, X.ID_APPROVAL_DETAIL , X.LS_POSTDT, X.STATUS, X.REMARKS , A.IDHEADER, A.LVL, A.IDROLE, B.IDCONTENT, B.REMARKS REMARKS_HEADER, B.MAXLEVEL,
                   C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
                   FROM LIST_LS_STATUS_APPROVAL X , MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
                   WHERE X.ID_APPROVAL_DETAIL  = A.ID
                   AND A.LVL >= $lvluser
                   AND A.IDHEADER=B.ID
                   AND B.IDCONTENT=C.ID
                   AND C.IDMODULE = D.ID_MODULE
                   AND  EXTRACT (MONTH FROM LS_POSTDT) = $monthnumber AND EXTRACT (YEAR FROM LS_POSTDT) = $yearnumber
                   AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
                   AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE)
                   WHERE TABLECONTENT = '$tablename')";

        return $sql;
    
    }

    public function getCountNeedActionLS($monthnumber, $yearnumber,  $tablename, $lvluser)
    {   

        $sqlReport = $this->needActionLSSqlString( $monthnumber,$yearnumber,  $tablename, $lvluser );

        $sql = "SELECT COUNT(DISTINCT(POSTDT)) COUNTNEEDACTION FROM ( $sqlReport )";
        
        $sql = $this->db->query($sql)->getRowArray();

        $result = $sql;
    
        return $result;
    }

    

    public function dataListNeedAction($user_data)
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'POSTDT';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');

        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        $sess_iduser = $user_data['ID_ROLE'];

        $MONTHNUMBER=isset($_GET['MONTHNUMBER']) ? intval($_GET['MONTHNUMBER']) : 0;
		$YEARNUMBER=isset($_GET['YEARNUMBER']) ? intval($_GET['YEARNUMBER']) : 0;
		$IDMODULE=isset($_GET['IDMODULE']) ? intval($_GET['IDMODULE']) : 0;

        $mainSqlSatu="SELECT * FROM (
            SELECT $MONTHNUMBER MONTHNUMBER, $YEARNUMBER YEARNUMBER, A.ID, A.IDHEADER, A.LVL, A.IDROLE, B.IDCONTENT, B.REMARKS, B.MAXLEVEL, 
            C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
            FROM MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
            WHERE A.IDROLE = $sess_iduser 
            AND A.IDHEADER=B.ID
            AND B.IDCONTENT=C.ID
            AND C.IDMODULE = D.ID_MODULE
            AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
        ) WHERE ROWNUM > 0 AND IDMODULE = $IDMODULE";

        $dataSatu = $this->db->query($mainSqlSatu)->getRowArray();

        $nama_module = $dataSatu['NAMA_MODULE'];

        $sqlData = $this->needActionLSSqlString( $MONTHNUMBER,$YEARNUMBER,  $dataSatu['TABLECONTENT'], $dataSatu['LVL']  );

        $mainSql = "SELECT DISTINCT POSTDT, TO_CHAR(POSTDT,'FXFMDD-Mon-YYYY') POSTDT2, ". $dataSatu['ID']." ID_MS_APPROVAL_DETAIL , '".$nama_module."' NAMA_MODULE   FROM ( $sqlData )";

        $limit = $page*$rows;
        $offset = ($page-1)*$rows;
        $result = array();
        
    $sql = "SELECT count(*) AS JUMLAH FROM 
                (
                    $mainSql
                )";
        $sql = $this->db->query($sql)->getRowArray();
        $result["total"] = $sql['JUMLAH'];
        

        $sql = "SELECT * FROM (SELECT POSTDT, POSTDT2, ID_MS_APPROVAL_DETAIL,'-' REMARKS, NAMA_MODULE, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $dataRow = $this->db->query($sql)->getResultArray();

        $result['rows'] = $dataRow;
    
        return $result;
    }

    public function actionApprove($user_data)
    {
        $ID_MS_APPROVAL_DETAIL = isset($_POST['ID_MS_APPROVAL_DETAIL']) ? intval($_POST['ID_MS_APPROVAL_DETAIL']) : 0;
        $POSTDT2 = '';

		if(!empty($_POST['POSTDT2'])){
			$POSTDT2 = date("d/M/Y", strtotime($_POST['POSTDT2']));
		}

        $cekpk = $this->CHECK_LS_APPROVE($ID_MS_APPROVAL_DETAIL,$POSTDT2);

        if (isset($cekpk)) {
            $result['msg']['status'] = 'error';
            $result['msg']['content'] = 'Data Sudah Ada Hubungi Adminstrator';	

           
        } else {
            try {    

                $sqlNo = "SELECT NVL(MAX(ID),0)+1 IDNO FROM LIST_LS_STATUS_APPROVAL";
                $dataIDNO = $this->db->query($sqlNo)->getRowArray()['IDNO'];
                // $LS_POSTDT = date("d/M/Y");
                $STATUS = 1;
                $INPUTDATE = date("d/M/Y");

                $sess_iduser = $user_data['ID_USER'];

                $sqlInsert = " INSERT INTO LIST_LS_STATUS_APPROVAL (ID, ID_APPROVAL_DETAIL, LS_POSTDT, STATUS, INPUTBY, INPUTDATE) VALUES ($dataIDNO , $ID_MS_APPROVAL_DETAIL, '$POSTDT2', $STATUS, '$sess_iduser','$INPUTDATE')";
                $insert = $this->db->query($sqlInsert);
    
                if ($insert) {
                    $this->db->query('COMMIT');
                    $result['msg']['status'] = 'ok';
                    $result['msg']['content'] = 'Proses Berhasil';
                }
            } catch (\Exception $e) {
                $result['msg']['status'] = 'error';
                $result['msg']['content'] = 'Proses Gagal';
                // die($e->getMessage());
            } 		
        }
        
        return $result;
    }

    public function CHECK_LS_APPROVE($ID_MS_APPROVAL_DETAIL,$POSTDT2)
	{
		$sql = "SELECT * FROM LIST_LS_STATUS_APPROVAL 
        WHERE ID_APPROVAL_DETAIL = $ID_MS_APPROVAL_DETAIL AND LS_POSTDT = '$POSTDT2' ";

		$result = $this->db->query($sql)->getRowArray();

		return $result;
	}

    // batas pakai


    public function dataListExcel()
    {   
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'UEP';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        

        if (empty($_GET['TDATE'])) {
			$TDATE  = '';
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_GET['TDATE']));
		}

        $DT_DIV = isset($_GET['DT_DIV']) ? strval($_GET['DT_DIV']) : '';

        $result = array();

        $sqlReport = $this->reportSqlString($TDATE, $DT_DIV);
        $sql = "SELECT * FROM ( $sqlReport ) WHERE ROWNUM > 0
        ORDER BY $sort $order ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }

}
