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
            <tr class="trHeadTable1">
                <th rowspan="3" class="thTable1"  width="35px"><b>JAM</b></th>
                <th colspan="4" rowspan="2" class="thTable1"  ><b>TEMP (<span>&#176;</span>C)</b></th>
                <th rowspan="2" class="thTable1"  ><b>VACUUM 1</b></th>
                <th rowspan="2" class="thTable1"  ><b>VACUUM 2</b></th>
                <th rowspan="2" class="thTable1"  ><b>ROT</b></th>
                <th colspan="6" class="thTable1"  ><b>CONTINOUS SETLING TANK</b></th>
                <th colspan="2" class="thTable1"  ><b>SAND TRAP TANK</b></th>
                <th colspan="2" class="thTable1"  ><b>SLUDGE TANK</b></th>
            </tr>
            <tr class="trHeadTable1">
                <!-- <th colspan="3" class="thTable1"  ><b>TEMP (<span>&#176;</span>C)</b></th> -->
                <th colspan="3" class="thTable1"  ><b>TEMP (<span>&#176;</span>C)</b></th>
                <th colspan="3" class="thTable1"  ><b>OIL LAYER (CM)</b></th>
                <th colspan="2" class="thTable1"  ><b>TEMP (<span>&#176;</span>C)</b></th>
                <th colspan="2" class="thTable1"  ><b>TEMP (<span>&#176;</span>C)</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1"  width="55px"><b>DCO</b></th>
                <th class="thTable1"  width="55px"><b>COT</b></th>
                <th class="thTable1"  width="75px" ><b>OIL TANK 1</b></th>
                <th class="thTable1"  width="75px" ><b>OIL TANK 2</b></th>
                <th class="thTable1"  width="50px" ><b>mmHg</b></th>
                <th class="thTable1"  width="50px" ><b>mmHg</b></th>
                <th class="thTable1"  width="50px" ><b><span>&#176;</span>C</b></th>
                <th class="thTable1"  width="50px"><b>NO.1</b></th>
                <th class="thTable1"  width="50px"><b>NO.2</b></th>
                <th class="thTable1"  width="50px"><b>NO.3</b></th>
                <th class="thTable1"  width="50px "><b>NO.1</b></th>
                <th class="thTable1"  width="50px "><b>NO.2</b></th>
                <th class="thTable1"  width="50px "><b>NO.3</b></th>
                <th class="thTable1"  width="50px "><b>NO.1</b></th>
                <th class="thTable1"  width="50px "><b>NO.2</b></th>
                <th class="thTable1"  width="50px "><b>NO.1</b></th>
                <th class="thTable1"  width="50px "><b>NO.2</b></th>
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
                <td class="tdTable1" ><?php if($data_sql[$i]['DOC'] > 0) echo number_format($data_sql[$i]['DOC'],2,".",","); ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['COTTMP1'] > 0) echo number_format($data_sql[$i]['COTTMP1'],2,".",","); ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['OITTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['OITTMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['VCMCH1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['VCMCH2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['ROTTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP3'],2,".",",") ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['CSTOLY1'] > 0) echo number_format($data_sql[$i]['CSTOLY1'],2,".",","); ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['CSTOLY2'] > 0) echo number_format($data_sql[$i]['CSTOLY2'],2,".",","); ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['CSTOLY3'] > 0) echo number_format($data_sql[$i]['CSTOLY3'],2,".",","); ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SDTTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SDTTMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SGTTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SGTTMP2'],2,".",",") ?></td>
            </tr>
<?php
            
        }
?>
        </tbody>
    </table>
<?php
    }
?>

<pagebreak></pagebreak>

