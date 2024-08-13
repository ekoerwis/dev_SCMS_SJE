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
    font-size: 10pt; 
    background-color: #FFFFFF;
}

.table1{
    border-collapse: collapse;
    border: 1px solid black;
    font-size: 10pt; 
}

.trHeadTable1 {
    border: 1px solid black;
    border-collapse: collapse;
}

.thTable1 {
    border: 1px solid black;
    border-collapse: collapse;
    text-align: center;
    font-size: 8pt;
}

.tdTable1 {
    /* border: 1px solid black; */
    border-collapse: collapse;
    border-top: 1px solid black;
    border-right: 1px solid black;
    border-left: 1px solid black;
    /* border-bottom: 1px solid black; */
    text-align: center;
    font-size: 9pt;
    
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
                <th rowspan="3" class="thTable1"  width="40px"><b>JAM</b></th>
                <th class="thTable1" rowspan="2" colspan="3"><b>THRESHER</b></th>
                <th class="thTable1" colspan="2" rowspan="2"><b>AMPERE</b></th>
                <th class="thTable1" rowspan="2" ><b>BAK LIQOUR</b></th>
                <th class="thTable1" colspan="4" ><b>POMPA</b></th>
                <th class="thTable1" colspan="6" ><b>HOUR METER (HM)</b></th>
            </tr>
            <tr>
                <th class="thTable1" colspan="2" ><b>NO 1</b></th>
                <th class="thTable1" colspan="2" ><b>NO 2</b></th>
                <th class="thTable1" colspan="2" ><b>EBP I</b></th>
                <th class="thTable1" colspan="2" ><b>EBP II</b></th>
                <th class="thTable1" colspan="2" ><b>BUNCH CRUSHER</b></th>
            </tr>
            <tr>
                <th class="thTable1"  width="65px"><b>SAMPLE</b></th>
                <th class="thTable1"  width="55px"><b>USB</b></th>
                <th class="thTable1"  width="55px"><b>%</b></th>
                <th class="thTable1"  width="55px"><b>EBP I</b></th>
                <th class="thTable1"  width="55px"><b>EBP II</b></th>
                <th class="thTable1"  width="65px"><b>TEMP C</b></th>
                <th class="thTable1"  width="55px"><b>-</b></th>
                <th class="thTable1"  width="65px"><b>AMP</b></th>
                <th class="thTable1"  width="55px"><b>-</b></th>
                <th class="thTable1"  width="65px"><b>AMP</b></th>
                <th class="thTable1"  width="75px"><b>START</b></th>
                <th class="thTable1"  width="75px"><b>STOP</b></th>
                <th class="thTable1"  width="75px"><b>START</b></th>
                <th class="thTable1"  width="75px"><b>STOP</b></th>
                <th class="thTable1"  width="75px"><b>START</b></th>
                <th class="thTable1"  width="75px"><b>STOP</b></th>
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
                <td class="tdTable1" ><?php if($data_sql[$i]['THRSMP'] != 0) echo number_format($data_sql[$i]['THRSMP'],2,".",","); ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THRUSB'] != 0) echo number_format($data_sql[$i]['THRUSB'],2,".",","); ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THRPER'] != 0) echo number_format($data_sql[$i]['THRPER'],2,".",","); ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['THREBP_A1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['THREBP_A2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['THRLIQ_TP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THRPMP1'] > 0){echo '<img src = "'.$imagesPath.'/check.png'.'" alt="On" width="8" height="8" />';} else {echo '<img src = "'.$imagesPath.'/close.png'.'" alt="Off" width="5" height="5" />';} ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['AMPPMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['THRPMP2'] > 0){echo '<img src = "'.$imagesPath.'/check.png'.'" alt="On" width="8" height="8" />';} else {echo '<img src = "'.$imagesPath.'/close.png'.'" alt="Off" width="5" height="5" />';} ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['AMPPMP2'],2,".",",") ?></td>
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
