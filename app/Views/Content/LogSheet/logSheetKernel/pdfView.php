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
                <th rowspan="3" class="thTable1"  width="50px"><b>JAM</b></th>
                <th colspan="4" class="thTable1"  rowspan="2"><b>TEMPERATUR KERNEL SILO</b></th>
                <th colspan="12" class="thTable1"><b>OPERASI HYDROCYCLONE</b></th>
                <th colspan="12" class="thTable1" ><b>HM RIPPLE MILL</b></th>
                <!-- <th rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:60,align:'center' " ><b>PARAF MANDOR</b></th> -->
                <!-- <th rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:160,align:'center' " ><b>KETERANGAN</b></th> -->
            </tr>
            <tr class="trHeadTable1">
                <th colspan="2" class="thTable1" ><b>1</b></th>
                <th colspan="2" class="thTable1" ><b>2</b></th>
                <th colspan="2" class="thTable1" ><b>3</b></th>
                <th colspan="2" class="thTable1" ><b>4</b></th>
                <th colspan="2" class="thTable1" ><b>5</b></th>
                <th colspan="2" class="thTable1" ><b>6</b></th>
                <th colspan="2" class="thTable1" ><b>1</b></th>
                <th colspan="2" class="thTable1" ><b>2</b></th>
                <th colspan="2" class="thTable1" ><b>3</b></th>
                <th colspan="2" class="thTable1" ><b>4</b></th>
                <th colspan="2" class="thTable1" ><b>5</b></th>
                <th colspan="2" class="thTable1" ><b>6</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" width="50px"><b>NO. 1</b></th>
                <th class="thTable1" width="50px"><b>NO. 2</b></th>
                <th class="thTable1" width="50px"><b>NO. 3</b></th>
                <th class="thTable1" width="50px"><b>NO. 4</b></th>

                <th class="thTable1" width="50px"><b>START</b></th>
                <th class="thTable1" width="50px"><b>STOP</b></th>
                <th class="thTable1" width="50px"><b>START</b></th>
                <th class="thTable1" width="50px"><b>STOP</b></th>
                <th class="thTable1" width="50px"><b>START</b></th>
                <th class="thTable1" width="50px"><b>STOP</b></th>
                <th class="thTable1" width="50px"><b>START</b></th>
                <th class="thTable1" width="50px"><b>STOP</b></th>
                <th class="thTable1" width="50px"><b>START</b></th>
                <th class="thTable1" width="50px"><b>STOP</b></th>
                <th class="thTable1" width="50px"><b>START</b></th>
                <th class="thTable1" width="50px"><b>STOP</b></th>

                <th class="thTable1" width="50px"><b>AWAL</b></th>
                <th class="thTable1" width="50px"><b>AKHIR</b></th>
                <th class="thTable1" width="50px"><b>AWAL</b></th>
                <th class="thTable1" width="50px"><b>AKHIR</b></th>
                <th class="thTable1" width="50px"><b>AWAL</b></th>
                <th class="thTable1" width="50px"><b>AKHIR</b></th>
                <th class="thTable1" width="50px"><b>AWAL</b></th>
                <th class="thTable1" width="50px"><b>AKHIR</b></th>
                <th class="thTable1" width="50px"><b>AWAL</b></th>
                <th class="thTable1" width="50px"><b>AKHIR</b></th>
                <th class="thTable1" width="50px"><b>AWAL</b></th>
                <th class="thTable1" width="50px"><b>AKHIR</b></th>
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
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERSIL_TMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERSIL_TMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERSIL_TMP3'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERSIL_TMP4'],2,".",",") ?></td>

                <td class="tdTable1" ><?= $data_sql[$i]['KERHDS_STR1_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['KERHDS_STR1_DISP'] == null){ echo $data_sql[$i]['KERHDS_END1_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['KERHDS_STR2_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['KERHDS_STR2_DISP'] == null){ echo $data_sql[$i]['KERHDS_END2_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['KERHDS_STR3_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['KERHDS_STR3_DISP'] == null){ echo $data_sql[$i]['KERHDS_END3_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['KERHDS_STR4_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['KERHDS_STR4_DISP'] == null){ echo $data_sql[$i]['KERHDS_END4_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['KERHDS_STR5_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['KERHDS_STR5_DISP'] == null){ echo $data_sql[$i]['KERHDS_END5_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['KERHDS_STR6_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['KERHDS_STR6_DISP'] == null){ echo $data_sql[$i]['KERHDS_END6_DISP']; }  ?></td>

                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HMS1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HME1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HMS2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HME2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HMS3'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HME3'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HMS4'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HME4'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HMS5'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HME5'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HMS6'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['KERRPM_HME6'],2,".",",") ?></td>
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
