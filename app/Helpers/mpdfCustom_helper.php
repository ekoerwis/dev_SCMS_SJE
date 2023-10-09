<?php

function mpdf_Header3C03F($HL1="",$HL2=" ",$HL3=" "){

    if($HL1==""){
        $userOrganisasi=$_SESSION['userOrganisasi'];
        $HL1=$userOrganisasi['COMPANYNAME'];
    }

    return '
    <table style="width:100%;">
    <tr>
        <td style=" width:50%; text-align: left;"> 
            <table style="font-size: 8pt;">
                <tr><td  style="font-size: 10pt;color: #0000ff;"><b>'.$HL1.'</b></td></tr>
                <tr><td>'.$HL2.'</td></tr>
                <tr><td>'.$HL3.'</td></tr>
            </table>
        </td>
        <td style="width:50%; text-align:right;">  
            <table style="float:right;font-size: 8pt;">
                <tr><td style="text-align:left;">Print Date</td><td>:</td><td>{DATE j-M-Y}</td></tr>
                <tr><td style="text-align:left;">Print Time</td><td>:</td><td>{DATE H:i:s}</td></tr>
                <tr><td style="text-align:left;">Page</td><td>:</td><td>{PAGENO} of {nbpg}</td></tr>
            </table>
        </td>
    </tr>
    </table>
    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
    ';
}

function mpdf_Header3C00($HL1="",$HL2=" ",$HL3=" "){

    if($HL1==""){
        $userOrganisasi=$_SESSION['userOrganisasi'];
        $HL1=$userOrganisasi['COMPANYNAME'];
    }

    return '
    <table style="width:100%;">
    <tr>
        <td style=" width:50%; text-align: left;"> 
            <table style="font-size: 8pt;">
                <tr><td  style="font-size: 10pt;color: #0000ff;"><b>'.$HL1.'</b></td></tr>
                <tr><td>'.$HL2.'</td></tr>
                <tr><td>'.$HL3.'</td></tr>
            </table>
        </td>
    </tr>
    </table>
    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
    ';
}