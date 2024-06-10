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
                <!-- <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart7 d-flex justify-content-center" style="height: 250px" >
                    <canvas id="myChart7" style="width:100%;"></canvas>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart6 d-flex justify-content-center" style="height: 250px" >
                    <canvas id="myChart6" style="width:100%;"></canvas>
                </div> -->
                <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart1 d-flex justify-content-center" style="height: 250px" >
                    <canvas id="myChart1" style="width:100%;"></canvas>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart2 d-flex justify-content-center" style="height: 250px" >
                    <canvas id="myChart2" style="width:100%;"></canvas>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart3 d-flex justify-content-center" style="height: 250px" >
                    <canvas id="myChart3" style="width:100%;"></canvas>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart4 d-flex justify-content-center" style="height: 250px" >
                    <canvas id="myChart4" style="width:100%;"></canvas>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart5 d-flex justify-content-center" style="height: 250px" >
                    <canvas id="myChart5" style="width:100%;"></canvas>
                </div>
                <!-- <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart6 d-flex justify-content-center" style="height: 250px" >
                    <canvas id="myChart6" style="width:100%;"></canvas>
                </div> -->
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
     var myLineChart1,myLineChart2,myLineChart3,myLineChart4,myLineChart5,myLineChart6,myLineChart7;
     var config1,config2,config3,config4,config5,config6,config7;

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
            // if(i==6){
            //     fetchData(dateParam,i,'bpv');
            // } else if (i==7){
            //     fetchData(dateParam,i,'turbin');
            // } else {
            //     fetchData(dateParam,i,'pressure');
            // }
            // console.log('chart:'+i);
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
            $(".myChart"+iNumbers).append('<i class="fa fa-spin fa-spinner myChartSpinner'+iNumbers+'" style="font-size:30px; position:absolute; top:100px;z-index: 2;"></i>');
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
                    for (var i = 0; i < objHistory.length; i++) {
                        xValues1.push(objHistory[i].TM);
                        yValues1.push(objHistory[i].TEMP);
                        y1Values1.push(objHistory[i].BAR);
                        y2Values1.push(objHistory[i].AMP);
                    }
                    generateChart1(xValues1, yValues1, y1Values1, y2Values1, tdate,iNumbers);
                }

            }
        }
        });
    }
    
    function generateChart1(xValues1, yValues1, y1Values1,y2Values1, tdate,iNumbers) {

        // $(".myChart"+iNumbers).html('<canvas id="myChart'+iNumbers+'" style="width:100%;"></canvas>'); 
        $(".myChartSpinner"+iNumbers).remove();
        config1 = 
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
                    label : 'Press (BAR) ',
                    fill: false,
                    backgroundColor: "#2873d0",
                    borderColor: "#2873d0",
                    borderWidth: 2,
                    data: y1Values1,
                    yAxisID: 'y1',
                },
                {
                    label : 'Dig (AMP)',
                    fill: false,
                    backgroundColor: "rgb(75, 192, 192)",
                    borderColor: "rgb(75, 192, 192)",
                    borderWidth: 2,
                    data: y2Values1,
                    yAxisID: 'y1',
                }
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
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Temp ( \u00B0C )',
                            color: 'rgb(255, 99, 132)',
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
                    y1: {
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Tekanan & Arus',
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
                            display: false,
                        },
                    },
                },
                plugins :{
                    title: {
                        display: true,
                        text: 'Press - '+iNumbers,
                        fontSize : 14,
                    },
                    legend: {
                        display: false
                    },
                }
            }
        };

        if(iNumbers == 1){
            if(myLineChart1){
                myLineChart1.destroy();
            }
            var ctx1 = document.getElementById("myChart1").getContext("2d");
            myLineChart1 = new Chart(ctx1, config1);
        }

        if(iNumbers == 2){
            if(myLineChart2){
                myLineChart2.destroy();
            }
            var ctx2 = document.getElementById("myChart"+iNumbers).getContext("2d");
            myLineChart2 = new Chart(ctx2, config1);
        }

        if(iNumbers == 3){
            if(myLineChart3){
                myLineChart3.destroy();
            }
            var ctx3 = document.getElementById("myChart"+iNumbers).getContext("2d");
            myLineChart3 = new Chart(ctx3, config1);
        }

        if(iNumbers == 4){
            if(myLineChart4){
                myLineChart4.destroy();
            }
            var ctx4 = document.getElementById("myChart"+iNumbers).getContext("2d");
            myLineChart4 = new Chart(ctx4, config1);
        }

        if(iNumbers == 5){
            if(myLineChart5){
                myLineChart5.destroy();
            }
            var ctx5 = document.getElementById("myChart"+iNumbers).getContext("2d");
            myLineChart5 = new Chart(ctx5, config1);
        }

        if(iNumbers == 6){
            if(myLineChart6){
                myLineChart6.destroy();
            }
            var ctx6 = document.getElementById("myChart"+iNumbers).getContext("2d");
            myLineChart6 = new Chart(ctx6, config1);
        }

    }

   




</script>