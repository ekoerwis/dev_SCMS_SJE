<?php

namespace App\Models\Content\LogSheet;

class logSheetThresherModel extends \App\Models\BaseModel
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

        $sql="SELECT LPAD(THRHR,2,'0') TIME_DISP,LGSID, SEQ, UEP, COMP_ID, SITE_ID, POSTDT, THRID, THRHR, THRAPP_DT, THRAPP_BY, THRNOTE, 
        THRSMP, THRUSB, THRPER, 
        THREBP_V1, THREBP_A1, 
        THREBP_V2, THREBP_A2, 
        THREBP_V3, THREBP_A3, 
        THREBP_V4, THREBP_A4, 
        THREBP_GB1, THREBP_GB2, THREBP_GB3, THREBP_GB4, 
        THRPMP1, THRPMP2, THRPMP3, THRPMP4, 
        THREBP_HMS1, THREBP_HMS2, THREBP_HMS3, THREBP_HMS4, 
        THREBP_HME1, THREBP_HME2, THREBP_HME3, THREBP_HME4 
        FROM POM_LGS_THR WHERE POSTDT = TO_DATE('$tdate','dd/mon/yyyy') AND THRID = '$id'  ORDER BY SEQ
        ";

        return $sql;
    }

    public function getStationID()
    {
        
        // $userOrganisasi=$this->session->get('userOrganisasi');
        // $sess_comp=$userOrganisasi['COMPANYID'];
        // $sess_site= $userOrganisasi['COMPANYSITEID'];        

        $sql = " SELECT DISTINCT TRIM(THRID) ID, TRIM(THRID) DESCRIPTION FROM POM_LGS_THR ORDER BY 1";
        
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
        

        $sql = "SELECT * FROM (SELECT TIME_DISP, LGSID, SEQ, UEP, COMP_ID, SITE_ID, POSTDT, THRID, THRHR, THRAPP_DT, THRAPP_BY, THRNOTE, 
        THRSMP, THRUSB, THRPER, 
        THREBP_V1, THREBP_A1, 
        THREBP_V2, THREBP_A2, 
        THREBP_V3, THREBP_A3, 
        THREBP_V4, THREBP_A4, 
        THREBP_GB1, THREBP_GB2, THREBP_GB3, THREBP_GB4, 
        THRPMP1, THRPMP2, THRPMP3, THRPMP4, 
        THREBP_HMS1, THREBP_HMS2, THREBP_HMS3, THREBP_HMS4, 
        THREBP_HME1, THREBP_HME2, THREBP_HME3, THREBP_HME4,
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
