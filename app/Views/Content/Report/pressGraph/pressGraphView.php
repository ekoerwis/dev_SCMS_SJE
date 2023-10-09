<?php 
    use \koolreport\widgets\koolphp\Table;
    use \koolreport\widgets\google\BarChart;
    use \koolreport\widgets\google\LineChart;
?>
<div id="tb-pv" class="pb-1 pt-1">        
    <div class='col-xl-12 col-lg-12 col-md-12 row'>
        
        <div class="col row">
            <button id="btn-searchReset" class="btn btn-warning" style="width: 100px;"  onclick="chartJSView()"><i class="fas fa-print"></i> Print</button>
        </div>

        <div class=" col-md-auto  text-right">
            <button id="btn-search" class="btn btn-primary" style="width: 100px;"  onclick="koolreportView()"><i class="fas fa-chart-line"></i> koolreport</button>
            &nbsp;
            <button id="btn-searchReset" class="btn btn-danger" style="width: 100px;"  onclick="chartJSView()"><i class="fas fa-chart-line"></i> chartJS</button>
            <!-- &nbsp;
            <button id="btn-print" class="btn btn-success" style="width: 75px;" onclick="exportDataExcel()" ><i class="fas fa-print"></i> .Xlsx</button>
            &nbsp;
            <button id="btn-print" class="btn btn-warning" style="width: 75px;" onclick="exportDataPDF()" ><i class="fas fa-print"></i> .Pdf</button> -->
        </div>
    </div>

</div>
<script>
//JS koolreportView
function koolreportView(){

    url = "<?php echo site_url().'/../Content/Report/pressGraph'; ?>" ;
    window.open(url,"_self");
}

function chartJSView(){

    url = "<?php echo site_url().'/../Content/Report/pressGraph/chartJSView'; ?>" ;
    window.open(url,"_self");
    
}
</script>


<div class="report-content">
    <div class="text-center">
        <h1>Press Station (Test)</h1>
        <p class="lead">Temperatur Digester</p>
    </div>

    <?php
    // BarChart::create(array(
    //     "dataStore"=>$dataGraph1,
    //     "width"=>"100%",
    //     "height"=>"500px",
    //     "columns"=>array(
    //         "PRSHR"=>array(
    //             "label"=>"Jam"
    //         ),
    //         "PRSDG_TMP1"=>array(
    //             "type"=>"number",
    //             "label"=>"TEMP 1",
    //             // "prefix"=>"$",
    //             "emphasis"=>true
    //         )
    //     ),
    //     "options"=>array(
    //         "title"=>"Sales By Customer",
    //     )
    // ));
    // ?>

<?php
    LineChart::create(array(
        "dataStore"=>$dataGraph1,
        "width"=>"100%",
        "height"=>"500px",
        "columns"=>array(
            "PRSHR"=>array(
                "label"=>"Jam"
            ),
            "PRSDG_TMP1"=>array(
                "type"=>"number",
                "decimals"=>2,
                "label"=>"TEMP 1",
                // "prefix"=>"$",
                "emphasis"=>true
            ),
            "PRSDG_TMP2"=>array(
                "type"=>"number",
                "decimals"=>2,
                "label"=>"TEMP 2",
                // "prefix"=>"$",
                "emphasis"=>true
            ),
            "PRSDG_TMP3"=>array(
                "type"=>"number",
                "decimals"=>2,
                "label"=>"TEMP 3",
                // "prefix"=>"$",
                "emphasis"=>true
            ),
            "PRSDG_TMP4"=>array(
                "type"=>"number",
                "decimals"=>2,
                "label"=>"TEMP 4",
                // "prefix"=>"$",
                "emphasis"=>true
            ),
            "PRSDG_TMP5"=>array(
                "type"=>"number",
                "decimals"=>2,
                "label"=>"TEMP 5",
                // "prefix"=>"$",
                "emphasis"=>true
            ),
            "PRSDG_TMP6"=>array(
                "type"=>"number",
                "decimals"=>2,
                "label"=>"TEMP 6",
                // "prefix"=>"$",
                "emphasis"=>true
            )
        ),
        "options"=>array(
            "title"=>"Digester Per Jam",
        )
    ));
    ?>
   
    <?php
    Table::create(array(
        "dataStore"=>$dataGraph1,
            "columns"=>array(
                "PRSHR"=>array(
                    "label"=>"Jam"
                ),
                "PRSDG_TMP1"=>array(
                    "type"=>"float",
                    "label"=>"TEMP 1",
                    // "prefix"=>"$",
                ),
                "PRSDG_TMP2"=>array(
                    "type"=>"float",
                    "label"=>"TEMP 2",
                    // "prefix"=>"$",
                    "emphasis"=>true
                ),
                "PRSDG_TMP3"=>array(
                    "type"=>"float",
                    "label"=>"TEMP 3",
                    // "prefix"=>"$",
                    "emphasis"=>true
                ),
                "PRSDG_TMP4"=>array(
                    "type"=>"float",
                    "label"=>"TEMP 4",
                    // "prefix"=>"$",
                    "emphasis"=>true
                ),
                "PRSDG_TMP5"=>array(
                    "type"=>"float",
                    "label"=>"TEMP 5",
                    // "prefix"=>"$",
                    "emphasis"=>true
                ),
                "PRSDG_TMP6"=>array(
                    "type"=>"float",
                    "label"=>"TEMP 6",
                    // "prefix"=>"$",
                    "emphasis"=>true
                )
            ),
        "cssClass"=>array(
            "table"=>"table table-hover table-bordered"
        )
    ));
    ?>
</div>