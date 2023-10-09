<?php

namespace App\Models\Content\LogSheet;

class logSheetPowerhouseTurbinModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

    public function reportSqlString($tdate='' ,$id=''){

        // $w_tdate = " ";
        // $w_dt_div = " ";

        // if($tdate != ""){
        //     $w_tdate = " AND POSTDT = TO_DATE('$tdate','dd/mon/yyyy') ";
        // }
        
        // if($dt_div != ""){
        //     $w_dt_div = " AND STGID = '$dt_div' ";
        // }

        $sql=" SELECT LPAD(PWSHR,2,'0') TIME_DISP,LGSID, SEQ, UEP, COMP_ID, SITE_ID, POSTDT, PWSID, PWSNO, PWSHR, 
        PWSAPP_DT, PWSAPP_BY, PWSNOTE, PWSNZL_PRS, PWSINL_PRS, PWSEXH_PRS, PWSGRB_PRS, 
        PWSTBO_PRS, PWSSTM_TMP, PWSOIL_TMP, PWSBRO_PIN_TMP1, PWSBRO_BUL_TMP1, PWSBRO_PIN_TMP2, PWSBRO_BUL_TMP2, 
        PWSGVN_LLM, PWS_RPM, PWS_HZ, PWS_V, PWS_COST, PWS_I_R, PWS_I_S, PWS_I_T, PWS_KWH, PWS_HM , PWS_KWH*PWS_HM PWS_KW
        FROM POM_LGS_PWS_TURBINE WHERE POSTDT = TO_DATE('$tdate','dd/mon/yyyy') AND PWSID = '$id'  
        ";

        return $sql;
    }

    public function getStationID()
    {
        
        // $userOrganisasi=$this->session->get('userOrganisasi');
        // $sess_comp=$userOrganisasi['COMPANYID'];
        // $sess_site= $userOrganisasi['COMPANYSITEID'];        

        $sql = " SELECT DISTINCT TRIM(PWSID) ID, TRIM(PWSID) DESCRIPTION FROM POM_LGS_PWS_TURBINE ORDER BY 1";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }
         
    public function dataList()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'SEQ';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');


        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        if (empty($_POST['TDATE'])) {
			$TDATE  = date("d/M/Y", strtotime('yesterday'));
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_POST['TDATE']));
		}

        $id = isset($_POST['STATIONID']) ? strval($_POST['STATIONID']) : '';

        $sqlReport = $this->reportSqlString($TDATE, $id );

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
        

        $sql = "SELECT * FROM (SELECT TIME_DISP,LGSID, SEQ, UEP, COMP_ID, SITE_ID, POSTDT, PWSID, PWSNO, PWSHR, 
        PWSAPP_DT, PWSAPP_BY, PWSNOTE, PWSNZL_PRS, PWSINL_PRS, PWSEXH_PRS, PWSGRB_PRS, 
        PWSTBO_PRS, PWSSTM_TMP, PWSOIL_TMP, PWSBRO_PIN_TMP1, PWSBRO_BUL_TMP1, PWSBRO_PIN_TMP2, PWSBRO_BUL_TMP2, 
        PWSGVN_LLM, PWS_RPM, PWS_HZ, PWS_V, PWS_COST, PWS_I_R, PWS_I_S, PWS_I_T, PWS_KWH, PWS_HM , PWS_KW,
        ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result['rows'] = $sql;
    
        return $result;
    }


    public function dataListExcel()
    {   
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'SEQ';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        

        if (empty($_GET['TDATE'])) {
			$TDATE  = '';
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_GET['TDATE']));
		}

        $STATIONID = isset($_GET['STATIONID']) ? strval($_GET['STATIONID']) : '1';

        $result = array();

        $sqlReport = $this->reportSqlString($TDATE, $STATIONID);
        $sql = "SELECT * FROM ( $sqlReport ) WHERE ROWNUM > 0
        ORDER BY $sort $order ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }

}
