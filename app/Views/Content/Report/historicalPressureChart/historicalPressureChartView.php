<style>

.switchbutton-off {
    background-color: #FF6384;
    color: #fff;
}

</style>


<div id="tb-pv" class="pb-1 pt-1">        
    <div class='col-xl-12 col-lg-12 col-md-12 row'>
        
        <div class="col row">
            <input id="dt-tdate" name="TDATE" class="easyui-datebox" style="width: 150px;"  data-options="required:true">
            &nbsp;
            <input id="sb-modeView" style="width:100px;">
        </div>
        
        <div class=" col-md-auto  text-right">
            <button id="btn-search" class="btn btn-primary" style="width: 100px;"  onclick="doSearch()"><i class="fas fa-search"></i> Search</button>
            &nbsp;
            
        </div>
    </div>

</div>

<div class="report-content">
    <div class="col-xl-12 col-lg-12 col-md-12 border-right-blue-grey border-right-lighten-5">
        <div class="my-1 text-center">
          <div class="card-content">
            
            <div class="col-xl-12 col-lg-12 col-md-12 row">
                <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart7 d-flex justify-content-center" style="height: 250px" >
                    <canvas id="myChart7" style="width:100%;"></canvas>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 myChartDiv myChart6 d-flex justify-content-center" style="height: 250px" >
                    <canvas id="myChart6" style="width:100%;"></canvas>
                </div>
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
        
        for(i=1;i<8;i++){
            if(i==6){
                fetchData(dateParam,i,'bpv');
            } else if (i==7){
                fetchData(dateParam,i,'turbin');
            } else {
                fetchData(dateParam,i,'pressure');
            }
            
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

        DIVID_New = iNumbers;

        if(iNumbers >=1 & iNumbers <=5){
            DIVID_New = iNumbers +130;
        }

        $.ajax({
        url:"<?php echo site_url().'/../Content/Report/historicalPressureChart/'; ?>"+functionData,
        type: 'post',
        data : {
            TDATE : tdate,
            DIVID : DIVID_New,
        },
        beforeSend: function (){
            $(".myChart"+iNumbers).append('<i class="fa fa-spin fa-spinner myChartSpinner'+iNumbers+'" style="font-size:30px; position:absolute; top:100px;z-index: 2;"></i>');
        },
        success: function(response) {
            if (response.length < 1) {
                alert("Data Kosong Hubungi Administrator");
            } else {
                objHistory = JSON.parse(response);
                if(iNumbers==1){
                    var xValues1 = [];
                    var yValues1 = [];
                    for (var i = 0; i < objHistory.length; i++) {
                        xValues1.push(objHistory[i].TM);
                        yValues1.push(objHistory[i].MBARG);
                    }
                    generateChart1(xValues1, yValues1, tdate,iNumbers);
                }

                if(iNumbers==2){
                    var xValues2 = [];
                    var yValues2 = [];
                    for (var i = 0; i < objHistory.length; i++) {
                        xValues2.push(objHistory[i].TM);
                        yValues2.push(objHistory[i].MBARG);
                    }
                    generateChart2(xValues2, yValues2, tdate,iNumbers);
                }

                if(iNumbers==3){
                    var xValues3 = [];
                    var yValues3 = [];
                    for (var i = 0; i < objHistory.length; i++) {
                        xValues3.push(objHistory[i].TM);
                        yValues3.push(objHistory[i].MBARG);
                    }
                    generateChart3(xValues3, yValues3, tdate,iNumbers);
                }

                if(iNumbers==4){
                    var xValues4 = [];
                    var yValues4 = [];
                    for (var i = 0; i < objHistory.length; i++) {
                        xValues4.push(objHistory[i].TM);
                        yValues4.push(objHistory[i].MBARG);
                    }
                    generateChart4(xValues4, yValues4, tdate,iNumbers);
                }

                if(iNumbers==5){
                    var xValues5 = [];
                    var yValues5 = [];
                    for (var i = 0; i < objHistory.length; i++) {
                        xValues5.push(objHistory[i].TM);
                        yValues5.push(objHistory[i].MBARG);
                    }
                    generateChart5(xValues5, yValues5, tdate,iNumbers);
                }

                if(iNumbers==6){
                    var xValues6 = [];
                    var yValues6 = [];
                    for (var i = 0; i < objHistory.length; i++) {
                        xValues6.push(objHistory[i].TM);
                        yValues6.push(objHistory[i].MBARG);
                    }
                    generateChart6(xValues6, yValues6, tdate,iNumbers);
                }

                if(iNumbers==7){
                    var xValues7 = [];
                    var yValues7 = [];
                    for (var i = 0; i < objHistory.length; i++) {
                        xValues7.push(objHistory[i].TM);
                        yValues7.push(objHistory[i].MBARG);
                    }
                    generateChart7(xValues7, yValues7, tdate,iNumbers);
                }
            }
        }
        });
    }
    
    function generateChart1(xValues1, yValues1, tdate,iNumbers) {

        // $(".myChart"+iNumbers).html('<canvas id="myChart'+iNumbers+'" style="width:100%;"></canvas>'); 
        $(".myChartSpinner"+iNumbers).remove();
        config1 = 
        {
            type: "line",
            data: {
                labels: xValues1,
                datasets: [{
                    label : '',
                    fill: false,
                    backgroundColor: "#2873d0",
                    borderColor: "#2873d0",
                    borderWidth: 2,
                    data: yValues1
                }]
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
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Pressure(mBarg)',
                            color: '#2873d0',
                            font: {
                                // family: 'Comic Sans MS',
                                // size: 20,
                                // weight: 'bold',
                                // lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        }
                    },
                },
                plugins :{
                    title: {
                        display: true,
                        text: 'Historical Pressure Sterilizer '+iNumbers+' Graphic : '+tdate,
                        fontSize : 14,
                    },
                    legend: {
                        display: false
                    },
                }
            }
        };
        if(myLineChart1){
            myLineChart1.destroy();
        }
        var ctx1 = document.getElementById("myChart1").getContext("2d");
        myLineChart1 = new Chart(ctx1, config1);
    }

    function generateChart2(xValues2, yValues2, tdate,iNumbers) {
        // $(".myChart"+iNumbers).html('<canvas id="myChart'+iNumbers+'" style="width:100%;"></canvas>'); 
        $(".myChartSpinner"+iNumbers).remove();

        config2 = 
        {
            type: "line",
            data: {
                labels: xValues2,
                datasets: [{
                fill: false,
                backgroundColor: "#2873d0",
                borderColor: "#2873d0",
                borderWidth: 2,
                data: yValues2
                }]
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
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Pressure(mBarg)',
                            color: '#2873d0',
                            font: {
                                // family: 'Comic Sans MS',
                                // size: 20,
                                // weight: 'bold',
                                // lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        }
                    },
                },
                plugins :{
                    title: {
                        display: true,
                        text: 'Historical Pressure Sterilizer '+iNumbers+' Graphic : '+tdate,
                        fontSize : 14,
                    },
                    legend: {
                        display: false
                    },
                }
            }
        };
        if(myLineChart2){
            myLineChart2.destroy();
        }
        var ctx2 = document.getElementById("myChart2").getContext("2d");
        myLineChart2 = new Chart(ctx2, config2);
    }

    function generateChart3(xValues3, yValues3, tdate,iNumbers) {
        // $(".myChart"+iNumbers).html('<canvas id="myChart'+iNumbers+'" style="width:100%;"></canvas>'); 
        $(".myChartSpinner"+iNumbers).remove();

        config3 = 
        {
            type: "line",
            data: {
                labels: xValues3,
                datasets: [{
                fill: false,
                backgroundColor: "#2873d0",
                borderColor: "#2873d0",
                borderWidth: 2,
                data: yValues3
                }]
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
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Pressure(mBarg)',
                            color: '#2873d0',
                            font: {
                                // family: 'Comic Sans MS',
                                // size: 20,
                                // weight: 'bold',
                                // lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        }
                    },
                },
                plugins :{
                    title: {
                        display: true,
                        text: 'Historical Pressure Sterilizer '+iNumbers+' Graphic : '+tdate,
                        fontSize : 14,
                    },
                    legend: {
                        display: false
                    },
                }
            }
        };
        if(myLineChart3){
            myLineChart3.destroy();
        }
        var ctx3 = document.getElementById("myChart3").getContext("2d");
        myLineChart3 = new Chart(ctx3, config3);
    }

    function generateChart4(xValues4, yValues4, tdate,iNumbers) {
        // $(".myChart"+iNumbers).html('<canvas id="myChart'+iNumbers+'" style="width:100%;"></canvas>'); 
        $(".myChartSpinner"+iNumbers).remove();

        config4 = 
        {
            type: "line",
            data: {
                labels: xValues4,
                datasets: [{
                fill: false,
                backgroundColor: "#2873d0",
                borderColor: "#2873d0",
                borderWidth: 2,
                data: yValues4
                }]
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
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Pressure(mBarg)',
                            color: '#2873d0',
                            font: {
                                // family: 'Comic Sans MS',
                                // size: 20,
                                // weight: 'bold',
                                // lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        }
                    },
                },
                plugins :{
                    title: {
                        display: true,
                        text: 'Historical Pressure Sterilizer '+iNumbers+' Graphic : '+tdate,
                        fontSize : 14,
                    },
                    legend: {
                        display: false
                    },
                }
            }
        };
        if(myLineChart4){
            myLineChart4.destroy();
        }
        var ctx4 = document.getElementById("myChart4").getContext("2d");
        myLineChart4 = new Chart(ctx4, config4);
    }

    function generateChart5(xValues5, yValues5, tdate,iNumbers) {
        // $(".myChart"+iNumbers).html('<canvas id="myChart'+iNumbers+'" style="width:100%;"></canvas>'); 
        $(".myChartSpinner"+iNumbers).remove();

        config5 = 
        {
            type: "line",
            data: {
                labels: xValues5,
                datasets: [{
                fill: false,
                backgroundColor: "#2873d0",
                borderColor: "#2873d0",
                borderWidth: 2,
                data: yValues5
                }]
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
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Pressure(mBarg)',
                            color: '#2873d0',
                            font: {
                                // family: 'Comic Sans MS',
                                // size: 20,
                                // weight: 'bold',
                                // lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        }
                    },
                },
                plugins :{
                    title: {
                        display: true,
                        text: 'Historical Pressure Sterilizer '+iNumbers+' Graphic : '+tdate,
                        fontSize : 14,
                    },
                    legend: {
                        display: false
                    },
                }
            }
        };
        if(myLineChart5){
            myLineChart5.destroy();
        }
        var ctx5 = document.getElementById("myChart5").getContext("2d");
        myLineChart5 = new Chart(ctx5, config5);
    }

    function generateChart6(xValues6, yValues6, tdate,iNumbers) {
        // $(".myChart"+iNumbers).html('<canvas id="myChart'+iNumbers+'" style="width:100%;"></canvas>'); 
        $(".myChartSpinner"+iNumbers).remove();

        config6 = 
        {
            type: "line",
            data: {
                labels: xValues6,
                datasets: [{
                fill: false,
                backgroundColor: "#2873d0",
                borderColor: "#2873d0",
                borderWidth: 2,
                data: yValues6
                }]
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
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Pressure(Bar)',
                            color: '#2873d0',
                            font: {
                                // family: 'Comic Sans MS',
                                // size: 20,
                                // weight: 'bold',
                                // lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        }
                    },
                },
                plugins :{
                    title: {
                        display: true,
                        text: 'Historical BPV Graphic : '+tdate,
                        fontSize : 14,
                    },
                    legend: {
                        display: false
                    },
                }
            }
        };
        if(myLineChart6){
            myLineChart6.destroy();
        }
        var ctx6 = document.getElementById("myChart6").getContext("2d");
        myLineChart6 = new Chart(ctx6, config6);
    }

function generateChart7(xValues7, yValues7, tdate,iNumbers) {
    // $(".myChart"+iNumbers).html('<canvas id="myChart'+iNumbers+'" style="width:100%;"></canvas>'); 
    $(".myChartSpinner"+iNumbers).remove();

    config7 = 
    {
        type: "line",
        data: {
            labels: xValues7,
            datasets: [{
            fill: false,
            backgroundColor: "#2873d0",
            borderColor: "#2873d0",
            borderWidth: 2,
            data: yValues7
            }]
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
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Pressure(Bar)',
                            color: '#2873d0',
                            font: {
                                // family: 'Comic Sans MS',
                                // size: 20,
                                // weight: 'bold',
                                // lineHeight: 1.2,
                            },
                            // padding: {top: 20, left: 0, right: 0, bottom: 0}
                        }
                    },
                },
            plugins :{
                title: {
                    display: true,
                    text: 'Historical Turbin Graphic : '+tdate,
                    fontSize : 14,
                },
                legend: {
                    display: false
                },
            }
        }
    };
    if(myLineChart7){
        myLineChart7.destroy();
    }
    var ctx7 = document.getElementById("myChart7").getContext("2d");
    myLineChart7 = new Chart(ctx7, config7);
}




</script>