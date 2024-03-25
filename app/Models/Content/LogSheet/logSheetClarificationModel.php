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

        $sql=" SELECT LPAD(CLRHR,2,'0') TIME_DISP ,LGSID, SEQ, UEP, COMP_ID, SITE_ID, POSTDT, CLRID, CLRHR, 
        DOC, OITTMP1, OITTMP2, 
        VCM1, VCM2, VCM3, VCM4, 
        VCMCH1, VCMCH2, VCMCH3, VCMCH4, ROTTMP1, 
        CSTTMP1, CSTTMP2, CSTTMP3, CSTTMP4, CSTTMP5, CSTTMP6, 
        CSTOLY1, CSTOLY2, CSTOLY3, CSTOLY4, CSTOLY5, CSTOLY6, 
        SDTTMP1, SDTTMP2, SDTTMP3, SDTTMP4, SDTTMP5, SDTTMP6, 
        SGTTMP1, SGTTMP2, 
        SSPTMP1, SSPTMP2, SSPTMP3, SSPTMP4, SSPTMP5, SSPTMP6, 
        DECACT1, DECACT2, DECACT3, DECACT4, 
        DECTMP1, DECTMP2, DECTMP3, DECTMP4, 
        HWTTMP1, HWTTMP2, HWTTMP3, 
        BTDTMP1, 
        BTSTMP1, 
        SPHMS1, SPHMS2, SPHMS3, 
        SPHME1, SPHME2, SPHME3, 
        DCHMS1, DCHMS2, DCHMS3, 
        DCHME1, DCHME2, DCHME3, 
        OSS1, VERMD1, USRMD1, COTTMP1 FROM POM_LGS_CLR WHERE POSTDT =  TO_DATE('$tdate','dd/mon/yyyy') ORDER BY SEQ
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
        

        $sql = "SELECT * FROM (SELECT TIME_DISP ,LGSID, SEQ, UEP, COMP_ID, SITE_ID, POSTDT, CLRID, CLRHR, 
        DOC, OITTMP1, OITTMP2, 
        VCM1, VCM2, VCM3, VCM4, 
        VCMCH1, VCMCH2, VCMCH3, VCMCH4, ROTTMP1, 
        CSTTMP1, CSTTMP2, CSTTMP3, CSTTMP4, CSTTMP5, CSTTMP6, 
        CSTOLY1, CSTOLY2, CSTOLY3, CSTOLY4, CSTOLY5, CSTOLY6, 
        SDTTMP1, SDTTMP2, SDTTMP3, SDTTMP4, SDTTMP5, SDTTMP6, 
        SGTTMP1, SGTTMP2, 
        SSPTMP1, SSPTMP2, SSPTMP3, SSPTMP4, SSPTMP5, SSPTMP6, 
        DECACT1, DECACT2, DECACT3, DECACT4, 
        DECTMP1, DECTMP2, DECTMP3, DECTMP4, 
        HWTTMP1, HWTTMP2, HWTTMP3, 
        BTDTMP1, 
        BTSTMP1, 
        SPHMS1, SPHMS2, SPHMS3, 
        SPHME1, SPHME2, SPHME3, 
        DCHMS1, DCHMS2, DCHMS3, 
        DCHME1, DCHME2, DCHME3, 
        OSS1, VERMD1, USRMD1, COTTMP1, 
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
