<?php 
    use \koolreport\widgets\koolphp\Table;
    use \koolreport\widgets\google\BarChart;
    use \koolreport\widgets\google\LineChart;
?>
<div id="tb-pv" class="pb-1 pt-1">        
    <div class='col-xl-12 col-lg-12 col-md-12 row'>
        
        <div class="col row">
            <button id="btn-searchReset" class="btn btn-warning" style="width: 100px;"  onclick="exportDataPDF()"><i class="fas fa-print"></i> Print</button>
            &nbsp;
            <button id="btn-searchReset" class="btn btn-warning" style="width: 100px;"  onclick="test()"><i class="fas fa-print"></i> Test</button>
        </div>
        
        <div class=" col-md-auto  text-right">
            <button id="btn-search" class="btn btn-primary" style="width: 100px;"  onclick="koolreportView()"><i class="fas fa-chart-line"></i> koolreport</button>
            &nbsp;
            <button id="btn-searchReset" class="btn btn-danger" style="width: 100px;"  onclick="chartJSView()"><i class="fas fa-chart-line"></i> chartJS</button>
            &nbsp;
            <button id="btn-searchReset" class="btn btn-info" style="width: 120px;"  onclick="chartJSView430()"><i class="fas fa-chart-line"></i> chartJS 4.3.0</button>
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

function chartJSView430(){

    url = "<?php echo site_url().'/../Content/Report/pressGraph/chartJSView430'; ?>" ;
    window.open(url,"_self");
    
}
</script>


<div class="report-content">
    <div class="text-center">
        <h1>Press Station (Test)</h1>
        <p class="lead">Temperatur Digester</p>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 border-right-blue-grey border-right-lighten-5">
        <div class="my-1 text-center">
          <div class="card-content">
            <!-- <h5 class="" style="color: #FF6384;">Temperature</h5> -->
            <canvas id="myChart2" style="width:100%; height:300px;"></canvas>

          </div>

            <div>
                <canvas id="myChart" style="width:100%; height:300px;"></canvas>
            </div>
        </div>
      </div>


<script>

  $(document).ready(function() {
    fetchData();
  });

function fetchData() {
    $.ajax({
      url:"<?php echo site_url().'/../Content/Report/pressGraph/getData'; ?>",
      type: 'post',
      success: function(response) {
        // Perform operation on the return value
        //    alert(response);
        // alert(response.length)
        if (response.length < 1) {
          alert("Data Kosong Hubungi Administrator");
        } else {
          // var result = response.substring(response.lastIndexOf("{"), response.lastIndexOf("}") + 1);
          objHistory = JSON.parse(response);
          // objHistory2 = JSON.parse(response);
          // $("#datahistory").html(objHistory[1].FTU_VAL + " - " + objHistory[1].SVRTM + " - " + objHistory.length);
          // $("#datahistory").html(response);
          // $("#datahistory").html(result);
          var xValues = [];
          var yValues = [];

          for (var i = 0; i < objHistory.length; i++) {
            xValues.push(objHistory[i].PRSHR );
            yValues.push(objHistory[i].PRSDG_TMP1);
          }
          // $("#datahistory").html(objHistory.length);

          generateChart(xValues, yValues);
        }
      }
    });
  }

  
  function generateChart(xValues, yValues) {
    var canvar_bar = document.getElementById("myChart2").getContext('2d');
    var myChart = new Chart(canvar_bar, {
      type: "line",
      data: {
        labels: xValues,
        datasets: [{
            label : 'Suhu',
          fill: false,
          backgroundColor: "#FF6384",
          borderColor: "#FF6384",
          data: yValues
        }]
      },
      options: {
        legend: {
          display: false
        },
        elements: {
                    point:{
                        radius: 0
                    }
                },
        scales: {
        //   yAxes: [{ticks: {min: 6, max:16}}],
        // xAxes: [{ticks: {display: false}}],
        },
        // animation: false,
        animations: {
            tension: {
                duration: 1000,
                easing: 'linear',
                from: 0,
                to: 1,
                loop: true
            }
        },
        transitions: {
            show: {
                animations: {
                x: {
                    from: 0
                },
                y: {
                    from: 0
                }
                }
            },
            hide: {
                animations: {
                x: {
                    to: 0
                },
                y: {
                    to: 0
                }
                }
            }
        }
      }
    });

  }

  function exportDataPDF() {
        
        var url = "<?php  echo site_url() . '/../Content/Report/pressGraph/exportPDFFile'; ?>";
        window.open(url, "_blank");
    }

    function test() {
        
        var url = "<?php  echo site_url() . '/../Content/Report/pressGraph/pdfView_test'; ?>";
        window.open(url, "_blank");
    }
</script>
   

<script>
  const ctx2 = document.getElementById('myChart').getContext('2d');

  new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
    
</div>