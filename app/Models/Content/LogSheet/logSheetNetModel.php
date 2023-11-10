<?php

namespace App\Models\Content\LogSheet;

class logSheetNetModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

    public function reportSqlString($tdate='' ,$dt_div=''){

        $w_tdate = " ";
        $w_dt_div = " ";

        if($tdate != ""){
            $w_tdate = " AND POSTDT = '$tdate' ";
        }
        
        if($dt_div != "" && $dt_div != "ALL"){
            $w_dt_div = " AND NETADD = '$dt_div' ";
        }

        $sql="
        SELECT NETID, COMP_ID, SITE_ID, POSTDT, NETDIV, NETADD, NETHR, NETCHK, NETCNT, NETMSG 
        FROM POM_LGS_NET
        WHERE UPPER(NETCHK) <> 'OK'AND ROWNUM > 0  $w_tdate $w_dt_div
        ";

        return $sql;
    }
         
    public function dataList()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'NETADD, NETHR';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');


        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        if (empty($_POST['TDATE'])) {
			$TDATE  = date("d/M/Y", strtotime('yesterday'));
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_POST['TDATE']));
		}

        $DT_DIV = isset($_POST['DT_DIV']) ? strval($_POST['DT_DIV']) : '';

        $sqlReport = $this->reportSqlString($TDATE, $DT_DIV );

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
        

        $sql = "SELECT * FROM (SELECT NETID, COMP_ID, SITE_ID, POSTDT, NETDIV, NETADD, NETHR, NETCHK, NETCNT, NETMSG, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result['rows'] = $sql;
    
        return $result;
    }


    public function dataListExcel()
    {   
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'NETADD, NETHR';
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

    
    public function getNetAdd()
    {
        $sqlParam = "SELECT * FROM (
            SELECT '00000' NETDIV, 'ALL' NETADD, 'ALL' XCODE, 'true' SELECTED FROM DUAL
            UNION ALL
            SELECT DISTINCT NETDIV, NETADD, NETDIV||' - '||NETADD XCODE, 'false' SELECTTED FROM POM_LGS_NET
             ) ORDER BY NETDIV , NETADD";
        $execSqlParam = $this->db->query($sqlParam)->getResultArray();
        $result = array();

        for($i=0 ; $i < count($execSqlParam) ; $i++) {
            $result[$i]['NETDIV'] =  $execSqlParam[$i]['NETDIV'];
            $result[$i]['NETADD'] =  $execSqlParam[$i]['NETADD'] ;
            $result[$i]['XCODE'] =  $execSqlParam[$i]['XCODE'] ;
            $result[$i]['selected'] =  false ;
            if($execSqlParam[$i]['SELECTED'] == 'true' ){
                $result[$i]['selected'] =  true ;
            }
        }
        return $result;
    }

}
