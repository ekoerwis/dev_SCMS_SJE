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
                <th colspan="18" class="thTable1" ><b>RUNNING HOUR</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th colspan="2" class="thTable1" ><b>DIGESTER NO.1</b></th>
                <th colspan="2" class="thTable1" ><b>DIGESTER NO.2</b></th>
                <th colspan="2" class="thTable1" ><b>DIGESTER NO.3</b></th>
                <th colspan="2" class="thTable1" ><b>DIGESTER NO.4</b></th>
                <th colspan="2" class="thTable1" ><b>DIGESTER NO.5</b></th>
                <th colspan="2" class="thTable1" ><b>DIGESTER NO.6</b></th>
                <th colspan="2" class="thTable1" ><b>CBC NO.1</b></th>
                <th colspan="2" class="thTable1" ><b>CBC NO.2</b></th>
                <th colspan="2" class="thTable1" ><b>CBC NO.3</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1"  width="40px"><b>START</b></th>
                <th class="thTable1"  width="40px"><b>STOP</b></th>
                <th class="thTable1"  width="40px"><b>START</b></th>
                <th class="thTable1"  width="40px"><b>STOP</b></th>
                <th class="thTable1"  width="40px"><b>START</b></th>
                <th class="thTable1"  width="40px"><b>STOP</b></th>
                <th class="thTable1"  width="40px"><b>START</b></th>
                <th class="thTable1"  width="40px"><b>STOP</b></th>
                <th class="thTable1"  width="40px"><b>START</b></th>
                <th class="thTable1"  width="40px"><b>STOP</b></th>
                <th class="thTable1"  width="40px"><b>START</b></th>
                <th class="thTable1"  width="40px"><b>STOP</b></th>
                <th class="thTable1"  width="40px"><b>START</b></th>
                <th class="thTable1"  width="40px"><b>STOP</b></th>
                <th class="thTable1"  width="40px"><b>START</b></th>
                <th class="thTable1"  width="40px"><b>STOP</b></th>
                <th class="thTable1"  width="40px"><b>START</b></th>
                <th class="thTable1"  width="40px"><b>STOP</b></th>
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
                <td class="tdTable1" ><?= $data_sql[$i]['PRSDG_SRT1_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['PRSDG_SRT1_DISP'] == null){ echo $data_sql[$i]['PRSDG_END1_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['PRSDG_SRT2_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['PRSDG_SRT2_DISP'] == null){ echo $data_sql[$i]['PRSDG_END2_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['PRSDG_SRT3_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['PRSDG_SRT3_DISP'] == null){ echo $data_sql[$i]['PRSDG_END3_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['PRSDG_SRT4_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['PRSDG_SRT4_DISP'] == null){ echo $data_sql[$i]['PRSDG_END4_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['PRSDG_SRT5_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['PRSDG_SRT5_DISP'] == null){ echo $data_sql[$i]['PRSDG_END5_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['PRSDG_SRT6_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['PRSDG_SRT6_DISP'] == null){ echo $data_sql[$i]['PRSDG_END6_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['PRSCB_SRT1_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['PRSCB_SRT1_DISP'] == null){ echo $data_sql[$i]['PRSCB_END1_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['PRSCB_SRT2_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['PRSCB_SRT2_DISP'] == null){ echo $data_sql[$i]['PRSCB_END2_DISP']; }  ?></td>
                <td class="tdTable1" ><?= $data_sql[$i]['PRSCB_SRT3_DISP'] ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['PRSCB_SRT3_DISP'] == null){ echo $data_sql[$i]['PRSCB_END3_DISP']; }  ?></td>
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
