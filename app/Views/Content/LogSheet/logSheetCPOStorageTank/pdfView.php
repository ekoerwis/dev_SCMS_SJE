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
}

.tdTable1 {
    /* border: 1px solid black; */
    border-collapse: collapse;
    border-top: 1px solid black;
    border-right: 1px solid black;
    border-left: 1px solid black;
    /* border-bottom: 1px solid black; */
    
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

<!-- <table id="dataTable" class="table1">
        <thead>
            <tr class="trHeadTable1">
                <th rowspan="3" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>JAM</b></th>
                <th colspan="6" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;"><b>STANDARD</b></th>
                <th colspan="12" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" ><b>DATA SAMPLING</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="40px"><b>LEVEL cm</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="40px"><b>LEVEL mm</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>SUHU</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>BERAT JENIS</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>MUAI RUANG</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>BERAT (Kg)</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>WAKTU</b></th>
                <th colspan="6" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;"><b>SUHU INTERNAL</b></th>
                <th colspan="5" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;"><b>SUHU EXTERNAL</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="30px"><b>1</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="30px"><b>2</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="30px"><b>3</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="30px"><b>4</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="30px"><b>5</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>AVG</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="30px"><b>1</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="30px"><b>2</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="30px"><b>3</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>SCALA</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>AVG</b></th>
            </tr>
        </thead>
</table> -->
<?php
    if(isset($data_sql)) {
    $jmlData = count($data_sql);
?>

    <table id="dataTable" class="table1">
        <thead>
            <tr class="trHeadTable1">
                <th rowspan="3" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>JAM</b></th>
                <th colspan="6" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;"><b>STANDARD</b></th>
                <th colspan="12" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" ><b>DATA SAMPLING</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>LEVEL cm</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>LEVEL mm</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>SUHU</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>BERAT JENIS</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>MUAI RUANG</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>BERAT (Kg)</b></th>
                <th rowspan="2" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="120px"><b>WAKTU</b></th>
                <th colspan="6" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;"><b>SUHU INTERNAL</b></th>
                <th colspan="5" class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;"><b>SUHU EXTERNAL</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>1</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>2</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>3</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>4</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>5</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>AVG</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>1</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>2</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>3</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>SCALA</b></th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px"><b>AVG</b></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $numData=0;
                for($i=0;$i < $jmlData;$i++){
                    $numData++;
            ?>
            <tr>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['TIME_DISP'] ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGLVCM'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGLVMM'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPINTAVG'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['BJ'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['CORECTIONF'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['WEIGHT'],0,".",",") ?></td>
                <td class="tdTable1" style="text-align: left;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['SUMSTGID_UEP_TIME'] ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPINT1'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPINT2'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPINT3'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPINT4'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPINT5'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPINTAVG'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPEXT1'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPEXT2'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPEXT3'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPEXTF'],2,".",",") ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= number_format($data_sql[$i]['STGTMPEXTAVG'],2,".",",") ?></td>
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
