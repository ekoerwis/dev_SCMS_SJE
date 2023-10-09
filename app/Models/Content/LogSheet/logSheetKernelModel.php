<?php

namespace App\Models\Content\LogSheet;

class logSheetKernelModel extends \App\Models\BaseModel
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

        $sql="SELECT LPAD(KERHR,2,'0') TIME_DISP, LGSID, SEQ, UEP, COMP_ID, SITE_ID, POSTDT, KERID, KERHR, 
        KERSIL_TMP1, KERSIL_TMP2, KERSIL_TMP3, KERSIL_TMP4, KERSIL_TMP5, KERSIL_TMP6, 
        KERHDS_STR1, KERHDS_STR2, KERHDS_STR3, KERHDS_STR4, KERHDS_STR5, KERHDS_STR6, KERHDS_STR7, KERHDS_STR8, 
        KERHDS_END1, KERHDS_END2, KERHDS_END3, KERHDS_END4, KERHDS_END5, KERHDS_END6, KERHDS_END7, KERHDS_END8, 
        TO_CHAR(KERHDS_STR1,'HH24:MI') KERHDS_STR1_DISP, TO_CHAR(KERHDS_STR2,'HH24:MI') KERHDS_STR2_DISP, TO_CHAR(KERHDS_STR3,'HH24:MI') KERHDS_STR3_DISP, TO_CHAR(KERHDS_STR4,'HH24:MI') KERHDS_STR4_DISP, TO_CHAR(KERHDS_STR5,'HH24:MI') KERHDS_STR5_DISP, TO_CHAR(KERHDS_STR6,'HH24:MI') KERHDS_STR6_DISP, TO_CHAR(KERHDS_STR7,'HH24:MI') KERHDS_STR7_DISP, TO_CHAR(KERHDS_STR8,'HH24:MI') KERHDS_STR8_DISP, 
        TO_CHAR(KERHDS_END1,'HH24:MI') KERHDS_END1_DISP, TO_CHAR(KERHDS_END2,'HH24:MI') KERHDS_END2_DISP, TO_CHAR(KERHDS_END3,'HH24:MI') KERHDS_END3_DISP, TO_CHAR(KERHDS_END4,'HH24:MI') KERHDS_END4_DISP, TO_CHAR(KERHDS_END5,'HH24:MI') KERHDS_END5_DISP, TO_CHAR(KERHDS_END6,'HH24:MI') KERHDS_END6_DISP, TO_CHAR(KERHDS_END7,'HH24:MI') KERHDS_END7_DISP, TO_CHAR(KERHDS_END8,'HH24:MI') KERHDS_END8_DISP, 
        KERRPM_HMS1, KERRPM_HMS2, KERRPM_HMS3, KERRPM_HMS4, KERRPM_HMS5, KERRPM_HMS6, KERRPM_HMS7, KERRPM_HMS8, 
        KERRPM_HME1, KERRPM_HME2, KERRPM_HME3, KERRPM_HME4, KERRPM_HME5, KERRPM_HME6, KERRPM_HME7, KERRPM_HME8, KERAPP_DT, KERAPP_BY, KERNOTE FROM POM_LGS_KER 
        WHERE POSTDT = TO_DATE('$tdate','dd/mon/yyyy') 
        ORDER BY SEQ
        ";

        return $sql;
    }

    public function getStationID()
    {
        
        $userOrganisasi=$this->session->get('userOrganisasi');
        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];        

        $sql = " SELECT DISTINCT TRIM(CLRID) ID, TRIM(CLRID) DESCRIPTION FROM POM_LGS_CLR ORDER BY 1";
        
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

        // $id = isset($_POST['STATIONID']) ? strval($_POST['STATIONID']) : '';

        $sqlReport = $this->reportSqlString($TDATE);

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
        

        $sql = "SELECT * FROM (SELECT TIME_DISP, LGSID, SEQ, UEP, COMP_ID, SITE_ID, POSTDT, KERID, KERHR, 
        KERSIL_TMP1, KERSIL_TMP2, KERSIL_TMP3, KERSIL_TMP4, KERSIL_TMP5, KERSIL_TMP6, 
        KERHDS_STR1, KERHDS_STR2, KERHDS_STR3, KERHDS_STR4, KERHDS_STR5, KERHDS_STR6, KERHDS_STR7, KERHDS_STR8, 
        KERHDS_END1, KERHDS_END2, KERHDS_END3, KERHDS_END4, KERHDS_END5, KERHDS_END6, KERHDS_END7, KERHDS_END8, 
        KERHDS_STR1_DISP, KERHDS_STR2_DISP, KERHDS_STR3_DISP, KERHDS_STR4_DISP, KERHDS_STR5_DISP, KERHDS_STR6_DISP, KERHDS_STR7_DISP, KERHDS_STR8_DISP, 
        KERHDS_END1_DISP, KERHDS_END2_DISP, KERHDS_END3_DISP, KERHDS_END4_DISP, KERHDS_END5_DISP, KERHDS_END6_DISP, KERHDS_END7_DISP, KERHDS_END8_DISP, 
        KERRPM_HMS1, KERRPM_HMS2, KERRPM_HMS3, KERRPM_HMS4, KERRPM_HMS5, KERRPM_HMS6, KERRPM_HMS7, KERRPM_HMS8, 
        KERRPM_HME1, KERRPM_HME2, KERRPM_HME3, KERRPM_HME4, KERRPM_HME5, KERRPM_HME6, KERRPM_HME7, KERRPM_HME8, KERAPP_DT, KERAPP_BY, KERNOTE,
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

        // $STATIONID = isset($_GET['STATIONID']) ? strval($_GET['STATIONID']) : '1';

        $result = array();

        $sqlReport = $this->reportSqlString($TDATE);
        $sql = "SELECT * FROM ( $sqlReport ) WHERE ROWNUM > 0
        ORDER BY $sort $order ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }

}
