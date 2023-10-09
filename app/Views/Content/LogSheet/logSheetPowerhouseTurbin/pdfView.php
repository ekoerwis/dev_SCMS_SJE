<!-- ga tw kenapa xls ga mau baca css di header 18Apr22 -->
<style>
.btnSearch:hover {
  background-color: #4191e1;
}

.btnResetSearch:hover {
  background-color: #e66f7b  ;
}

.btnDownloadXls:hover {
  background-color: #34ce57;
}

.reportContent {
    font-family: serif; 
    font-size: 8pt; 
    background-color: #FFFFFF;
}

.table1{
    border-collapse: collapse;
    border: 1px solid black;
    font-size: 8pt; 
}

.trHeadTable1 {
    border: 1px solid black;
    border-collapse: collapse;
}

.thTable1 {
    border: 1px solid black;
    border-collapse: collapse;
    text-align: center;
    font-size: 6pt;
}

.tdTable1 {
    /* border: 1px solid black; */
    border-collapse: collapse;
    border-top: 1px solid black;
    border-right: 1px solid black;
    border-left: 1px solid black;
    /* border-bottom: 1px solid black; */
    text-align: center;
    font-size: 7pt;
    
}

.tdTable1LikeRowSpan {
    /* border: 1px solid black; */
    border-collapse: collapse;
    border-right: 1px solid black;
    border-left: 1px solid black;
    /* border-top: 1px solid black; */
    /* border-bottom: 1px solid black; */
}

.tdTable1Aggrt{
    /* border-bottom: 1px solid black; */
    border-collapse: collapse;
    border-top: 1px solid black;
    border-right: 1px solid black;
    border-left: 1px solid black;
    text-align: right;
    background-color: #DEDEDE;
}

.thTable1Aggrt{
    border-collapse: collapse;
    border-top: 1px solid black;
    /* border-bottom: 1px solid black; */
    border-right: 1px solid black;
    border-left: 1px solid black;
    text-align: center;
    background-color: #DEDEDE;
}

</style>

<div id="containerReport" class="reportContent">
    <table id="dataTable" class="table1">
        <thead>
            <tr class="trHeadTable1">
                <th rowspan="3" class="thTable1"  width="35px"><b>JAM</b></th>
                <th class="thTable1" rowspan="3" field="TMP1" width="40px"><b>NOZZLE PREASURE</b></th>
                <th class="thTable1" rowspan="3" field="TMP2" width="40px"><b>INLET PREASURE</b></th>
                <th class="thTable1" rowspan="3" field="VCM1" width="40px"><b>EXHAUST PREASURE</b></th>
                <th class="thTable1" rowspan="3" field="VCM2" width="40px"><b>GEAR BOX PREASURE</b></th>
                <th class="thTable1" rowspan="3" field="CSTTMP1" width="40px"><b>TURBIN OIL PREASURE</b></th>
                <th class="thTable1" rowspan="3" field="CSTTMP2" width="40px"><b>TEMP STEAM</b></th>
                <th class="thTable1" rowspan="3" field="CSTTMP3" width="40px"><b>TEMP OIL</b></th>
                <th class="thTable1" colspan="4"><b>BEARING OIL TEMP (<span>&#176;</span>C)</b></th>
                <th class="thTable1" rowspan="3" field="CSTTMP4" width="40px"><b>GOVERNOR LOAD LIMIT</b></th>
                <th class="thTable1" rowspan="3" field="CSTTMP5" width="40px"><b>RPM</b></th>
                <th class="thTable1" rowspan="3" field="CSTTMP6" width="40px"><b>HZ</b></th>
                <th class="thTable1" rowspan="3" field="CSTOLY1" width="40px"><b>VOLT</b></th>
                <th class="thTable1" rowspan="3" field="CSTOLY2" width="40px"><b>COST</b></th>
                <th class="thTable1" colspan="3"><b>AMPERE</b></th>
                <th class="thTable1" rowspan="3" field="CSTOLY3" width="40px"><b>KW</b></th>
                <th class="thTable1" rowspan="3" field="CSTOLY4" width="40px"><b>HM</b></th>
                <th class="thTable1" rowspan="3" field="CSTOLY5" width="40px"><b>KWH</b></th>
                <!-- <th class="thTable1" rowspan="3" field="TMP1" width="40px",align:'center' " ><b>PARAF MANDOR</b></th> -->
                <!-- <th class="thTable1" rowspan="3" field="TMP1" width="16px"0,align:'center' " ><b>KETERANGAN</b></th> -->
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" colspan="2"><b>PINION</b></th>
                <th class="thTable1" colspan="2"><b>BULLGEAR</b></th>
                <th class="thTable1" rowspan="2" field="CSTOLY6" width="40px"><b>R</b></th>
                <th class="thTable1" rowspan="2" field="SDTTMP1" width="40px"><b>S</b></th>
                <th class="thTable1" rowspan="2" field="SDTTMP2" width="40px"><b>T</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" field="SDTTMP3" width="40px"><b>1</b></th>
                <th class="thTable1" field="SDTTMP4" width="40px"><b>2</b></th>
                <th class="thTable1" field="SDTTMP5" width="40px"><b>3</b></th>
                <th class="thTable1" field="SDTTMP6" width="40px"><b>4</b></th>
            </tr>

        </thead>
        <tbody>
            <?php
                if(isset($data_sql)) {
                $jmlData = count($data_sql);
            ?>
            <?php
                $numData=0;
                for($i=0;$i < $jmlData;$i++){
                    $numData++;
            ?>
            <tr>
                <td class="tdTable1" ><?= $data_sql[$i]['TIME_DISP'] ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSNZL_PRS'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSINL_PRS'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSEXH_PRS'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSGRB_PRS'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSTBO_PRS'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSSTM_TMP'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSOIL_TMP'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSBRO_PIN_TMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSBRO_PIN_TMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSBRO_BUL_TMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSBRO_BUL_TMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWSGVN_LLM'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWS_RPM'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWS_HZ'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWS_V'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWS_COST'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWS_I_R'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWS_I_S'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWS_I_T'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWS_KW'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWS_HM'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PWS_KWH'],2,".",",") ?></td>
            </tr>
<?php
            
        }
?>
        </tbody>
    </table>
<?php
    }
?>
</div>
