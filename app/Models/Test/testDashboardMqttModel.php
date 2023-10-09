<?php

namespace App\Models\Test;

class testDashboardMqttModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

    
    public function dataGraph()
    {   
        $BYTIME  =  isset($_POST['BYTIME']) ? intval($_POST['BYTIME']):1;
        $TDATE  =  isset($_POST['TDATE']) ? date("d/M/Y", strtotime($_POST['TDATE'])):'';
        $DIVID  =  isset($_POST['DIVID']) ? strval($_POST['DIVID']):'0';

        $sql = "SELECT  PERIODE,
        MBARG,
        BAR,
       TM,
       ROUND_TM,
       LAG_TM
FROM (
SELECT POSTDT PERIODE,
       DT_VAL MBARG,
       ROUND (DT_VAL / 1000, 2) BAR,
       TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24:mi') TM,
       TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME) ROUND_TM, 
       LAG(TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME), 1, 0) OVER (ORDER BY DT_UEP) AS LAG_TM
  FROM SCD_TRHISTORY
 WHERE DT_DIV = '$DIVID' AND POSTDT = '$TDATE' AND DT_ADD = 'PVPS1'
ORDER BY DT_UEP)
WHERE ROUND_TM <> LAG_TM";
        
        $result = $this->db->query($sql)->getResultArray();

        // $result = $sql;
    
        return $result;
    }

    public function getDataBpv()
    {   
        $BYTIME  =  isset($_POST['BYTIME']) ? intval($_POST['BYTIME']):1;
        $TDATE  =  isset($_POST['TDATE']) ? date("d/M/Y", strtotime($_POST['TDATE'])):'';
        // $DIVID  =  isset($_POST['DIVID']) ? strval($_POST['DIVID']):'191';
        $DIVID  =  '191';

        $sql = "SELECT  PERIODE,
        MBARG,
        BAR,
       TM,
       ROUND_TM,
       LAG_TM
FROM (
SELECT POSTDT PERIODE,
       DT_VAL MBARG,
       ROUND (DT_VAL / 1000, 2) BAR,
       TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24:mi') TM,
       TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME) ROUND_TM, 
       LAG(TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME), 1, 0) OVER (ORDER BY DT_UEP) AS LAG_TM
  FROM SCD_TRHISTORY
 WHERE DT_DIV = '$DIVID' AND POSTDT = '$TDATE' AND DT_ADD = 'BPV1' AND DT_TYPE='PVPS'
ORDER BY DT_UEP)
WHERE ROUND_TM <> LAG_TM";
        
        $result = $this->db->query($sql)->getResultArray();

        // $result = $sql;
    
        return $result;
    }

    public function getDataTurbin()
    {   
        $BYTIME  =  isset($_POST['BYTIME']) ? intval($_POST['BYTIME']):1;
        $TDATE  =  isset($_POST['TDATE']) ? date("d/M/Y", strtotime($_POST['TDATE'])):'';
        // $DIVID  =  isset($_POST['DIVID']) ? strval($_POST['DIVID']):'191';
        $DIVID  =  '191';

        $sql = "SELECT  PERIODE,
        MBARG,
        BAR,
       TM,
       ROUND_TM,
       LAG_TM
FROM (
SELECT POSTDT PERIODE,
       DT_VAL MBARG,
       ROUND (DT_VAL / 1000, 2) BAR,
       TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24:mi') TM,
       TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME) ROUND_TM, 
       LAG(TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME), 1, 0) OVER (ORDER BY DT_UEP) AS LAG_TM
  FROM SCD_TRHISTORY
 WHERE DT_DIV = '$DIVID' AND POSTDT = '$TDATE' AND DT_ADD = 'TBN1' AND DT_TYPE='PVPS'
ORDER BY DT_UEP)
WHERE ROUND_TM <> LAG_TM";
        
        $result = $this->db->query($sql)->getResultArray();

        // $result = $sql;
    
        return $result;
    }

    // batas pakai


}
