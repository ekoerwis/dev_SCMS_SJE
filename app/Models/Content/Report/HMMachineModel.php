<?php

namespace App\Models\Content\Report;

class HMMachineModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

    public function reportSqlString($paramyear='' ,$parammonth=''){

        // $w_tdate = " ";
        // $w_dt_div = " ";

        // if($tdate != ""){
        //     $w_tdate = " AND POSTDT = TO_DATE('$tdate','dd/mon/yyyy') ";
        // }
        
        // if($dt_div != ""){
        //     $w_dt_div = " AND STGID = '$dt_div' ";
        // }

        // AND THRID  = '$id' 

        // $countMonth=12;
        // if($parammonth != 0){
        //     $countMonth = $parammonth;
        // }

        // for($i=0 ; $i<$countMonth; $i++){
        //     $format_tanggal = $paramyear.'-'.($i+1).'-01';
        //     // Converting string to date 
        //     $date_format_tanggal=strtotime($format_tanggal); 

        //     $last_tanggal =  date("t", $date_format_tanggal );
        //     $query_tanggal='';

        //     for($p=0 ; $i<$last_tanggal; $p++){
        //         if($i+$p==0){
        //             $query_tanggal = "SELECT TO_DATE('".($p+1)."/".($i+1)."/$paramyear','DD/MM/YYYY') TANGGAL_FORM FROM DUAL";
        //         } else {
        //             $query_tanggal .= "UNION ALL SELECT TO_DATE('".($p+1)."/".($i+1)."/$paramyear','DD/MM/YYYY') TANGGAL_FORM FROM DUAL";
        //         }
        //     }
        // }

        $w_month = ' ';

        if($parammonth != 0){
            $w_month = ' AND EXTRACT(MONTH FROM LHPDT) = '.$parammonth;
        }


        $sql="SELECT LHPDT, TO_CHAR(LHPDT,'Month- YYYY') MONTHYEAR, TO_CHAR(LHPDT,'dd') DATENUMBER, TO_CHAR(LHPDT,'mm') MONTHNUMBER, TO_CHAR(LHPDT,'yyyy') YEARNUMBER --, SEQ, HMHR , HMID
        , MAX(WBRLDS11) WBRLDS11, MAX(WBRLDS21) WBRLDS21
        , MAX(LDRCVR11) LDRCVR11, MAX(LDRCVR12) LDRCVR12, MAX(LDRCVR21) LDRCVR21, MAX(LDRBSP11) LDRBSP11
        , MAX(STZSTZ01) STZSTZ01, MAX(STZSTZ02) STZSTZ02, MAX(STZSTZ03) STZSTZ03, MAX(STZSTZ04) STZSTZ04, MAX(STZSTZ05) STZSTZ05, MAX(STZSTZ06) STZSTZ06, MAX(STZSTZ07) STZSTZ07, MAX(STZSTZ08) STZSTZ08
        , MAX(STZFDC01) STZFDC01, MAX(STZSFC01) STZSFC01
        , MAX(STZCPMP1) STZCPMP1, MAX(STZCPMP2) STZCPMP2, MAX(STZCPMP3) STZCPMP3, MAX(STZCPMP4) STZCPMP4
        , MAX(THRTHR01) THRTHR01, MAX(THRTHR02) THRTHR02, MAX(THRTHR03) THRTHR03, MAX(THRTHR04) THRTHR04
        , MAX(THRCRC01) THRCRC01, MAX(THRCRC02) THRCRC02
        , MAX(THRBNC01) THRBNC01, MAX(THRBNC02) THRBNC02
        , MAX(THRBNP01) THRBNP01, MAX(THRBNP02) THRBNP02
        , MAX(THRSTC01) THRSTC01
        , MAX(THRPMP01) THRPMP01, MAX(THRPMP02) THRPMP02, MAX(THRPMP03) THRPMP03, MAX(THRPMP04) THRPMP04
        , MAX(PRSDIG01) PRSDIG01, MAX(PRSDIG02) PRSDIG02, MAX(PRSDIG03) PRSDIG03, MAX(PRSDIG04) PRSDIG04, MAX(PRSDIG05) PRSDIG05, MAX(PRSDIG06) PRSDIG06, MAX(PRSDIG07) PRSDIG07, MAX(PRSDIG08) PRSDIG08
        , MAX(PRSPRS01) PRSPRS01, MAX(PRSPRS02) PRSPRS02, MAX(PRSPRS03) PRSPRS03, MAX(PRSPRS04) PRSPRS04, MAX(PRSPRS05) PRSPRS05, MAX(PRSPRS06) PRSPRS06, MAX(PRSPRS07) PRSPRS07, MAX(PRSPRS08) PRSPRS08
        , MAX(PRSCBC01) PRSCBC01, MAX(PRSCBC02) PRSCBC02, MAX(PRSCBC03) PRSCBC03, MAX(PRSCBC04) PRSCBC04
        , MAX(CLRDCT01) CLRDCT01, MAX(CLRDCT02) CLRDCT02, MAX(CLRDCT03) CLRDCT03, MAX(CLRDCT04) CLRDCT04
        , MAX(CLRDSR01) CLRDSR01, MAX(CLRDSR02) CLRDSR02, MAX(CLRDSR03) CLRDSR03, MAX(CLRDSR04) CLRDSR04
        , MAX(CLRTST01) CLRTST01, MAX(CLRTST02) CLRTST02, MAX(CLRTST03) CLRTST03, MAX(CLRTST04) CLRTST04
        , MAX(CLRSLS01) CLRSLS01, MAX(CLRSLS02) CLRSLS02, MAX(CLRSLS03) CLRSLS03, MAX(CLRSLS04) CLRSLS04
        , MAX(CLRSPR1) CLRSPR1, MAX(CLRSPR2) CLRSPR2, MAX(CLRSPR3) CLRSPR3, MAX(CLRSPR4) CLRSPR4
        , MAX(KERRPM1) KERRPM1, MAX(KERRPM2) KERRPM2, MAX(KERRPM3) KERRPM3, MAX(KERRPM4) KERRPM4, MAX(KERRPM5) KERRPM5, MAX(KERRPM6) KERRPM6, MAX(KERRPM7) KERRPM7, MAX(KERRPM8) KERRPM8
        , MAX(KERHDC11) KERHDC11, MAX(KERHDC12) KERHDC12, MAX(KERHDC13) KERHDC13, MAX(KERHDC14) KERHDC14
        , MAX(KERHDC21) KERHDC21, MAX(KERHDC22) KERHDC22, MAX(KERHDC23) KERHDC23, MAX(KERHDC24) KERHDC24
        , MAX(BOI1IDF1) BOI1IDF1, MAX(BOI1IDF2) BOI1IDF2
        , MAX(BOI2IDF1) BOI2IDF1, MAX(BOI2IDF2) BOI2IDF2
        , MAX(BOI1FFF1) BOI1FFF1, MAX(BOI1FFF2) BOI1FFF2
        , MAX(BOI2FFF1) BOI2FFF1, MAX(BOI2FFF2) BOI2FFF2
        , MAX(BOI1FDF1) BOI1FDF1, MAX(BOI1FDF2) BOI1FDF2
        , MAX(BOI2FDF1) BOI2FDF1, MAX(BOI2FDF2) BOI2FDF2
        , MAX(BOI1FWP1) BOI1FWP1, MAX(BOI1FWP2) BOI1FWP2
        , MAX(BOI2FWP1) BOI2FWP1, MAX(BOI2FWP2) BOI2FWP2
        , MAX(BOI1MVF1) BOI1MVF1, MAX(BOI1MVF2) BOI1MVF2, MAX(BOI1MVF3) BOI1MVF3, MAX(BOI1MVF4) BOI1MVF4
        , MAX(BOI2MVF1) BOI2MVF1, MAX(BOI2MVF2) BOI2MVF2, MAX(BOI2MVF3) BOI2MVF3, MAX(BOI2MVF4) BOI2MVF4
        FROM
        POM_HM_MILL
        WHERE EXTRACT(YEAR FROM LHPDT) = $paramyear $w_month
        GROUP BY LHPDT
        ORDER BY LHPDT";

        
        // $sqlUtama = "SELECT A.TANGGAL_FORM, B.* FROM ($query_tanggal) A LEFT JOIN ($sql) B ON A.TANGGAL_FORM = B.LHPDT";

        return $sql;
        // return $sqlUtama;
    }

    public function getStationID()
    {
        $sqlParam = "SELECT * FROM SCD_MA_PARAM WHERE PRMID='ST0401' AND PRNID='ST04'";
        $execSqlParam = $this->db->query($sqlParam)->getRowArray();
        
        for($i=0 ; $i<$execSqlParam['VALNUM'] ; $i++) {
            $result[$i]['ID'] =  $i+1;
            $result[$i]['DESCRIPTION'] =  "THR ".strval($i+1);
        }
    
        return $result;
    }

    public function getMonth()
    {
        // $sqlParam = "SELECT * FROM SCD_MA_PARAM WHERE PRMID='ST0401' AND PRNID='ST04'";
        // $execSqlParam = $this->db->query($sqlParam)->getRowArray();
        
        // for($i=0 ; $i<$execSqlParam['VALNUM'] ; $i++) {
        for($i=0 ; $i<=12 ; $i++) {

            if($i==0){
                $result[$i]['ID'] =  $i;
                $result[$i]['DESCRIPTION'] =  'ANNUAL' ;
            }else{
                $month_name = date("F", mktime(0, 0, 0, $i, 10)); 
    
                $selected='false';
    
                if(date("m")==$i)
                    $selected='true';
                
                $result[$i]['ID'] =  $i;
                $result[$i]['DESCRIPTION'] =  $month_name ;
                // $result[$i]['selected'] =  $selected ;
            }
        }
    
        return $result;
    }

    public function getYear()
    {
        // $sqlParam = "SELECT * FROM SCD_MA_PARAM WHERE PRMID='ST0401' AND PRNID='ST04'";
        // $execSqlParam = $this->db->query($sqlParam)->getRowArray();
        
        // for($i=0 ; $i<$execSqlParam['VALNUM'] ; $i++) {
        for($i=0 ; $i<=date("Y")-2023 ; $i++) {
            
            $selected='false';

            $param_year=2023+$i;

            if($param_year==date("Y"))
                $selected='true';

            $result[$i]['ID'] =  $param_year;
            $result[$i]['DESCRIPTION'] =  $param_year;
            $result[$i]['selected'] =  $selected ;
        }
    
        return $result;
    }
         
    public function dataList()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'LHPDT';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');


        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        if (empty($_POST['TDATE'])) {
			$TDATE  = date("d/M/Y", strtotime('yesterday'));
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_POST['TDATE']));
		}

        $paramyear = isset($_POST['YEAR']) ? strval($_POST['YEAR']) : '';
        $parammonth = isset($_POST['MONTH']) ? strval($_POST['MONTH']) : '';

        $sqlReport = $this->reportSqlString($paramyear, $parammonth );

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
        

        $sql = "SELECT * FROM (SELECT  LHPDT, MONTHYEAR, DATENUMBER, MONTHNUMBER, YEARNUMBER, WBRLDS11, WBRLDS21, LDRCVR11, LDRCVR12, LDRCVR21, LDRBSP11, STZSTZ01, STZSTZ02, STZSTZ03, STZSTZ04, STZSTZ05, STZSTZ06, STZSTZ07, STZSTZ08, STZFDC01, STZSFC01, STZCPMP1, STZCPMP2, STZCPMP3, STZCPMP4, THRTHR01, THRTHR02, THRTHR03, THRTHR04, THRCRC01, THRCRC02, THRBNC01, THRBNC02, THRBNP01, THRBNP02, THRSTC01, THRPMP01, THRPMP02, THRPMP03, THRPMP04, PRSDIG01, PRSDIG02, PRSDIG03, PRSDIG04, PRSDIG05, PRSDIG06, PRSDIG07, PRSDIG08, PRSPRS01, PRSPRS02, PRSPRS03, PRSPRS04, PRSPRS05, PRSPRS06, PRSPRS07, PRSPRS08, PRSCBC01, PRSCBC02, PRSCBC03, PRSCBC04, CLRDCT01, CLRDCT02, CLRDCT03, CLRDCT04, CLRDSR01, CLRDSR02, CLRDSR03, CLRDSR04, CLRTST01, CLRTST02, CLRTST03, CLRTST04, CLRSLS01, CLRSLS02, CLRSLS03, CLRSLS04, CLRSPR1, CLRSPR2, CLRSPR3, CLRSPR4, KERRPM1, KERRPM2, KERRPM3, KERRPM4, KERRPM5, KERRPM6, KERRPM7, KERRPM8, KERHDC11, KERHDC12, KERHDC13, KERHDC14, KERHDC21, KERHDC22, KERHDC23, KERHDC24, BOI1IDF1, BOI1IDF2, BOI2IDF1, BOI2IDF2, BOI1FFF1, BOI1FFF2, BOI2FFF1, BOI2FFF2, BOI1FDF1, BOI1FDF2, BOI2FDF1, BOI2FDF2, BOI1FWP1, BOI1FWP2, BOI2FWP1, BOI2FWP2, BOI1MVF1, BOI1MVF2, BOI1MVF3, BOI1MVF4, BOI2MVF1, BOI2MVF2, BOI2MVF3, BOI2MVF4, 
        ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result['rows'] = $sql;
    
        return $result;
    }


    public function dataListExcel()
    {   
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'LHPDT';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        

        

        $YEAR = isset($_GET['YEAR']) ? strval($_GET['YEAR']) : '';
        $MONTH = isset($_GET['MONTH']) ? strval($_GET['MONTH']) : '';

        $result = array();

        $sqlReport = $this->reportSqlString($YEAR, $MONTH);
        $sql = "SELECT * FROM ( $sqlReport ) WHERE ROWNUM > 0
        ORDER BY $sort $order ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }

}
