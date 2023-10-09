<?php

namespace App\Models\Content;

class scdTrMonitorModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

    public function reportSqlString($tdate="",$dt_div="" ){

        $w_tdate = " ";
        $w_dt_div = " ";

        if($tdate != ""){
            $w_tdate = " AND POSTDT = '$tdate' ";
        }
        
        if($dt_div != ""){
            $w_dt_div = " AND DT_DIV = '$dt_div' ";
        }

        $sql="SELECT CRTTS, CRTBY, UPDTS, UPDBY, TRM, UTC_MW, UTC_MTU, SVRDT, POSTDT, ORG_ID, ORG_CODE, ORG_CODE_PR, DT_ID, DT_UEP, DT_DIV, DT_ADD, DT_VAL, DT_TYPE,
        FS_CONV_UTCUEP2WIB(DT_UEP) DT_EUP_LOCAL,
        TO_CHAR(FS_CONV_UTCUEP2WIB(DT_UEP) ,'DD/MON/YYYY HH24:MI:SS') TDATETIME
        FROM SCD_TRMONITOR WHERE  ROWNUM > 0 $w_tdate $w_dt_div
        ";

        return $sql;
    }
         
    public function dataList()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'DT_ID';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');


        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];


        if (empty($_POST['TDATE'])) {
			$TDATE = '';
		} else {
			$TDATE =  date("d/M/Y", strtotime($_POST['TDATE']));
		}

        $DT_DIV = isset($_POST['DT_DIV']) ? strval($_POST['DT_DIV']) : '';

        $sqlReport = $this->reportSqlString($TDATE,$DT_DIV);
        $mainSql="SELECT * FROM ($sqlReport) WHERE ROWNUM > 0";

        $limit = $page*$rows;
        $offset = ($page-1)*$rows;
        $result = array();
        
    $sql = "SELECT count(*) AS JUMLAH FROM 
                (
                    $mainSql
                )";
        $sql = $this->db->query($sql)->getRowArray();
        $result["total"] = $sql['JUMLAH'];
        

        $sql = "SELECT * FROM (SELECT CRTTS, CRTBY, UPDTS, UPDBY, TRM, UTC_MW, UTC_MTU, SVRDT, POSTDT, ORG_ID, ORG_CODE, ORG_CODE_PR, DT_ID, DT_UEP, DT_DIV, DT_ADD, DT_VAL, DT_TYPE, DT_EUP_LOCAL, TDATETIME, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result['rows'] = $sql;
    
        return $result;
    }


    public function dataListExcel()
    {   
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'DT_ID';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

        $result = array();

        if (empty($_GET['TDATE'])) {
			$TDATE = '';
		} else {
			$TDATE =  date("d/M/Y", strtotime($_GET['TDATE']));
		}

        $DT_DIV = isset($_GET['DT_DIV']) ? strval($_GET['DT_DIV']) : '';

        $sqlReport = $this->reportSqlString($TDATE,$DT_DIV);

        $sql = "SELECT * FROM ( $sqlReport ) WHERE ROWNUM > 0
        ORDER BY $sort $order ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }

}
