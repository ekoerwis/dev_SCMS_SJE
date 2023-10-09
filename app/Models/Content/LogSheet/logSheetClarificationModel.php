<?php

namespace App\Models\Content\LogSheet;

class logSheetClarificationModel extends \App\Models\BaseModel
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

        $sql=" SELECT A.TIME_F, A.TIME_DISP, B.LGSID, B.UEP, B.COMP_ID, B.SITE_ID, B.POSTDT, B.CLRID, B.CLRHR, B.CLRDTHR,
        B.TMP1, B.TMP2, B.TMP3, 
       B.TMP4, B.TMP5, B.TMP6, B.VCM1, B.VCM2, B.VCM3, B.VCM4, B.CSTTMP1, B.CSTTMP2, B.CSTTMP3, 
       B.CSTTMP4, B.CSTTMP5, B.CSTTMP6, B.CSTOLY1, B.CSTOLY2, B.CSTOLY3, B.CSTOLY4, B.CSTOLY5, 
       B.CSTOLY6, B.SDTTMP1, B.SDTTMP2, B.SDTTMP3, B.SDTTMP4, B.SDTTMP5, B.SDTTMP6, B.SSPTMP1, 
       B.SSPTMP2, B.SSPTMP3, B.SSPTMP4, B.SSPTMP5, B.SSPTMP6, B.DECACT1, B.DECACT2, B.DECACT3, 
       B.DECTMP1, B.DECTMP2, B.DECTMP3, B.HWTTMP1, B.HWTTMP2, B.HWTTMP3, B.SPHMS1, B.SPHMS2, 
       B.SPHMS3, B.SPHME1, B.SPHME2, B.SPHME3, B.DCHMS1, B.DCHMS2, B.DCHMS3, B.DCHME1, 
       B.DCHME2, B.DCHME3, B.VERMD1, B.USRMD1
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
                       SELECT LGSID, UEP, COMP_ID, SITE_ID, POSTDT, CLRID, CLRHR, TO_CHAR(POSTDT,'DDMONYY')||LPAD(CLRHR,2,'0') CLRDTHR,
                       TMP1, TMP2, TMP3, 
       TMP4, TMP5, TMP6, VCM1, VCM2, VCM3, VCM4, CSTTMP1, CSTTMP2, CSTTMP3, 
       CSTTMP4, CSTTMP5, CSTTMP6, CSTOLY1, CSTOLY2, CSTOLY3, CSTOLY4, CSTOLY5, 
       CSTOLY6, SDTTMP1, SDTTMP2, SDTTMP3, SDTTMP4, SDTTMP5, SDTTMP6, SSPTMP1, 
       SSPTMP2, SSPTMP3, SSPTMP4, SSPTMP5, SSPTMP6, DECACT1, DECACT2, DECACT3, 
       DECTMP1, DECTMP2, DECTMP3, HWTTMP1, HWTTMP2, HWTTMP3, SPHMS1, SPHMS2, 
       SPHMS3, SPHME1, SPHME2, SPHME3, DCHMS1, DCHMS2, DCHMS3, DCHME1, 
       DCHME2, DCHME3, VERMD1, USRMD1 FROM POM_LGS_CLR B WHERE CLRID = '$id'
       AND POSTDT BETWEEN TO_DATE('$tdate','dd/mon/yyyy') AND TO_DATE('$tdate','dd/mon/yyyy')+ 1
                       ) B
                       ON A.TIME_F = B.CLRDTHR
                       ORDER BY A.TIME_F
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
        

        $sql = "SELECT * FROM (SELECT TIME_F, TIME_DISP, LGSID, UEP, COMP_ID, SITE_ID, POSTDT, CLRID, CLRHR, CLRDTHR,
        TMP1, TMP2, TMP3, 
       TMP4, TMP5, TMP6, VCM1, VCM2, VCM3, VCM4, CSTTMP1, CSTTMP2, CSTTMP3, 
       CSTTMP4, CSTTMP5, CSTTMP6, CSTOLY1, CSTOLY2, CSTOLY3, CSTOLY4, CSTOLY5, 
       CSTOLY6, SDTTMP1, SDTTMP2, SDTTMP3, SDTTMP4, SDTTMP5, SDTTMP6, SSPTMP1, 
       SSPTMP2, SSPTMP3, SSPTMP4, SSPTMP5, SSPTMP6, DECACT1, DECACT2, DECACT3, 
       DECTMP1, DECTMP2, DECTMP3, HWTTMP1, HWTTMP2, HWTTMP3, SPHMS1, SPHMS2, 
       SPHMS3, SPHME1, SPHME2, SPHME3, DCHMS1, DCHMS2, DCHMS3, DCHME1, 
       DCHME2, DCHME3, VERMD1, USRMD1,
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
