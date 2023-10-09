<?php

namespace App\Models\Content\LogSheet;

class logSheetPressStationModel extends \App\Models\BaseModel
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

//         $sql=" SELECT A.TIME_F, A.TIME_DISP, B.LGSID, B.UEP, B.COMP_ID, B.SITE_ID, B.POSTDT, B.PRSID, B.PRSHR, 
//         B.PRSDG_TMP1, B.PRSDG_TMP2, B.PRSDG_TMP3, B.PRSDG_TMP4, B.PRSDG_TMP5, B.PRSDG_TMP6,  (PRSDG_TMP1+PRSDG_TMP2+PRSDG_TMP3+PRSDG_TMP4+PRSDG_TMP5+PRSDG_TMP6)/6 PRSDG_TMP_AVG,
//         B.PRSDG_AMP1, B.PRSDG_AMP2, B.PRSDG_AMP3, B.PRSDG_AMP4, B.PRSDG_AMP5, B.PRSDG_AMP6,
//         B.PRSDG_SRT1, B.PRSDG_SRT2, B.PRSDG_SRT3, B.PRSDG_SRT4, B.PRSDG_SRT5, B.PRSDG_SRT6, 
//         B.PRSDG_END1, B.PRSDG_END2, B.PRSDG_END3, B.PRSDG_END4, B.PRSDG_END5, B.PRSDG_END6, 
//         B.PRSSP_CNP1, B.PRSSP_CNP2, B.PRSSP_CNP3, B.PRSSP_CNP4, B.PRSSP_CNP5, B.PRSSP_CNP6, 
//         B.PRSSP_SRT1, B.PRSSP_SRT2, B.PRSSP_SRT3, B.PRSSP_SRT4, B.PRSSP_SRT5, B.PRSSP_SRT6, 
//         B.PRSSP_END1, B.PRSSP_END2, B.PRSSP_END3, B.PRSSP_END4, B.PRSSP_END5, B.PRSSP_END6, 
//         B.PRSDG_HMS1, B.PRSDG_HMS2, B.PRSDG_HMS3, B.PRSDG_HMS4, B.PRSDG_HMS5, B.PRSDG_HMS6, 
//         B.PRSSP_HMS1, B.PRSSP_HMS2, B.PRSSP_HMS3, B.PRSSP_HMS4, B.PRSSP_HMS5, B.PRSSP_HMS6, 
//         B.PRSCB_HMS1, B.PRSCB_HMS2, B.PRSCB_HMS3, B.PRSCB_HMP1, B.PRSCB_HMP2, B.PRSCB_HMP3
//                 FROM (
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'07' TIME_F,'07' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'08' TIME_F,'08' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'09' TIME_F,'09' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'10' TIME_F,'10' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'11' TIME_F,'11' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'12' TIME_F,'12' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'13' TIME_F,'13' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'14' TIME_F,'14' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'15' TIME_F,'15' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'16' TIME_F,'16' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'17' TIME_F,'17' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'18' TIME_F,'18' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'19' TIME_F,'19' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'20' TIME_F,'20' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'21' TIME_F,'21' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'22' TIME_F,'22' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'23' TIME_F,'23' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'00' TIME_F,'00' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'01' TIME_F,'01' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'02' TIME_F,'02' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'03' TIME_F,'03' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'04' TIME_F,'04' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'05' TIME_F,'05' TIME_DISP FROM DUAL
//                 UNION ALL
//                 SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'06' TIME_F,'06' TIME_DISP FROM DUAL
//                 ) A LEFT JOIN (
//                 SELECT  LGSID, UEP, COMP_ID, SITE_ID, POSTDT, PRSID, PRSHR,  TO_CHAR(POSTDT,'DDMONYY')||LPAD(PRSHR,2,'0') PRSDTHR, 
//         PRSDG_TMP1, PRSDG_TMP2, PRSDG_TMP3, PRSDG_TMP4, PRSDG_TMP5, PRSDG_TMP6, (PRSDG_TMP1+PRSDG_TMP2+PRSDG_TMP3+PRSDG_TMP4+PRSDG_TMP5+PRSDG_TMP6)/6 PRSDG_TMP_AVG,
//         PRSDG_AMP1, PRSDG_AMP2, PRSDG_AMP3, PRSDG_AMP4, PRSDG_AMP5, PRSDG_AMP6,
//         PRSDG_SRT1, PRSDG_SRT2, PRSDG_SRT3, PRSDG_SRT4, PRSDG_SRT5, PRSDG_SRT6, 
//         PRSDG_END1, PRSDG_END2, PRSDG_END3, PRSDG_END4, PRSDG_END5, PRSDG_END6, 
//         PRSSP_CNP1, PRSSP_CNP2, PRSSP_CNP3, PRSSP_CNP4, PRSSP_CNP5, PRSSP_CNP6, 
//         PRSSP_SRT1, PRSSP_SRT2, PRSSP_SRT3, PRSSP_SRT4, PRSSP_SRT5, PRSSP_SRT6, 
//         PRSSP_END1, PRSSP_END2, PRSSP_END3, PRSSP_END4, PRSSP_END5, PRSSP_END6, 
//         PRSDG_HMS1, PRSDG_HMS2, PRSDG_HMS3, PRSDG_HMS4, PRSDG_HMS5, PRSDG_HMS6, 
//         PRSSP_HMS1, PRSSP_HMS2, PRSSP_HMS3, PRSSP_HMS4, PRSSP_HMS5, PRSSP_HMS6, 
//         PRSCB_HMS1, PRSCB_HMS2, PRSCB_HMS3, PRSCB_HMP1, PRSCB_HMP2, PRSCB_HMP3
// FROM POM_LGS_PRS WHERE POSTDT BETWEEN TO_DATE('$tdate','dd/mon/yyyy') AND TO_DATE('$tdate','dd/mon/yyyy')+ 1
//                 ) B
//                 ON A.TIME_F = B.PRSDTHR
//                 ORDER BY A.TIME_F
//         ";

        $sql="SELECT LPAD(PRSHR,2,'0') TIME_DISP , LGSID, SEQ, UEP, COMP_ID, SITE_ID, POSTDT, PRSID, PRSHR, TO_CHAR(POSTDT,'DDMONYY')||LPAD(PRSHR,2,'0') PRSDTHR,
        PRSDG_TMP1, PRSDG_TMP2, PRSDG_TMP3, PRSDG_TMP4, PRSDG_TMP5, PRSDG_TMP6, 
        CASE WHEN (PRSDG_TMP1+PRSDG_TMP2+PRSDG_TMP3+PRSDG_TMP4+PRSDG_TMP5+PRSDG_TMP6) > 0 THEN 
        (PRSDG_TMP1+PRSDG_TMP2+PRSDG_TMP3+PRSDG_TMP4+PRSDG_TMP5+PRSDG_TMP6)/
        (CASE WHEN PRSDG_TMP1 > 0 THEN 1 ELSE 0 END +
        CASE WHEN PRSDG_TMP2 > 0 THEN 1 ELSE 0 END +
        CASE WHEN PRSDG_TMP3 > 0 THEN 1 ELSE 0 END +
        CASE WHEN PRSDG_TMP4 > 0 THEN 1 ELSE 0 END +
        CASE WHEN PRSDG_TMP5 > 0 THEN 1 ELSE 0 END +
        CASE WHEN PRSDG_TMP6 > 0 THEN 1 ELSE 0 END )
        ELSE 0 END PRSDG_TMP_AVG ,
        PRSDG_AMP1, PRSDG_AMP2, PRSDG_AMP3, PRSDG_AMP4, PRSDG_AMP5, PRSDG_AMP6, 
        PRSDG_SRT1, PRSDG_SRT2, PRSDG_SRT3, PRSDG_SRT4, PRSDG_SRT5, PRSDG_SRT6, 
        PRSDG_END1, PRSDG_END2, PRSDG_END3, PRSDG_END4, PRSDG_END5, PRSDG_END6, 
        PRSSP_CNP1, PRSSP_CNP2, PRSSP_CNP3, PRSSP_CNP4, PRSSP_CNP5, PRSSP_CNP6, 
        PRSSP_SRT1, PRSSP_SRT2, PRSSP_SRT3, PRSSP_SRT4, PRSSP_SRT5, PRSSP_SRT6, 
        PRSSP_END1, PRSSP_END2, PRSSP_END3, PRSSP_END4, PRSSP_END5, PRSSP_END6,
        TO_CHAR(PRSSP_SRT1,'HH24:MI') PRSSP_SRT1_DISP, TO_CHAR(PRSSP_SRT2,'HH24:MI') PRSSP_SRT2_DISP, TO_CHAR(PRSSP_SRT3,'HH24:MI') PRSSP_SRT3_DISP, TO_CHAR(PRSSP_SRT4,'HH24:MI') PRSSP_SRT4_DISP, TO_CHAR(PRSSP_SRT5,'HH24:MI') PRSSP_SRT5_DISP, TO_CHAR(PRSSP_SRT6,'HH24:MI') PRSSP_SRT6_DISP, 
        TO_CHAR(PRSSP_END1,'HH24:MI') PRSSP_END1_DISP, TO_CHAR(PRSSP_END2,'HH24:MI') PRSSP_END2_DISP, TO_CHAR(PRSSP_END3,'HH24:MI') PRSSP_END3_DISP, TO_CHAR(PRSSP_END4,'HH24:MI') PRSSP_END4_DISP, TO_CHAR(PRSSP_END5,'HH24:MI') PRSSP_END5_DISP, TO_CHAR(PRSSP_END6,'HH24:MI') PRSSP_END6_DISP,
        PRSDG_HMS1, PRSDG_HMS2, PRSDG_HMS3, PRSDG_HMS4, PRSDG_HMS5, PRSDG_HMS6, 
        PRSSP_HMS1, PRSSP_HMS2, PRSSP_HMS3, PRSSP_HMS4, PRSSP_HMS5, PRSSP_HMS6, 
        PRSCB_HMS1, PRSCB_HMS2, PRSCB_HMS3, PRSCB_HMP1, PRSCB_HMP2, PRSCB_HMP3 
         FROM POM_LGS_PRS WHERE POSTDT = TO_DATE('$tdate','dd/mon/yyyy') ORDER BY SEQ";

        return $sql;
    }

    public function getPress()
    {
        
        $userOrganisasi=$this->session->get('userOrganisasi');
        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];        

        $sql = " SELECT DISTINCT TRIM(PRSID) ID, TRIM(PRSID) DESCRIPTION FROM POM_LGS_PRS ORDER BY 1";
        
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

        // $id = isset($_POST['PRSID']) ? strval($_POST['PRSID']) : '';

        $sqlReport = $this->reportSqlString($TDATE );

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
        

        $sql = "SELECT * FROM (SELECT TIME_DISP , LGSID, SEQ, UEP, COMP_ID, SITE_ID, POSTDT, PRSID, PRSHR, PRSDTHR,
        PRSDG_TMP1, PRSDG_TMP2, PRSDG_TMP3, PRSDG_TMP4, PRSDG_TMP5, PRSDG_TMP6, PRSDG_TMP_AVG,
        PRSDG_AMP1, PRSDG_AMP2, PRSDG_AMP3, PRSDG_AMP4, PRSDG_AMP5, PRSDG_AMP6, 
        PRSDG_SRT1, PRSDG_SRT2, PRSDG_SRT3, PRSDG_SRT4, PRSDG_SRT5, PRSDG_SRT6, 
        PRSDG_END1, PRSDG_END2, PRSDG_END3, PRSDG_END4, PRSDG_END5, PRSDG_END6, 
        PRSSP_CNP1, PRSSP_CNP2, PRSSP_CNP3, PRSSP_CNP4, PRSSP_CNP5, PRSSP_CNP6, 
        PRSSP_SRT1, PRSSP_SRT2, PRSSP_SRT3, PRSSP_SRT4, PRSSP_SRT5, PRSSP_SRT6, 
        PRSSP_END1, PRSSP_END2, PRSSP_END3, PRSSP_END4, PRSSP_END5, PRSSP_END6,
        PRSSP_SRT1_DISP, PRSSP_SRT2_DISP, PRSSP_SRT3_DISP, PRSSP_SRT4_DISP, PRSSP_SRT5_DISP, PRSSP_SRT6_DISP, 
        PRSSP_END1_DISP, PRSSP_END2_DISP, PRSSP_END3_DISP, PRSSP_END4_DISP, PRSSP_END5_DISP, PRSSP_END6_DISP,
         PRSDG_HMS1, PRSDG_HMS2, PRSDG_HMS3, PRSDG_HMS4, PRSDG_HMS5, PRSDG_HMS6, 
         PRSSP_HMS1, PRSSP_HMS2, PRSSP_HMS3, PRSSP_HMS4, PRSSP_HMS5, PRSSP_HMS6, 
         PRSCB_HMS1, PRSCB_HMS2, PRSCB_HMS3, PRSCB_HMP1, PRSCB_HMP2, PRSCB_HMP3,
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

        $STG_ID = isset($_GET['STG_ID']) ? strval($_GET['STG_ID']) : '1';

        $result = array();

        $sqlReport = $this->reportSqlString($TDATE, $STG_ID);
        $sql = "SELECT * FROM ( $sqlReport ) WHERE ROWNUM > 0
        ORDER BY $sort $order ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }

}
