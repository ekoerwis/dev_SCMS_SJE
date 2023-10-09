<?php

namespace App\Models\Content\LiveMonitoring;

class SystemMonitoringModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

         
    public function getURLIFrame()
    {   
        $sql = "SELECT CRTTS, CRTBY, UPDTS, UPDBY, TRM, INACT, INACTBY, ORGID, ORG_CODE_PR, ORG_CODE, PRMID, PRNID, PRNDESC, VALNUM, VALSTR, SEQ FROM SCD_MA_PARAM WHERE PRNID = 'PRTL' AND PRMID = 'USYS' ";
        
        $dataSql = $this->db->query($sql)->getRowArray();

        $result = $dataSql;
    
        return $result;
    }

    // batas pakai

}
