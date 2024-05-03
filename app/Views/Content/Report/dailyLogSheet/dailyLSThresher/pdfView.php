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
        <!-- class="trHeadTable1" -->
        <!-- class="thTable1" -->
            <tr class="trHeadTable1">
                <th rowspan="4" class="thTable1"  width="60px"><b>TANGGAL</b></th>
                <th rowspan="4" class="thTable1"  width="40px"><b>JAM</b></th>
                <th class="thTable1" colspan="3"><b>THRESHER</b></th>
                <th class="thTable1" colspan="19"><b>EMPTY BUNCH PRESS</b></th>
                <!-- <th class="thTable1" rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:60,align:'center' " ><b>PARAF MANDOR</b></th> -->
                <!-- <th class="thTable1" rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:160,align:'center' " ><b>KETERANGAN</b></th> -->
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" rowspan="3" width="45px"><b>SAMPLE</b></th>
                <th class="thTable1" rowspan="3" width="45px"><b>USB</b></th>
                <th class="thTable1" rowspan="3" width="45px"><b>%</b></th>
                <th class="thTable1" colspan="2" ><b>EBP I</b></th>
                <th class="thTable1" colspan="2" ><b>EBP II</b></th>
                <th class="thTable1" rowspan="2" ><b>BAK LIQUOR</b></th>
                <th class="thTable1" colspan="6" ><b>KONDISI GEAR BOX</b></th>
                <th class="thTable1" colspan="2" ><b>POMPA</b></th>
                <th class="thTable1" colspan="6" ><b>HM</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" rowspan="2" width="45px"><b>VOLT</b></th>
                <th class="thTable1" rowspan="2" width="45px"><b>AMPERE</b></th>
                <th class="thTable1" rowspan="2" width="45px"><b>VOLT</b></th>
                <th class="thTable1" rowspan="2" width="45px"><b>AMPERE</b></th>
                <th class="thTable1" colspan="3" ><b>EBP I</b></th>
                <th class="thTable1" colspan="3" ><b>EBP II</b></th>
                <th class="thTable1" rowspan="2" width="45px"><b>NO. 1</b></th>
                <th class="thTable1" rowspan="2" width="45px"><b>NO. 2</b></th>
                <th class="thTable1" colspan="2" ><b>EBP I</b></th>
                <th class="thTable1" colspan="2" ><b>EBP II</b></th>
                <th class="thTable1" colspan="2" ><b>BUNCH CRUISER</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" width="45px"><b>TEMP C</b></th>
                <th class="thTable1" width="45px"><b>BAIK</b></th>
                <th class="thTable1" width="45px"><b>NORMAL</b></th>
                <th class="thTable1" width="45px"><b>KURANG</b></th>
                <th class="thTable1" width="45px"><b>BAIK</b></th>
                <th class="thTable1" width="45px"><b>NORMAL</b></th>
                <th class="thTable1" width="45px"><b>KURANG</b></th>
                <th class="thTable1" width="55px"><b>START</b></th>
                <th class="thTable1" width="55px"><b>STOP</b></th>
                <th class="thTable1" width="55px"><b>START</b></th>
                <th class="thTable1" width="55px"><b>STOP</b></th>
                <th class="thTable1" width="55px"><b>START</b></th>
                <th class="thTable1" width="55px"><b>STOP</b></th>
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
                <td class="tdTable1" ><?= $data_sql[$i]['POSTDT'] ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['TIME_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THRSMP'] != 0) echo number_format($data_sql[$i]['THRSMP'],2,".",","); ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THRUSB'] != 0) echo number_format($data_sql[$i]['THRUSB'],2,".",","); ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THRPER'] != 0) echo number_format($data_sql[$i]['THRPER'],2,".",","); ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['THREBP_V1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['THREBP_A1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['THREBP_V2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['THREBP_A2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['THRLIQ_TP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THREBP_GB1'] == 3) {echo '<img src = "'.$imagesPath.'/check.png'.'" alt="On" width="8" height="8" />';} else if($data_sql[$i]['THREBP_GB1'] == 0) {echo '<img src = "'.$imagesPath.'/question-mark-orange.png'.'" alt="?" width="8" height="8" />';}  ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THREBP_GB1'] == 2) {echo '<img src = "'.$imagesPath.'/check.png'.'" alt="On" width="8" height="8" />';} else if($data_sql[$i]['THREBP_GB1'] == 0) {echo '<img src = "'.$imagesPath.'/question-mark-orange.png'.'" alt="?" width="8" height="8" />';}  ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THREBP_GB1'] == 1) {echo '<img src = "'.$imagesPath.'/check.png'.'" alt="On" width="8" height="8" />';} else if($data_sql[$i]['THREBP_GB1'] == 0) {echo '<img src = "'.$imagesPath.'/question-mark-orange.png'.'" alt="?" width="8" height="8" />';}  ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THREBP_GB2'] == 3) {echo '<img src = "'.$imagesPath.'/check.png'.'" alt="On" width="8" height="8" />';} else if($data_sql[$i]['THREBP_GB2'] == 0) {echo '<img src = "'.$imagesPath.'/question-mark-orange.png'.'" alt="?" width="8" height="8" />';}  ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THREBP_GB2'] == 2) {echo '<img src = "'.$imagesPath.'/check.png'.'" alt="On" width="8" height="8" />';} else if($data_sql[$i]['THREBP_GB2'] == 0) {echo '<img src = "'.$imagesPath.'/question-mark-orange.png'.'" alt="?" width="8" height="8" />';}  ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THREBP_GB2'] == 1) {echo '<img src = "'.$imagesPath.'/check.png'.'" alt="On" width="8" height="8" />';} else if($data_sql[$i]['THREBP_GB2'] == 0) {echo '<img src = "'.$imagesPath.'/question-mark-orange.png'.'" alt="?" width="8" height="8" />';}  ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THRPMP1'] > 0){echo '<img src = "'.$imagesPath.'/check.png'.'" alt="On" width="8" height="8" />';} else {echo '<img src = "'.$imagesPath.'/close.png'.'" alt="Off" width="5" height="5" />';} ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THRPMP2'] > 0){echo '<img src = "'.$imagesPath.'/check.png'.'" alt="On" width="8" height="8" />';} else {echo '<img src = "'.$imagesPath.'/close.png'.'" alt="Off" width="5" height="5" />';} ?></td>
                <td class="tdTable1" ><?= substr($data_sql[$i]['THREBP_HMS1'],0,strlen($data_sql[$i]['THREBP_HMS1'])-4).'.'.substr($data_sql[$i]['THREBP_HMS1'],strlen($data_sql[$i]['THREBP_HMS1'])-4,2).'.'.substr($data_sql[$i]['THREBP_HMS1'],strlen($data_sql[$i]['THREBP_HMS1'])-2,2)  ?></td>
                <td class="tdTable1" ><?= substr($data_sql[$i]['THREBP_HME1'],0,strlen($data_sql[$i]['THREBP_HME1'])-4).'.'.substr($data_sql[$i]['THREBP_HME1'],strlen($data_sql[$i]['THREBP_HME1'])-4,2).'.'.substr($data_sql[$i]['THREBP_HME1'],strlen($data_sql[$i]['THREBP_HME1'])-2,2)  ?></td>
                <td class="tdTable1" ><?= substr($data_sql[$i]['THREBP_HMS2'],0,strlen($data_sql[$i]['THREBP_HMS2'])-4).'.'.substr($data_sql[$i]['THREBP_HMS2'],strlen($data_sql[$i]['THREBP_HMS2'])-4,2).'.'.substr($data_sql[$i]['THREBP_HMS2'],strlen($data_sql[$i]['THREBP_HMS2'])-2,2)  ?></td>
                <td class="tdTable1" ><?= substr($data_sql[$i]['THREBP_HME2'],0,strlen($data_sql[$i]['THREBP_HME2'])-4).'.'.substr($data_sql[$i]['THREBP_HME2'],strlen($data_sql[$i]['THREBP_HME2'])-4,2).'.'.substr($data_sql[$i]['THREBP_HME2'],strlen($data_sql[$i]['THREBP_HME2'])-2,2)  ?></td>
                <td class="tdTable1" ><?= substr($data_sql[$i]['THRBNC_HMS1'],0,strlen($data_sql[$i]['THRBNC_HMS1'])-4).'.'.substr($data_sql[$i]['THRBNC_HMS1'],strlen($data_sql[$i]['THRBNC_HMS1'])-4,2).'.'.substr($data_sql[$i]['THRBNC_HMS1'],strlen($data_sql[$i]['THRBNC_HMS1'])-2,2)  ?></td>
                <td class="tdTable1" ><?= substr($data_sql[$i]['THRBNC_HME1'],0,strlen($data_sql[$i]['THRBNC_HME1'])-4).'.'.substr($data_sql[$i]['THRBNC_HME1'],strlen($data_sql[$i]['THRBNC_HME1'])-4,2).'.'.substr($data_sql[$i]['THRBNC_HME1'],strlen($data_sql[$i]['THRBNC_HME1'])-2,2)  ?></td>
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
