<?php

namespace App\Models\Content\Report;

class historicalPressureLineChartModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

    
    public function dataGraph()
    {   
        $BYTIME  =  isset($_POST['BYTIME']) ? intval($_POST['BYTIME']):1;
        $TDATE  =  isset($_POST['TDATE']) ? date("d/M/Y", strtotime($_POST['TDATE'])):'';
        $DIVID  =  isset($_POST['DIVID']) ? strval($_POST['DIVID']):'0';
        $iNumbers  =  isset($_POST['NUMBERS']) ? strval($_POST['NUMBERS']):'0';

        $div_id = intval($DIVID);
        // $dt_add = 'PSPV'.$div_id.'1';

        $sql = "SELECT A.*, B.MIN MIN_BAR, B.MAX MAX_BAR, C.MIN MIN_AMP, C.MAX MAX_AMP, D.MIN MIN_TEMP, D.MAX MAX_TEMP from 
        ( SELECT PERIODE, TM, ROUND_TM, LAG_TM, SUM(TEMP) TEMP, SUM(BAR) BAR,  SUM(AMP) AMP
                FROM
                (SELECT  PERIODE,
                    TM,
                    ROUND_TM,
                    LAG_TM,
                        TEMP,
                        0  BAR,
                        0 AMP
                FROM (
                SELECT POSTDT PERIODE,
                    DT_VAL TEMP,
                    TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24:mi') TM,
                    TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME) ROUND_TM, 
                    LAG(TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME), 1, 0) OVER (ORDER BY DT_UEP) AS LAG_TM
                FROM SCD_TRHISTORY
                WHERE DT_DIV = '$div_id' AND POSTDT = '$TDATE' AND DT_ADD = 'DIG".$iNumbers."TP'
                ORDER BY DT_UEP)
                WHERE ROUND_TM <> LAG_TM
                UNION ALL
                SELECT  PERIODE,
                    TM,
                    ROUND_TM,
                    LAG_TM,
                        0 TEMP,
                        BAR,
                        0 AMP
                FROM (
                SELECT POSTDT PERIODE,
                    DT_VAL BAR,
                    TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24:mi') TM,
                    TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME) ROUND_TM, 
                    LAG(TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME), 1, 0) OVER (ORDER BY DT_UEP) AS LAG_TM
                FROM SCD_TRHISTORY
                WHERE DT_DIV = '$div_id' AND POSTDT = '$TDATE' AND DT_ADD = 'SCP".$iNumbers."PS'
                ORDER BY DT_UEP)
                WHERE ROUND_TM <> LAG_TM
                UNION ALL
                SELECT  PERIODE,
                    TM,
                    ROUND_TM,
                    LAG_TM,
                        0 TEMP,
                        0  BAR,
                        AMP
                FROM (
                SELECT POSTDT PERIODE,
                    DT_VAL AMP,
                    TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24:mi') TM,
                    TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME) ROUND_TM, 
                    LAG(TO_CHAR (FS_CONV_UTCUEP2WIB (DT_UEP), 'hh24')||':'||CEIL((TO_NUMBER(TO_CHAR(FS_CONV_UTCUEP2WIB (DT_UEP), 'mi'))+1)/$BYTIME), 1, 0) OVER (ORDER BY DT_UEP) AS LAG_TM
                FROM SCD_TRHISTORY
                WHERE DT_DIV = '$div_id' AND POSTDT = '$TDATE' AND DT_ADD = 'DIG".$iNumbers."AM'
                ORDER BY DT_UEP)
                WHERE ROUND_TM <> LAG_TM
                )
                GROUP BY PERIODE, TM, ROUND_TM, LAG_TM
                ORDER BY PERIODE, TM) A,
                (select * from parametervalue where parametercode='SCADA' and parametervaluecode = 'PRPRES01') B,
                (select * from parametervalue where parametercode='SCADA' and parametervaluecode = 'PRAMPR02') C,
                (select * from parametervalue where parametercode='SCADA' and parametervaluecode = 'PRTEMP01') D
";
        
        $result = $this->db->query($sql)->getResultArray();

        // $result = $sql;
    
        return $result;
    }

    // batas pakai


}
