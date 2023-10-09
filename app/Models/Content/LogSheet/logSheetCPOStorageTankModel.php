<?php

namespace App\Models\Content\LogSheet;

class logSheetCPOStorageTankModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

    public function reportSqlString($tdate='' ,$dt_div=''){

        $w_tdate = " ";
        $w_dt_div = " ";

        if($tdate != ""){
            $w_tdate = " AND POSTDT = TO_DATE('$tdate','dd/mon/yyyy') ";
        }
        
        if($dt_div != ""){
            $w_dt_div = " AND STGID = '$dt_div' ";
        }

        $sql=" SELECT A.TIME_F, A.TIME_DISP, B.SUMSTGID, B.SUMSTGID_UEP, B.SUMSTGID_UEP_TIME, B.SUMSTGID_UEP_TIME_H, 
        B.SUMSTGID_UEP_TIME_MIN, B.UEP, B.COMP_ID, B.SITE_ID, B.POSTDT, B.STGID, B.STGLV, B.STGLVMM, B.STGLVCM, 
        B.STGTMPINT1, B.STGTMPINT2, B.STGTMPINT3, B.STGTMPINT4, B.STGTMPINT5, B.STGTMPINTAVG, B.STGTMPEXT1, 
        B.STGTMPEXT2, B.STGTMPEXT3, B.STGTMPEXTF, B.STGTMPEXTAVG, B.BJ, B.CORECTIONF, B.WEIGHT, B.STGACC, B.STGNOTE
        FROM (
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'07' TIME_F,'07' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'08' TIME_F,'08' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'09' TIME_F,'09' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'10' TIME_F,'10' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'11' TIME_F,'11' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'12' TIME_F,'12' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'13' TIME_F,'13' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'14' TIME_F,'14' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'15' TIME_F,'15' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'16' TIME_F,'16' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'17' TIME_F,'17' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'18' TIME_F,'18' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'19' TIME_F,'19' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'20' TIME_F,'20' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'21' TIME_F,'21' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'22' TIME_F,'22' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'23' TIME_F,'23' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'00' TIME_F,'00' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'01' TIME_F,'01' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'02' TIME_F,'02' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'03' TIME_F,'03' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'04' TIME_F,'04' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'05' TIME_F,'05' TIME_DISP FROM DUAL
        UNION ALL
        SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'06' TIME_F,'06' TIME_DISP FROM DUAL
        ) A LEFT JOIN (
        SELECT SUMSTGID, SUMSTGID_UEP, SUMSTGID_UEP_TIME, SUMSTGID_UEP_TIME_H, 
        SUMSTGID_UEP_TIME_MIN, UEP, COMP_ID, SITE_ID, POSTDT, STGID, STGLV, STGLVMM, 
        STGLVCM, STGTMPINT1, STGTMPINT2, STGTMPINT3, STGTMPINT4, STGTMPINT5, STGTMPINTAVG, 
        STGTMPEXT1, STGTMPEXT2, STGTMPEXT3, STGTMPEXTF, STGTMPEXTAVG, BJ, CORECTIONF, WEIGHT, STGACC, STGNOTE
        FROM (
        SELECT SUMSTGID,UEP SUMSTGID_UEP
        , TO_CHAR(FS_CONV_UTCUEP2WIB(UEP),'DD/MON/YYYY HH24:MI:SS')  SUMSTGID_UEP_TIME
        , TO_CHAR(FS_CONV_UTCUEP2WIB(UEP),'DDMONYYHH24')  SUMSTGID_UEP_TIME_H
        , MIN(UEP) OVER (PARTITION BY TO_CHAR(FS_CONV_UTCUEP2WIB(UEP),'DDMONYYHH24')) SUMSTGID_UEP_TIME_MIN
        ,UEP, COMP_ID, SITE_ID, POSTDT, STGID, STGLV, STGLVMM, STGLVCM, STGTMPINT1, 
        STGTMPINT2, STGTMPINT3, STGTMPINT4, STGTMPINT5, STGTMPINTAVG, STGTMPEXT1, STGTMPEXT2, 
        STGTMPEXT3, STGTMPEXTF, STGTMPEXTAVG, BJ, CORECTIONF, WEIGHT, STGACC, STGNOTE
        FROM POM_LGS_STG_CPO WHERE  ROWNUM > 0 AND POSTDT = TO_DATE('$tdate','dd/mon/yyyy') AND STGID = '$dt_div'
        ) WHERE SUMSTGID_UEP_TIME_MIN = SUMSTGID_UEP
        ) B
        ON A.TIME_F = B.SUMSTGID_UEP_TIME_H
        ORDER BY A.TIME_F
        ";

        return $sql;
    }

    public function getStg()
    {
        
        $userOrganisasi=$this->session->get('userOrganisasi');
        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];        

        $sql = " SELECT DISTINCT TRIM(STGID) ID, TRIM(STGID) DESCRIPTION FROM POM_LGS_STG_CPO ORDER BY 1";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }
         
    public function dataList()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'TIME_F';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');


        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        if (empty($_POST['TDATE'])) {
			$TDATE  = date("d/M/Y", strtotime('yesterday'));
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_POST['TDATE']));
		}

        $STG_ID = isset($_POST['STG_ID']) ? strval($_POST['STG_ID']) : '';

        $sqlReport = $this->reportSqlString($TDATE, $STG_ID );

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
        

        $sql = "SELECT * FROM (SELECT TIME_F, TIME_DISP, SUMSTGID, SUMSTGID_UEP, SUMSTGID_UEP_TIME, SUMSTGID_UEP_TIME_H, SUMSTGID_UEP_TIME_MIN, UEP, COMP_ID, SITE_ID, POSTDT, STGID, STGLV, STGLVMM, STGLVCM, STGTMPINT1, STGTMPINT2, STGTMPINT3, STGTMPINT4, STGTMPINT5, STGTMPINTAVG, STGTMPEXT1, STGTMPEXT2, STGTMPEXT3, STGTMPEXTF, STGTMPEXTAVG, BJ, CORECTIONF, WEIGHT, STGACC, STGNOTE,
        ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result['rows'] = $sql;
    
        return $result;
    }


    public function dataListExcel()
    {   
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'TIME_F';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        

        if (empty($_GET['TDATE'])) {
			$TDATE  = '';
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_GET['TDATE']));
		}

        $STG_ID = isset($_GET['STG_ID']) ? strval($_GET['STG_ID']) : '';

        $result = array();

        $sqlReport = $this->reportSqlString($TDATE, $STG_ID);
        $sql = "SELECT * FROM ( $sqlReport ) WHERE ROWNUM > 0
        ORDER BY $sort $order ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }

}
