<html>
    <head>
    <!-- <script type="text/javascript" src="https://sites.local/dev_SCMS//public/vendors/jquery/jquery-3.4.1.js?r=1684484292"></script>
    <script type="text/javascript" src="https://sites.local/dev_SCMS/public/vendors/chartJs/2.9.4/Chart.js?r=1684484292"></script> -->
    <script type="text/javascript" src="<?= site_url().'/../public/vendors/jquery/jquery-3.4.1.js' ?>" ></script>
    <script type="text/javascript" src="<?= site_url().'/../public/vendors/chartJs/2.9.4/Chart.js' ?>"></script>
    <script type="text/javascript" src="<?= site_url().'/../public/vendors/html2canvas/html2canvas.min.js' ?>"></script>
    </head>
    <body>
    <div class="report-content">
    <div class="text-center">
        <h1>Press Station</h1>
        <p class="lead">Temperatur Digester</p>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 border-right-blue-grey border-right-lighten-5">
        <div class="my-1 text-center">
          <div class="card-content">
            <!-- <h5 class="" style="color: #FF6384;">Temperature</h5> -->
            <canvas id="myChart2" style="width:100%; height:300px;"></canvas>

            <button onclick="screenshoot()">Take Screenshoot</button>
            <button id="download" onclick="download()">Download Pdf</button>

          </div>
        </div>
      </div>


<script>

  $(document).ready(function() {
    fetchData()
  });

  function download(){
    html2canvas(document.querySelector("#myChart2")).then(canvas => {
      document.body.appendChild(canvas)
    });
  }

  function screenshoot(){
    html2canvas(document.querySelector("#myChart2")).then(canvas => {
      document.body.appendChild(canvas)
    });
  }

function fetchData() {
    $.ajax({
      url:"<?php echo site_url().'/../Content/Report/pressGraph/getData'; ?>",
      type: 'post',
      success: function(response) {
        if (response.length < 1) {
          alert("Data Kosong Hubungi Administrator");
        } else {
          objHistory = JSON.parse(response);
          var xValues = [];
          var yValues = [];

          for (var i = 0; i < objHistory.length; i++) {
            xValues.push(objHistory[i].PRSHR );
            yValues.push(objHistory[i].PRSDG_TMP1);
          }

          generateChart(xValues, yValues);
          
          // screenshoot();
        }
      }
    });
  }

  
  function generateChart(xValues, yValues) {
    var canvar_bar = document.getElementById("myChart2");
    new Chart(canvar_bar, {
      type: "line",
      data: {
        labels: xValues,
        datasets: [{
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
        animation: false,
      }
    });

    // dataURL3 = canvar_bar.toDataURL('image/png');

    // return dataURL3;

  }

</script>
    </body>
</html>