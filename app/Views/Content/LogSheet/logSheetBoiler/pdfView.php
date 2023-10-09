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
    font-size: 7pt;
}

.tdTable1 {
    /* border: 1px solid black; */
    border-collapse: collapse;
    border-top: 1px solid black;
    border-right: 1px solid black;
    border-left: 1px solid black;
    /* border-bottom: 1px solid black; */
    text-align: center;
    
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
                <th rowspan="2" class="thTable1"  width="50px"><b>JAM</b></th>
                <th class="thTable1" colspan="2" ><b>PEKERJAAN PERTAMA</b></th>
                <th class="thTable1" colspan="2" ><b>PETUNJUK WAKTU</b></th>
                <th class="thTable1" rowspan="2" field="TMP1" width="50px"><b>TEKANAN STEAM (KG/CM2)</b></th>
                <th class="thTable1" rowspan="2" field="TMP2" width="50px"><b>STEAM FLOW RATE</b></th>
                <th class="thTable1" rowspan="2" field="VCM1" width="50px"><b>MULAI BUKA STEAM KE INST.</b></th>
                <th class="thTable1" colspan="4"><b>BEBAN BLOWER (AMPERE)</b></th>
                <th class="thTable1" rowspan="2" field="VCM2" width="50px"><b>TEMP AIR UMPAN BOILER (<span>&#176;</span>C)</b></th>
                <th class="thTable1" rowspan="2" field="CSTTMP1" width="50px"><b>BLOW DOWN</b></th>
                <th class="thTable1" rowspan="2" field="CSTTMP2" width="50px"><b>SHOOT BLOWING (PER 4 JAM)</b></th>
                <th class="thTable1" rowspan="2" field="CSTTMP3" width="50px"><b>FLOW METER AIR</b></th>
                <th class="thTable1" rowspan="2" field="CSTTMP4" width="50px"><b>INVERTER IDF (%)</b></th>
                <th class="thTable1" rowspan="2" field="CSTTMP5" width="50px"><b>TEMP. AIR DEAERATOR (<span>&#176;</span>C)</b></th>
                <th class="thTable1" rowspan="2" field="CSTTMP6" width="50px"><b>TEMP. GAS BUANG (<span>&#176;</span>C)</b></th>
                <th class="thTable1" rowspan="2" field="CSTOLY1" width="50px"><b>FURNANCE</b></th>
                <th class="thTable1" rowspan="2" field="CSTOLY2" width="50px"><b>SUPER HEATER</b></th>
                <!-- <th class="thTable1" rowspan="3" field="TMP1" width="60,px"align:'center' " ><b>PARAF MANDOR</b></th> -->
                <!-- <th class="thTable1" rowspan="3" field="TMP1" width="160px",align:'center' " ><b>KETERANGAN</b></th> -->
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" field="CSTOLY3" width="50px"><b>KEADAAN AIR PADA GELAS PENDUGA</b></th>
                <th class="thTable1" field="CSTOLY4" width="50px"><b>MULAI PENGAPIAN (FIRE UP)</b></th>
                <th class="thTable1" field="CSTOLY5" width="50px"><b>MULAI START (JAM)</b></th>
                <th class="thTable1" field="CSTOLY6" width="50px"><b>SEWAKTU BERHENTI (<span>&#176;</span>C)</b></th>
                <th class="thTable1" field="SDTTMP1" width="50px"><b>INDUCED DRAFT FAN A</b></th>
                <th class="thTable1" field="SDTTMP2" width="50px"><b>FORCE DRAFT FAN</b></th>
                <th class="thTable1" field="SDTTMP3" width="50px"><b>SECONDARY FAN</b></th>
                <th class="thTable1" field="SDTTMP4" width="50px"><b>FUEL FEEDER FAN</b></th>
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
                <td class="tdTable1" ><?= number_format($data_sql[$i]['TMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['TMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['VCM1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['VCM2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP3'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP4'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP5'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP6'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY3'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY4'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY5'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY6'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SDTTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SDTTMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SDTTMP3'],2,".",",") ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['SDTTMP4']) > 0) { echo 'V'; } ?></td>
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