<table id="dataTable" class="table1">
        <thead>
            <tr class="trHeadTable1">
                <th rowspan="3" class="thTable1"  width="50px"><b>JAM</b></th>
                <th colspan="2" class="thTable1"  ><b>TEMP SLUDGE SEPARATOR</b></th>
                <th colspan="2" rowspan="2" class="thTable1"  ><b>DECANTER IN OPERATION</b></th>
                <th rowspan="2" class="thTable1"  ><b>TEMP DECANTER</b></th>
                <th rowspan="2" class="thTable1"  ><b>PROCESS HOT WATER</b></th>
                <th colspan="4" class="thTable1"  ><b>HM SEPARATOR</b></th>
                <th colspan="4" class="thTable1"  ><b>HM DECANTER</b></th>
                <th rowspan="3" class="thTable1" width="65px" ><b>OUTLET SAND CYCLONE</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th colspan="2" class="thTable1"  ><b>TEMP (<span>&#176;</span>C)</b></th>
                <th colspan="2" class="thTable1"  ><b>HSS NO 1</b></th>
                <th colspan="2" class="thTable1"  ><b>HSS NO 2</b></th>
                <th colspan="2" class="thTable1"  ><b>DECANTER NO 1</b></th>
                <th colspan="2" class="thTable1"  ><b>DECANTER NO 2</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1"  width="50px "><b>-</b></th>
                <th class="thTable1"  width="50px "><b>-</b></th>
                <th class="thTable1"  width="50px "><b>NO.1</b></th>
                <th class="thTable1"  width="50px "><b>NO.2</b></th>
                <th class="thTable1"  width="50px "><b>-</b></th>
                <th class="thTable1"  width="50px" ><b><span>&#176;</span>C</b></th>
                <th class="thTable1"  width="70px "><b>START</b></th>
                <th class="thTable1"  width="70px "><b>STOP</b></th>
                <th class="thTable1"  width="70px "><b>START</b></th>
                <th class="thTable1"  width="70px "><b>STOP</b></th>
                <th class="thTable1"  width="70px "><b>START</b></th>
                <th class="thTable1"  width="70px "><b>STOP</b></th>
                <th class="thTable1"  width="70px "><b>START</b></th>
                <th class="thTable1"  width="70px "><b>STOP</b></th>
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
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SSPTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SSPTMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['DECACT1'] > 0){echo '<img src = "'.$imagesPath.'/check.png'.'" alt="On" width="8" height="8" />';} else {echo '<img src = "'.$imagesPath.'/close.png'.'" alt="Off" width="5" height="5" />';} ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['DECACT2'] > 0){echo '<img src = "'.$imagesPath.'/check.png'.'" color="red" alt="On" width="8" height="8" />';} else {echo '<img src = "'.$imagesPath.'/close.png'.'" alt="Off" width="5" height="5" />'; } ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['DECTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['HWTTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?=  substr($data_sql[$i]['SPHMS1'],0,strlen($data_sql[$i]['SPHMS1'])-4).'.'.substr($data_sql[$i]['SPHMS1'],strlen($data_sql[$i]['SPHMS1'])-4,2).'.'.substr($data_sql[$i]['SPHMS1'],strlen($data_sql[$i]['SPHMS1'])-2,2) ?></td>
                <td class="tdTable1" ><?=  substr($data_sql[$i]['SPHME1'],0,strlen($data_sql[$i]['SPHME1'])-4).'.'.substr($data_sql[$i]['SPHME1'],strlen($data_sql[$i]['SPHME1'])-4,2).'.'.substr($data_sql[$i]['SPHME1'],strlen($data_sql[$i]['SPHME1'])-2,2) ?></td>
                <td class="tdTable1" ><?=  substr($data_sql[$i]['SPHMS2'],0,strlen($data_sql[$i]['SPHMS2'])-4).'.'.substr($data_sql[$i]['SPHMS2'],strlen($data_sql[$i]['SPHMS2'])-4,2).'.'.substr($data_sql[$i]['SPHMS2'],strlen($data_sql[$i]['SPHMS2'])-2,2) ?></td>
                <td class="tdTable1" ><?=  substr($data_sql[$i]['SPHME2'],0,strlen($data_sql[$i]['SPHME2'])-4).'.'.substr($data_sql[$i]['SPHME2'],strlen($data_sql[$i]['SPHME2'])-4,2).'.'.substr($data_sql[$i]['SPHME2'],strlen($data_sql[$i]['SPHME2'])-2,2) ?></td>
                <td class="tdTable1" ><?=  substr($data_sql[$i]['DCHMS1'],0,strlen($data_sql[$i]['DCHMS1'])-4).'.'.substr($data_sql[$i]['DCHMS1'],strlen($data_sql[$i]['DCHMS1'])-4,2).'.'.substr($data_sql[$i]['DCHMS1'],strlen($data_sql[$i]['DCHMS1'])-2,2) ?></td>
                <td class="tdTable1" ><?=  substr($data_sql[$i]['DCHME1'],0,strlen($data_sql[$i]['DCHME1'])-4).'.'.substr($data_sql[$i]['DCHME1'],strlen($data_sql[$i]['DCHME1'])-4,2).'.'.substr($data_sql[$i]['DCHME1'],strlen($data_sql[$i]['DCHME1'])-2,2) ?></td>
                <td class="tdTable1" ><?=  substr($data_sql[$i]['DCHMS2'],0,strlen($data_sql[$i]['DCHMS2'])-4).'.'.substr($data_sql[$i]['DCHMS2'],strlen($data_sql[$i]['DCHMS2'])-4,2).'.'.substr($data_sql[$i]['DCHMS2'],strlen($data_sql[$i]['DCHMS2'])-2,2) ?></td>
                <td class="tdTable1" ><?=  substr($data_sql[$i]['DCHME2'],0,strlen($data_sql[$i]['DCHME2'])-4).'.'.substr($data_sql[$i]['DCHME2'],strlen($data_sql[$i]['DCHME2'])-4,2).'.'.substr($data_sql[$i]['DCHME2'],strlen($data_sql[$i]['DCHME2'])-2,2) ?></td>
                <td class="tdTable1" ><?php if($data_sql[$i]['OSS1'] > 0) echo number_format($data_sql[$i]['OSS1'],2,".",","); ?></td>
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
