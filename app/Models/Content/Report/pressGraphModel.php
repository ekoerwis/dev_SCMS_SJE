<?php

namespace App\Models\Content\Report;

class pressGraphModel extends \App\Models\BaseModel
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
        
        if($dt_div != ""){
            $w_dt_div = " AND STZID = '$dt_div' ";
        }

        $sql="
SELECT LGSID, UEP,
        FS_CONV_UTCUEP2WIB(UEP) TDATE_UEP_DATEF,
        TO_CHAR(FS_CONV_UTCUEP2WIB(UEP),'DD/MON/YYYY HH24:MI:SS')  TDATE_UEP, 
        COMP_ID, SITE_ID, POSTDT, STZID, 
        STZIN_ST, TO_CHAR(STZIN_ST,'HH24:MI:SS') STZIN_ST_TIME, 
        STZIN_ED, TO_CHAR(STZIN_ED,'HH24:MI:SS')STZIN_ED_TIME, 
        CASE 
        WHEN STZIN_ST IS NOT NULL AND STZIN_ED IS NOT NULL
        THEN
        to_char(to_date(STP1,'sssss'),'hh24:mi:ss')
        ELSE '' END STZIN_MN,
        /* ELSE '00:00:00' END STZIN_MN,*/
        STZWS_ST, TO_CHAR(STZWS_ST,'HH24:MI:SS') STZWS_ST_TIME, 
        STZWS_ED, TO_CHAR(STZWS_ED,'HH24:MI:SS')STZWS_ED_TIME, 
        CASE 
        WHEN STZWS_ST IS NOT NULL AND STZWS_ED IS NOT NULL
        THEN
        to_char(to_date(STP1,'sssss'),'hh24:mi:ss')
        ELSE '' END STZWS_MN,
        /* ELSE '00:00:00' END STZWS_MN,*/
        STZPRO_ST,TO_CHAR(STZPRO_ST,'HH24:MI:SS') STZPRO_ST_TIME,
        STZPRO_ED, TO_CHAR(STZPRO_ED,'HH24:MI:SS') STZPRO_ED_TIME,
        CASE 
        WHEN STZPRO_ST IS NOT NULL AND STZPRO_ED IS NOT NULL
        THEN
        to_char(to_date(STP3,'sssss'),'hh24:mi:ss')
        ELSE '' END STZPRO_MN,
        /* ELSE '00:00:00' END STZPRO_MN,*/
        STZWO_ST, TO_CHAR(STZWO_ST,'HH24:MI:SS') STZWO_ST_TIME, 
        STZWO_ED, TO_CHAR(STZWO_ED,'HH24:MI:SS')STZWO_ED_TIME, 
        CASE 
        WHEN STZWO_ST IS NOT NULL AND STZWO_ED IS NOT NULL
        THEN
        to_char(to_date(STP1,'sssss'),'hh24:mi:ss')
        ELSE '' END STZWO_MN,
        /* ELSE '00:00:00' END STZWO_MN,*/
        STZOUT_ST, TO_CHAR(STZOUT_ST,'HH24:MI:SS') STZOUT_ST_TIME,
        STZOUT_ED, TO_CHAR(STZOUT_ED,'HH24:MI:SS') STZOUT_ED_TIME,
        CASE 
        WHEN STZOUT_ST IS NOT NULL AND STZOUT_ED IS NOT NULL
        THEN
        to_char(to_date(STP5,'sssss'),'hh24:mi:ss')
        ELSE '' END STZOUT_MN,
        /* ELSE '00:00:00' END STZOUT_MN,*/
        to_char(to_date((NVL(STP1,0)+NVL(STP3,0)+NVL(STP5,0)),'sssss'),'hh24:mi:ss') STZTM_TOT, 
        STZACC, STZNOTE, STP1,STP2,STP3,STP4,STP5 FROM POM_LGS_STZ WHERE  ROWNUM > 0  $w_tdate $w_dt_div
        ";

        return $sql;
    }
         
    public function dataList()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'UEP';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');


        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        if (empty($_POST['TDATE'])) {
			$TDATE  = date("d/M/Y", strtotime('yesterday'));
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_POST['TDATE']));
		}

        $DT_DIV = isset($_POST['DT_DIV']) ? strval($_POST['DT_DIV']) : '1';

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
        

        $sql = "SELECT * FROM (SELECT LGSID, UEP, TDATE_UEP_DATEF, TDATE_UEP, COMP_ID, SITE_ID, POSTDT, STZID, STZIN_ST, STZIN_ST_TIME, STZIN_ED, STZIN_ED_TIME, STZIN_MN, STZWS_ST, STZWS_ST_TIME, STZWS_ED, STZWS_ED_TIME, STZWS_MN, STZPRO_ST, STZPRO_ST_TIME, STZPRO_ED, STZPRO_ED_TIME, STZPRO_MN, STZWO_ST, STZWO_ST_TIME, STZWO_ED, STZWO_ED_TIME, STZWO_MN, STZOUT_ST, STZOUT_ST_TIME, STZOUT_ED, STZOUT_ED_TIME, STZOUT_MN, STZTM_TOT, STZACC, STZNOTE, STP1, STP2, STP3, STP4, STP5, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result['rows'] = $sql;
    
        return $result;
    }


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

    public function dataGraph1()
    {   
        // $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'UEP';
        // $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        

        // if (empty($_GET['TDATE'])) {
		// 	$TDATE  = '';
		// } else {
		// 	$TDATE  =  date("d/M/Y", strtotime($_GET['TDATE']));
		// }

        // $DT_DIV = isset($_GET['DT_DIV']) ? strval($_GET['DT_DIV']) : '';

        // $result = array();

        // $sqlReport = $this->reportSqlString($TDATE, $DT_DIV);
        $sql = "SELECT * FROM POM_LGS_PRS WHERE POSTDT = '6/MAY/2023' ORDER BY SEQ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }

}
