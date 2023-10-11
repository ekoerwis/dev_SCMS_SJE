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
    /* font-size: 7pt; */
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
                <th rowspan="3" class="thTable1"  width="30px"><b>JAM</b></th>
                <th colspan="5" rowspan="2" class="thTable1" ><b>DIGESTER MASS TEMP ( <span>&#176;</span>C )</b></th>
                <th colspan="5" rowspan="2" class="thTable1" ><b>DIGESTER LOAD (AMP)</b></th>
                <th colspan="5" rowspan="2" class="thTable1" ><b>PRESS CONE PRESSURE (BAR)</b></th>
                <th colspan="24" class="thTable1" ><b>RUNNING HOUR</b></th>
            </tr>
            <tr>
                <th colspan="2" class="thTable1" ><b>PRESS NO.1</b></th>
                <th colspan="2" class="thTable1" ><b>PRESS NO.2</b></th>
                <th colspan="2" class="thTable1" ><b>PRESS NO.3</b></th>
                <th colspan="2" class="thTable1" ><b>PRESS NO.4</b></th>
                <th colspan="2" class="thTable1" ><b>PRESS NO.5</b></th>
                <!-- <th colspan="2" class="thTable1" ><b>PRESS NO.6</b></th> -->
                <th colspan="2" class="thTable1" ><b>DIGESTER NO.1</b></th>
                <th colspan="2" class="thTable1" ><b>DIGESTER NO.2</b></th>
                <th colspan="2" class="thTable1" ><b>DIGESTER NO.3</b></th>
                <th colspan="2" class="thTable1" ><b>DIGESTER NO.4</b></th>
                <th colspan="2" class="thTable1" ><b>DIGESTER NO.5</b></th>

                <th colspan="2" class="thTable1" ><b>CBC NO.1</b></th>
                <th colspan="2" class="thTable1" ><b>CBC NO.2</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1"  width="35px"><b>NO.1</b></th>
                <th class="thTable1"  width="35px"><b>NO.2</b></th>
                <th class="thTable1"  width="35px"><b>NO.3</b></th>
                <th class="thTable1"  width="35px"><b>NO.4</b></th>
                <th class="thTable1"  width="35px"><b>NO.5</b></th>
                <!-- <th class="thTable1"  width="35px"><b>NO.6</b></th> -->
                <!-- <th class="thTable1"  width="35px"><b>AVG</b></th> -->
                <th class="thTable1"  width="35px"><b>NO.1</b></th>
                <th class="thTable1"  width="35px"><b>NO.2</b></th>
                <th class="thTable1"  width="35px"><b>NO.3</b></th>
                <th class="thTable1"  width="35px"><b>NO.4</b></th>
                <th class="thTable1"  width="35px"><b>NO.5</b></th>
                <!-- <th class="thTable1"  width="35px"><b>NO.6</b></th> -->
                <th class="thTable1"  width="35px"><b>NO.1</b></th>
                <th class="thTable1"  width="35px"><b>NO.2</b></th>
                <th class="thTable1"  width="35px"><b>NO.3</b></th>
                <th class="thTable1"  width="35px"><b>NO.4</b></th>
                <th class="thTable1"  width="35px"><b>NO.5</b></th>
                <!-- <th class="thTable1"  width="35px"><b>NO.6</b></th> -->
                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>
                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>
                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>
                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>
                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>
                
                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>
                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>
                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>
                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>
                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>

                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>
                <th class="thTable1"  width="35px"><b>START</b></th>
                <th class="thTable1"  width="35px"><b>STOP</b></th>
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
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_TMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_TMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_TMP3'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_TMP4'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_TMP5'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_AMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_AMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_AMP3'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_AMP4'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_AMP5'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_CNP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_CNP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_CNP3'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_CNP4'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_CNP5'],2,".",",") ?></td>

                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_HMS1'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_HME1'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_HMS2'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_HME2'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_HMS3'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_HME3'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_HMS4'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_HME4'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_HMS5'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSSP_HME5'],0,".",",") ?></td>

                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_HMS1'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_HME1'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_HMS2'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_HME2'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_HMS3'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_HME3'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_HMS4'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_HME4'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_HMS5'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSDG_HME5'],0,".",",") ?></td>

                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSCB_HMS1'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSCB_HME1'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSCB_HMS2'],0,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['PRSCB_HME2'],0,".",",") ?></td>

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
