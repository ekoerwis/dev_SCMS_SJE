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

    
<?php
    if(isset($data_sql)) {
    $jmlData = count($data_sql);
?>

    <table id="dataTable" class="table1">
        <thead>
            <tr class="trHeadTable1">
                <th class="thTable1" rowspan=2 style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="30px">No</th>
                <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="70px">STERILIZER</th>
                <th class="thTable1" colspan=3 style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;">MASUK BUAH</th>
                <!-- <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px">WAKTU</th> -->
                <th class="thTable1" colspan=3 style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;">MEREBUS</th>
                <!-- <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px">WAKTU</th> -->
                <th class="thTable1" colspan=3 style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;">KELUAR BUAH</th>
                <!-- <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px">WAKTU</th> -->
                <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px">TOTAL WAKTU</th>
                <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="100px">PARAF MANDOR</th>
                <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="100px">KETERANGAN</th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">START</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">STOP</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">WAKTU</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">START</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">STOP</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">WAKTU</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">START</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">STOP</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">WAKTU</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // $totalPeriod_debitamountorg=0;
            // $totalSite_debitamountorg=0;
            // $totalYear_debitamountorg=0;
            // $totalPeriod_creditamountorg = 0;
            // $totalSite_creditamountorg = 0;
            // $totalYear_creditamountorg = 0;
            // $totalPeriod_quantity = 0;
            // $totalSite_quantity = 0;
            // $totalYear_quantity = 0;
            // $totalPeriod_mandays = 0;
            // $totalSite_mandays = 0;
            // $totalYear_mandays = 0;
                $numData=0;
                for($i=0;$i < $jmlData;$i++){
                    $numData++;
            ?>
            <tr>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?=$numData?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZID'] ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZIN_ST_TIME'] ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZIN_ED_TIME'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZIN_MN'] ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZPRO_ST_TIME'] ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZPRO_ED_TIME'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZPRO_MN'] ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZOUT_ST_TIME'] ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZOUT_ED_TIME'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZOUT_MN'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZTM_TOT'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZACC'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZNOTE'] ?></td>
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
