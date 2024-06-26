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

        $sql="SELECT LPAD (KERHR, 2, '0') TIME_DISP,
        LGSID,
        SEQ,
        UEP,
        COMP_ID,
        SITE_ID,
        POSTDT,
        KERID,
        KERHR,
        KERSIL_TMP1,
        KERSIL_TMP2,
        KERSIL_TMP3,
        KERSIL_TMP4,
        KERSIL_TMP5,
        KERSIL_TMP6,
        KERHDS_L1ACT,
        KERHDS_L2ACT,
        KERHDS_L11ACT,
        KERHDS_L12ACT,
        KERHDS_L13ACT,
        KERHDS_L21ACT,
        KERHDS_L22ACT,
        KERHDS_L23ACT,
        KERHDS_HMS11,
        KERHDS_HMS12,
        KERHDS_HMS13,
        KERHDS_HMS21,
        KERHDS_HMS22,
        KERHDS_HMS23,
        KERHDS_HME11,
        KERHDS_HME12,
        KERHDS_HME13,
        KERHDS_HME21,
        KERHDS_HME22,
        KERHDS_HME23,
        KERHDS_STR11,
        KERHDS_STR12,
        KERHDS_STR13,
        KERHDS_STR14,
        KERHDS_STR21,
        KERHDS_STR22,
        KERHDS_STR23,
        KERHDS_STR24,
        KERHDS_END11,
        KERHDS_END12,
        KERHDS_END13,
        KERHDS_END14,
        KERHDS_END21,
        KERHDS_END22,
        KERHDS_END23,
        KERHDS_END24,
        TO_CHAR (KERHDS_STR11, 'HH24:MI')     KERHDS_STR11_DISP,
        TO_CHAR (KERHDS_STR12, 'HH24:MI')     KERHDS_STR12_DISP,
        TO_CHAR (KERHDS_STR13, 'HH24:MI')     KERHDS_STR13_DISP,
        TO_CHAR (KERHDS_STR14, 'HH24:MI')     KERHDS_STR14_DISP,
        TO_CHAR (KERHDS_STR21, 'HH24:MI')     KERHDS_STR21_DISP,
        TO_CHAR (KERHDS_STR22, 'HH24:MI')     KERHDS_STR22_DISP,
        TO_CHAR (KERHDS_STR23, 'HH24:MI')     KERHDS_STR23_DISP,
        TO_CHAR (KERHDS_STR24, 'HH24:MI')     KERHDS_STR24_DISP,
        TO_CHAR (KERHDS_END11, 'HH24:MI')     KERHDS_END11_DISP,
        TO_CHAR (KERHDS_END12, 'HH24:MI')     KERHDS_END12_DISP,
        TO_CHAR (KERHDS_END13, 'HH24:MI')     KERHDS_END13_DISP,
        TO_CHAR (KERHDS_END14, 'HH24:MI')     KERHDS_END14_DISP,
        TO_CHAR (KERHDS_END21, 'HH24:MI')     KERHDS_END21_DISP,
        TO_CHAR (KERHDS_END22, 'HH24:MI')     KERHDS_END22_DISP,
        TO_CHAR (KERHDS_END23, 'HH24:MI')     KERHDS_END23_DISP,
        TO_CHAR (KERHDS_END24, 'HH24:MI')     KERHDS_END24_DISP,
        KERBAS_S1,
        KERBAS_E1,
        KERRPM_HMS1,
        KERRPM_HMS2,
        KERRPM_HMS3,
        KERRPM_HMS4,
        KERRPM_HMS5,
        KERRPM_HMS6,
        KERRPM_HMS7,
        KERRPM_HMS8,
        KERRPM_HME1,
        KERRPM_HME2,
        KERRPM_HME3,
        KERRPM_HME4,
        KERRPM_HME5,
        KERRPM_HME6,
        KERRPM_HME7,
        KERRPM_HME8,
        KERAPP_DT,
        KERAPP_BY,
        KERNOTE,
        '' HDCAWAL,
        '' HDCAKHIR
        FROM POM_LGS_KER 
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
        

        $sql = "SELECT * FROM (SELECT TIME_DISP, LGSID, SEQ, UEP, COMP_ID, SITE_ID, POSTDT, KERID, KERHR, KERSIL_TMP1, KERSIL_TMP2, KERSIL_TMP3, KERSIL_TMP4, KERSIL_TMP5, KERSIL_TMP6, KERHDS_L1ACT, KERHDS_L2ACT, KERHDS_L11ACT, KERHDS_L12ACT, KERHDS_L13ACT, KERHDS_L21ACT, KERHDS_L22ACT, KERHDS_L23ACT, KERHDS_HMS11, KERHDS_HMS12, KERHDS_HMS13, KERHDS_HMS21, KERHDS_HMS22, KERHDS_HMS23, KERHDS_HME11, KERHDS_HME12, KERHDS_HME13, KERHDS_HME21, KERHDS_HME22, KERHDS_HME23, KERHDS_STR11, KERHDS_STR12, KERHDS_STR13, KERHDS_STR14, KERHDS_STR21, KERHDS_STR22, KERHDS_STR23, KERHDS_STR24, KERHDS_END11, KERHDS_END12, KERHDS_END13, KERHDS_END14, KERHDS_END21, KERHDS_END22, KERHDS_END23, KERHDS_END24, KERHDS_STR11_DISP, KERHDS_STR12_DISP, KERHDS_STR13_DISP, KERHDS_STR14_DISP, KERHDS_STR21_DISP, KERHDS_STR22_DISP, KERHDS_STR23_DISP, KERHDS_STR24_DISP, KERHDS_END11_DISP, KERHDS_END12_DISP, KERHDS_END13_DISP, KERHDS_END14_DISP, KERHDS_END21_DISP, KERHDS_END22_DISP, KERHDS_END23_DISP, KERHDS_END24_DISP, KERBAS_S1, KERBAS_E1, KERRPM_HMS1, KERRPM_HMS2, KERRPM_HMS3, KERRPM_HMS4, KERRPM_HMS5, KERRPM_HMS6, KERRPM_HMS7, KERRPM_HMS8, KERRPM_HME1, KERRPM_HME2, KERRPM_HME3, KERRPM_HME4, KERRPM_HME5, KERRPM_HME6, KERRPM_HME7, KERRPM_HME8, KERAPP_DT, KERAPP_BY, KERNOTE, HDCAWAL, HDCAKHIR,
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
