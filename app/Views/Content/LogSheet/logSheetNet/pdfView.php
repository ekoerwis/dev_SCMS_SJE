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
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="30px">No</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="70px">PERIODE</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="70px">ADDRESS</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px">HOUR</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="150px">CHECK</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="50px">COUNT</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center; font-size: 7pt;" width="200px">MESSAGE</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $numData=0;
                for($i=0;$i < $jmlData;$i++){
                    $numData++;
            ?>
            <tr>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?=$numData?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['POSTDT'] ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['NETADD'] ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['NETHR'] ?></td>
                <td class="tdTable1" style="text-align: left;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['NETCHK'] ?></td>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['NETCNT'] ?></td>
                <td class="tdTable1" style="text-align: left;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['NETMSG'] ?></td>
                
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
