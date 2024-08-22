<style>

.switchbutton-off {
    background-color: #FF6384;
    color: #fff;
}

</style>


<div id="tb-pv" class="pb-1 pt-1" style="background-color: white;">        
    <div class='col-xl-12 col-lg-12 col-md-12 row'>
        
        <div class="col row">
            <input id="dt-tdate" name="TDATE" class="easyui-datebox" style="width: 150px;"  data-options="required:true">
            &nbsp;
            <input id="sb-modeView" style="width:100px;">
            &nbsp;
            &nbsp;
            &nbsp;
            <div style="width: 80px; height: 25px; background-color: rgb(255, 99, 132); align-content: center; align-self: center; text-align: center; color: #fff;">Temp (<span>&#176;</span>C)</div> 
            &nbsp;
            <div style="width: 80px; height: 25px; background-color: #2873d0; align-content: center; align-self: center; text-align: center; color: #fff;">Press (BAR)</div> 
            &nbsp;
            <div style="width: 80px; height: 25px; background-color: rgb(75, 192, 192); align-content: center; align-self: center; text-align: center;color: #fff;">Dig (AMP)</div> 
        </div>
        
        <div class=" col-md-auto  text-right">
            <button id="btn-search" class="btn btn-primary" style="width: 100px;"  onclick="doSearch()"><i class="fas fa-search"></i> Search</button>
            &nbsp;
            
        </div>
    </div>

</div>

<div class="report-content" style="background-color: white;">
    <div class="col-xl-12 col-lg-12 col-md-12 border-right-blue-grey border-right-lighten-5">
        <div class="my-1 text-center">
          <div class="card-content">
            
            <div class="col-xl-12 col-lg-12 col-md-12 row">
                
                <?php
                    for($i=1 ; $i<6 ; $i++){
                        echo '<div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart'.$i.'_TEMP d-flex justify-content-center" style="height: 350px" >
                        <canvas id="myChart'.$i.'_TEMP" style="width:100%;"></canvas>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart'.$i.'_BAR d-flex justify-content-center" style="height: 350px" >
                        <canvas id="myChart'.$i.'_BAR" style="width:100%;"></canvas>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart'.$i.'_AMP d-flex justify-content-center" style="height: 350px" >
                        <canvas id="myChart'.$i.'_AMP" style="width:100%;"></canvas>
                    </div>';
                    }
                ?>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 row">
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 row">
            </div>

          </div>
        </div>
      </div>
   
    
</div>



<script>
     var myLineChart1_TEMP,myLineChart1_BAR,myLineChart1_AMP;
     var myLineChart2_TEMP,myLineChart2_BAR,myLineChart2_AMP;
     var myLineChart3_TEMP,myLineChart3_BAR,myLineChart3_AMP;
     var myLineChart4_TEMP,myLineChart4_BAR,myLineChart4_AMP;
     var myLineChart5_TEMP,myLineChart5_BAR,myLineChart5_AMP;
     var config_AMP, config_BAR, config_TEMP;

    $(document).ready(function() {

        $('#sb-modeView').switchbutton({
            checked: true,
            onText:'2 in Row',
            offText:'1 in Row',
            onChange: function(checked){
                if(checked){
                    // console.log('2');
                    if($(".myChartDiv").hasClass("col-xl-12 col-lg-12 col-md-12")){
                        $(".myChartDiv").removeClass("col-xl-12 col-lg-12 col-md-12");
                    }

                    $(".myChartDiv").addClass("col-xl-6 col-lg-6 col-md-6");
                } else {
                    // console.log('1');
                    if($(".myChartDiv").hasClass("col-xl-6 col-lg-6 col-md-6")){
                        $(".myChartDiv").removeClass("col-xl-6 col-lg-6 col-md-6");
                    }
                    
                    $(".myChartDiv").addClass("col-xl-12 col-lg-12 col-md-12");
                }
            }
        })

        settingCalendarTDATE();    
        doSearch();
    });

    function settingCalendarTDATE(){

        var d = new Date();
        var enddate = d.setDate(d.getDate() - 0);

        var paramDate = "<?php if(isset($_GET['POSTDT'])) { echo $_GET['POSTDT'];}  ?>";
        if(paramDate != ''){    
            var newD = new Date(paramDate);
            enddate = newD;
            
        } else {
            var newD = new Date(enddate);
        }

        $('#dt-tdate').datebox({
            value :  newD.getDate() + "-"+getMonthName(newD.getMonth()+1) + "-"+newD.getFullYear(),
        });

        $('#dt-tdate').datebox().datebox('calendar').calendar('moveTo', new Date(enddate));
    }

    function getMonthName(monthNumber) {
        const date = new Date();
        date.setMonth(monthNumber - 1);

        return date.toLocaleString('en-US', { month: 'short' });
    }

    function doSearch() {

        var dateParam = $('#dt-tdate').datebox('getValue');

        if( dateParam.trim() == '' || dateParam.trim() == null ){
            alert('"Tanggal" Harus Di Isi Dahulu');
            $('#dt-tdate').datebox('textbox').focus();
            exit;   
        } 
        
        for(i=1;i<7;i++){
            fetchData(dateParam,i,'pressure');
        }
        
    }    

    function fetchData(tdate='',iNumbers=0, dataHist='') {
        
        if(dataHist == 'pressure'){
            functionData ='getData';
        } else if (dataHist == 'bpv'){
            functionData ='getDataBpv';
        } else if (dataHist == 'turbin'){
            functionData ='getDataTurbin';
        } else {
            functionData ='';
        }

        DIVID = 151;

        if(iNumbers >=1 & iNumbers <=6){
            // DIVID_New = iNumbers +130;
            DIVID_New = 151;
        }

        $.ajax({
        url:"<?php echo site_url().'/../Content/Report/historicalPressureLineChart/'; ?>"+functionData,
        type: 'post',
        data : {
            TDATE : tdate,
            DIVID : DIVID_New,
            NUMBERS : iNumbers,
        },
        beforeSend: function (){
            $(".myChart"+iNumbers+"_TEMP").append('<i class="fa fa-spin fa-spinner myChartSpinner'+iNumbers+'_TEMP" style="font-size:30px; position:absolute; top:100px;z-index: 2;"></i>');
            $(".myChart"+iNumbers+"_BAR").append('<i class="fa fa-spin fa-spinner myChartSpinner'+iNumbers+'_BAR" style="font-size:30px; position:absolute; top:100px;z-index: 2;"></i>');
            $(".myChart"+iNumbers+"_AMP").append('<i class="fa fa-spin fa-spinner myChartSpinner'+iNumbers+'_AMP" style="font-size:30px; position:absolute; top:100px;z-index: 2;"></i>');
        },
        success: function(response) {
            if (response.length < 1) {
                alert("Data Kosong Hubungi Administrator");
            } else {
                objHistory = JSON.parse(response);
                // if(iNumbers==1){
                if(iNumbers>=1 & iNumbers <=5){
                    var xValues1 = [];
                    var yValues1 = [];
                    var y1Values1 = [];
                    var y2Values1 = [];
                    var yMin_TEMP = [];
                    var yMax_TEMP = [];
                    var yMin_BAR = [];
                    var yMax_BAR = [];
                    var yMin_AMP = [];
                    var yMax_AMP = [];
                    for (var i = 0; i < objHistory.length; i++) {
                        xValues1.push(objHistory[i].TM);
                        yValues1.push(objHistory[i].TEMP);
                        y1Values1.push(objHistory[i].BAR);
                        y2Values1.push(objHistory[i].AMP);
                        yMin_TEMP.push(objHistory[i].MIN_TEMP);
                        yMax_TEMP.push(objHistory[i].MAX_TEMP);
                        yMin_BAR.push(objHistory[i].MIN_BAR);
                        yMax_BAR.push(objHistory[i].MAX_BAR);
                        yMin_AMP.push(objHistory[i].MIN_AMP);
                        yMax_AMP.push(objHistory[i].MAX_AMP);
                    }
                    generateChart1(xValues1, yValues1, y1Values1, yMin_TEMP, yMax_TEMP, yMin_BAR, yMax_BAR, yMin_AMP, yMax_AMP, y2Values1, tdate,iNumbers);
                }

            }
        }
        });
    }
    
    function generateChart1(xValues1, yValues1, y1Values1, yMin_TEMP, yMax_TEMP, yMin_BAR, yMax_BAR, yMin_AMP, yMax_AMP,y2Values1, tdate,iNumbers) {

        // $(".myChart"+iNumbers).html('<canvas id="myChart'+iNumbers+'" style="width:100%;"></canvas>'); 
        $(".myChartSpinner"+iNumbers+"_TEMP").remove();
        $(".myChartSpinner"+iNumbers+"_BAR").remove();
        $(".myChartSpinner"+iNumbers+"_AMP").remove();
        config_TEMP = 
        {
            type: "line",
            data: {
                labels: xValues1,
                datasets: [{
                    label : 'Temp ( \u00B0C )',
                    fill: false,
                    backgroundColor: "rgb(255, 99, 132)",
                    borderColor: "rgb(255, 99, 132)",
                    borderWidth: 2,
                    data: yValues1,
                    yAxisID: 'y',
                },
                {
                    label : 'Min Temp',
                    fill: false,
                    backgroundColor: "rgba(255, 99, 132,0.3)",
                    borderColor: "rgba(255, 99, 132,0.3)",
                    borderWidth: 0,
                    data: yMin_TEMP,
                    yAxisID: 'y',
                },
                {
                    label : 'Max Temp',
                    fill: '-1',
                    backgroundColor: "rgba(255, 99, 132,0.3)",
                    borderColor: "rgba(255, 99, 132,0.3)",
                    borderWidth: 0,
                    data: yMax_TEMP,
                    yAxisID: 'y',
                },
                // {
                //     label : 'Press (BAR) ',
                //     fill: false,
                //     backgroundColor: "#2873d0",
                //     borderColor: "#2873d0",
                //     borderWidth: 2,
                //     data: y1Values1,
                //     yAxisID: 'y',
                // },
                // {
                //     label : 'Dig (AMP)',
                //     fill: false,
                //     backgroundColor: "rgb(75, 192, 192)",
                //     borderColor: "rgb(75, 192, 192)",
                //     borderWidth: 2,
                //     data: y2Values1,
                //     yAxisID: 'y',
                // }
            ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                pointStyle :false,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Time',
                            color: '#2873d0',
                            font: {
                                // family: 'Comic Sans MS',
                                // size: 20,
                                // weight: 'bold',
                                // lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        },
                        grid: {
                            display: true,
                        },
                        
                    },
                    y: {
                        min:40,
                        suggestedMax:110,
                        ticks: {
                        // forces step size to be 50 units
                        stepSize: 10
                        },
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Value',
                            color: 'rgb(255, 99, 132)',
                            font: {
                                // family: 'Comic Sans MS', size: 20, weight: 'bold', lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        },
                        grid: {
                            display: true,
                        },
                    },
                },
                plugins :{
                    title: {
                        display: true,
                        text: 'Press - '+iNumbers +' - Temp ( \u00B0C )',
                        fontSize : 14,
                    },
                    legend: {
                        display: false
                    },
                }
            }
        };

        
        config_BAR = 
        {
            type: "line",
            data: {
                labels: xValues1,
                datasets: [
                // {
                //     label : 'Temp ( \u00B0C )',
                //     fill: false,
                //     backgroundColor: "rgb(255, 99, 132)",
                //     borderColor: "rgb(255, 99, 132)",
                //     borderWidth: 2,
                //     data: yValues1,
                //     yAxisID: 'y',
                // },
                {
                    label : 'Press (BAR) ',
                    fill: false,
                    backgroundColor: "#2873d0",
                    borderColor: "#2873d0",
                    borderWidth: 2,
                    data: y1Values1,
                    yAxisID: 'y',
                },
                {
                    label : 'Press (BAR)',
                    fill: false,
                    backgroundColor: "rgba(40, 115, 208,0.3)",
                    borderColor: "rgba(40, 115, 208,0.3)",
                    borderWidth: 0,
                    data: yMin_BAR,
                    yAxisID: 'y',
                },
                {
                    label : 'Press (BAR)',
                    fill: '-1',
                    backgroundColor: "rgba(40, 115, 208,0.3)",
                    borderColor: "rgba(40, 115, 208,0.3)",
                    borderWidth: 0,
                    data: yMax_BAR,
                    yAxisID: 'y',
                },
                // {
                //     label : 'Dig (AMP)',
                //     fill: false,
                //     backgroundColor: "rgb(75, 192, 192)",
                //     borderColor: "rgb(75, 192, 192)",
                //     borderWidth: 2,
                //     data: y2Values1,
                //     yAxisID: 'y',
                // }
            ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                pointStyle :false,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Time',
                            color: '#2873d0',
                            font: {
                                // family: 'Comic Sans MS',
                                // size: 20,
                                // weight: 'bold',
                                // lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        },
                        grid: {
                            display: true,
                        },
                        
                    },
                    y: {
                        min:0,
                        max:100,
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Value',
                            color: 'rgb(255, 99, 132)',
                            font: {
                                // family: 'Comic Sans MS', size: 20, weight: 'bold', lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        },
                        grid: {
                            display: true,
                        },
                    },
                },
                plugins :{
                    title: {
                        display: true,
                        text: 'Press - '+iNumbers + ' - Press (Bar)',
                        fontSize : 14,
                    },
                    legend: {
                        display: false
                    },
                }
            }
        };
        
        config_AMP = 
        {
            type: "line",
            data: {
                labels: xValues1,
                datasets: [
                // {
                //     label : 'Temp ( \u00B0C )',
                //     fill: false,
                //     backgroundColor: "rgb(255, 99, 132)",
                //     borderColor: "rgb(255, 99, 132)",
                //     borderWidth: 2,
                //     data: yValues1,
                //     yAxisID: 'y',
                // },
                // {
                //     label : 'Press (BAR) ',
                //     fill: false,
                //     backgroundColor: "#2873d0",
                //     borderColor: "#2873d0",
                //     borderWidth: 2,
                //     data: y1Values1,
                //     yAxisID: 'y',
                // },
                {
                    label : 'Dig (AMP)',
                    fill: false,
                    backgroundColor: "rgb(75, 192, 192)",
                    borderColor: "rgb(75, 192, 192)",
                    borderWidth: 2,
                    data: y2Values1,
                    yAxisID: 'y',
                },
                {
                    label : 'Dig (AMP)',
                    fill: false,
                    backgroundColor: "rgba(75, 192, 192,0.3)",
                    borderColor: "rgba(75, 192, 192,0.3)",
                    borderWidth: 0,
                    data: yMin_BAR,
                    yAxisID: 'y',
                },
                {
                    label : 'Dig (AMP)',
                    fill: '-1',
                    backgroundColor: "rgba(75, 192, 192,0.3)",
                    borderColor: "rgba(75, 192, 192,0.3)",
                    borderWidth: 0,
                    data: yMax_BAR,
                    yAxisID: 'y',
                },
            ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                pointStyle :false,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Time',
                            color: '#2873d0',
                            font: {
                                // family: 'Comic Sans MS',
                                // size: 20,
                                // weight: 'bold',
                                // lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        },
                        grid: {
                            display: true,
                        },
                        
                    },
                    y: {
                        min:0,
                        max:100,
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Value',
                            color: 'rgb(255, 99, 132)',
                            font: {
                                // family: 'Comic Sans MS', size: 20, weight: 'bold', lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        },
                        grid: {
                            display: true,
                        },
                    },
                },
                plugins :{
                    title: {
                        display: true,
                        text: 'Press - '+iNumbers+ ' - Dig (AMP)',
                        fontSize : 14,
                    },
                    legend: {
                        display: false
                    },
                }
            }
        };

        if(iNumbers == 1){
            if(myLineChart1_TEMP){
                myLineChart1_TEMP.destroy();
            }
            var ctx1_TEMP = document.getElementById("myChart"+iNumbers+"_TEMP").getContext("2d");
            myLineChart1_TEMP = new Chart(ctx1_TEMP, config_TEMP);

            
            if(myLineChart1_BAR){
                myLineChart1_BAR.destroy();
            }
            var ctx1_BAR = document.getElementById("myChart"+iNumbers+"_BAR").getContext("2d");
            myLineChart1_BAR = new Chart(ctx1_BAR, config_BAR);

            
            if(myLineChart1_AMP){
                myLineChart1_AMP.destroy();
            }
            var ctx1_AMP = document.getElementById("myChart"+iNumbers+"_AMP").getContext("2d");
            myLineChart1_AMP = new Chart(ctx1_AMP, config_AMP);
        }

        if(iNumbers == 2){
            if(myLineChart2_TEMP){
                myLineChart2_TEMP.destroy();
            }
            var ctx2_TEMP = document.getElementById("myChart"+iNumbers+"_TEMP").getContext("2d");
            myLineChart2_TEMP = new Chart(ctx2_TEMP, config_TEMP);

            
            if(myLineChart2_BAR){
                myLineChart2_BAR.destroy();
            }
            var ctx2_BAR = document.getElementById("myChart"+iNumbers+"_BAR").getContext("2d");
            myLineChart2_BAR = new Chart(ctx2_BAR, config_BAR);

            
            if(myLineChart2_AMP){
                myLineChart2_AMP.destroy();
            }
            var ctx2_AMP = document.getElementById("myChart"+iNumbers+"_AMP").getContext("2d");
            myLineChart2_AMP = new Chart(ctx2_AMP, config_AMP);
        }

        if(iNumbers == 3){
            if(myLineChart3_TEMP){
                myLineChart3_TEMP.destroy();
            }
            var ctx3_TEMP = document.getElementById("myChart"+iNumbers+"_TEMP").getContext("2d");
            myLineChart3_TEMP = new Chart(ctx3_TEMP, config_TEMP);

            
            if(myLineChart3_BAR){
                myLineChart3_BAR.destroy();
            }
            var ctx3_BAR = document.getElementById("myChart"+iNumbers+"_BAR").getContext("2d");
            myLineChart3_BAR = new Chart(ctx3_BAR, config_BAR);

            
            if(myLineChart3_AMP){
                myLineChart3_AMP.destroy();
            }
            var ctx3_AMP = document.getElementById("myChart"+iNumbers+"_AMP").getContext("2d");
            myLineChart3_AMP = new Chart(ctx3_AMP, config_AMP);
        }

        if(iNumbers == 4){
            if(myLineChart4_TEMP){
                myLineChart4_TEMP.destroy();
            }
            var ctx4_TEMP = document.getElementById("myChart"+iNumbers+"_TEMP").getContext("2d");
            myLineChart4_TEMP = new Chart(ctx4_TEMP, config_TEMP);

            
            if(myLineChart4_BAR){
                myLineChart4_BAR.destroy();
            }
            var ctx4_BAR = document.getElementById("myChart"+iNumbers+"_BAR").getContext("2d");
            myLineChart4_BAR = new Chart(ctx4_BAR, config_BAR);

            
            if(myLineChart4_AMP){
                myLineChart4_AMP.destroy();
            }
            var ctx4_AMP = document.getElementById("myChart"+iNumbers+"_AMP").getContext("2d");
            myLineChart4_AMP = new Chart(ctx4_AMP, config_AMP);
        }

        if(iNumbers == 5){
            if(myLineChart5_TEMP){
                myLineChart5_TEMP.destroy();
            }
            var ctx5_TEMP = document.getElementById("myChart"+iNumbers+"_TEMP").getContext("2d");
            myLineChart5_TEMP = new Chart(ctx5_TEMP, config_TEMP);

            
            if(myLineChart5_BAR){
                myLineChart5_BAR.destroy();
            }
            var ctx5_BAR = document.getElementById("myChart"+iNumbers+"_BAR").getContext("2d");
            myLineChart5_BAR = new Chart(ctx5_BAR, config_BAR);

            
            if(myLineChart5_AMP){
                myLineChart5_AMP.destroy();
            }
            var ctx5_AMP = document.getElementById("myChart"+iNumbers+"_AMP").getContext("2d");
            myLineChart5_AMP = new Chart(ctx5_AMP, config_AMP);
        }

    }

   




</script>