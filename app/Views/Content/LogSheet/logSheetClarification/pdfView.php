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
                <th colspan="2" rowspan="2" class="thTable1"  ><b>TEMP (<span>&#176;</span>C)</b></th>
                <th rowspan="2" class="thTable1"  ><b>VACUUM 1</b></th>
                <th rowspan="2" class="thTable1"  ><b>VACUUM 2</b></th>
                <th colspan="6" class="thTable1"  ><b>CONTINOUS SETTING TANK</b></th>
                <th colspan="2" class="thTable1"  ><b>SLUDGE TANK</b></th>
                <th colspan="3" rowspan="2" class="thTable1"  ><b>DECANTER IN OPERATION</b></th>
                <th rowspan="2" class="thTable1"  ><b>PROCESS HOT WATER</b></th>
                <th colspan="2" class="thTable1"  ><b>DESANDING</b></th>
                <th colspan="2" class="thTable1"  ><b>PURRIFIER</b></th>
                <th colspan="6" class="thTable1"  ><b>DECANTER RUNNING HOURS</b></th>
                <!-- <th rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:60,align:'center' " ><b>PARAF MANDOR</b></th> -->
                <!-- <th rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:160,align:'center' " ><b>KETERANGAN</b></th> -->
            </tr>
            <tr class="trHeadTable1">
                <th colspan="3" class="thTable1"  ><b>TEMP (<span>&#176;</span>C)</b></th>
                <th colspan="3" class="thTable1"  ><b>OIL LAYER (CM)</b></th>
                <th colspan="2" class="thTable1"  ><b>TEMP (<span>&#176;</span>C)</b></th>
                <th colspan="2" class="thTable1"  ><b>RECLAIM OIL TANK</b></th>
                <th colspan="2" class="thTable1"  ><b>RUNNING HOURS</b></th>
                <th colspan="2" class="thTable1"  ><b>DECANTER NO 1</b></th>
                <th colspan="2" class="thTable1"  ><b>DECANTER NO 2</b></th>
                <th colspan="2" class="thTable1"  ><b>DECANTER NO 3</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1"  width="40px"><b>DCO</b></th>
                <th class="thTable1"  width="60px" ><b>PURE OIL TANK</b></th>
                <th class="thTable1"  width="35px" ><b>BAR</b></th>
                <th class="thTable1"  width="35px" ><b>BAR</b></th>
                <th class="thTable1"  width="35px"><b>NO.1</b></th>
                <th class="thTable1"  width="35px"><b>NO.2</b></th>
                <th class="thTable1"  width="35px"><b>NO.3</b></th>
                <th class="thTable1"  width="35px "><b>NO.1</b></th>
                <th class="thTable1"  width="35px "><b>NO.2</b></th>
                <th class="thTable1"  width="35px "><b>NO.3</b></th>
                <th class="thTable1"  width="35px "><b>NO.1</b></th>
                <th class="thTable1"  width="35px "><b>NO.2</b></th>
                <th class="thTable1"  width="35px "><b>NO.1</b></th>
                <th class="thTable1"  width="35px "><b>NO.2</b></th>
                <th class="thTable1"  width="35px "><b>NO.3</b></th>
                <th class="thTable1"  width="35px" ><b>TEMP (<span>&#176;</span>C)</b></th>
                <th class="thTable1"  width="35px "><b>YES</b></th>
                <th class="thTable1"  width="35px "><b>NO</b></th>
                <th class="thTable1"  width="35px "><b>START</b></th>   
                <th class="thTable1"  width="35px "><b>STOP</b></th>
                <th class="thTable1"  width="35px "><b>START</b></th>
                <th class="thTable1"  width="35px "><b>STOP</b></th>
                <th class="thTable1"  width="35px "><b>START</b></th>
                <th class="thTable1"  width="35px "><b>STOP</b></th>
                <th class="thTable1"  width="35px "><b>START</b></th>
                <th class="thTable1"  width="35px "><b>STOP</b></th>
            </tr>
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
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['SDTTMP5']) < 1) { echo 'X'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['SDTTMP6']) > 0) { echo 'V'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['SSPTMP1']) < 1) { echo 'X'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['SSPTMP2']) > 0) { echo 'V'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['SSPTMP3']) < 1) { echo 'X'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['SSPTMP4']) > 0) { echo 'V'; } ?></td>
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
