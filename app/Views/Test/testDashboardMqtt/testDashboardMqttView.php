<style>
    /* bawaan bang hari */
    /* #container {
        width: 50px;
        height: 300px;
        line-height: 300px;
        margin-left: 10px;
        border: 2px solid black;

    } */
</style>
<div class="card ">
<!-- <div class="card"> -->
<div class="card-body text-center" style="background-color: rgb(255, 99, 132, 0.5);">
    <h3 class="card-title" style="color: black;">PRESSURE STATION REALTIME DATA</h3>
</div>
<!-- </div> -->

<div id="alertDiv" class="alert alert-warning"  role="alert" style="display:none;" >
   <a id="textAlertDiv">xxx</a>
</div>

<div class="row col-12 mt-3">
    <?php

    for ($i = 1; $i < 7; $i++) {

        echo '
        <div class=" col-xl-3 col-lg-3 col-md-3 col-sm-12 pr-0 pl-1">
            <div class="card">
                <div class="card-header text-center" style="padding: 10px 10px 10px 10px;">
                    <h4> PRESSURE ' . $i . ' </h4>
                </div>
                <div class="card-body" style="padding: 10px 10px 10px 10px;">
                    <div class="col-xl-12 col-lg-12 col-md-12 ">
                        <div class="text-center">

                            <div class="col-xl-12 col-lg-12 col-md-12 text-center " >
                                <div class="text-center"  style="color: #FF6384;">
                                    <h5>TEMP &deg; C</h5>
                                </div>
                                <div class="d-flex justify-content-center" style="height:200px;">
                                    <canvas id="chartDataPRSTMPDIG' . $i . '" style="width:100%;max-width:600px"></canvas>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-12  text-center">
                                    <h2 id="dataPRSPSSSCP' . $i . '" class="font-weight-bold"></h2>
                                    <span class="" style="color: #00B5B8;">
                                        <span class="ft-arrow-down"></span> <b>Press (BAR)</b></span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12  text-center">
                                    <h2 id="dataPRSAMPDIG' . $i . '" class="font-weight-bold"></h2>
                                    <span class="" style="color: #FF6384;">
                                        <span class="ft-arrow-up"></span> <b>Dig (AMP)</b></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    ';
    }
    ?>

</div>
</div>

<script>
    var myChart_1, myChart_2, myChart_3, myChart_4, myChart_5, myChart_6;
    var dataExist_1, dataExist_2, dataExist_3, dataExist_4, dataExist_5, dataExist_6;

    function generateDataPRSTMPDIG1(dataPRSTMPDIG1) {

        var dougnutLabel_1 = {
            id: 'dougnutLabel_1',
            afterDatasetsDraw(chart, args, pluginOptions) {

                var {
                    ctx,
                    data
                } = chart;

                ctx_1.save();
                var xCoor_1 = chart.getDatasetMeta(0).data[0].x;
                var yCoor_1 = chart.getDatasetMeta(0).data[0].y;

                var textLabel_1 = data.datasets[0].data[0];

                ctx_1.font = 'bold 26px sans-serif';
                ctx_1.fillStyle = 'rgba(54,162, 235,1)';
                ctx_1.textAlign = 'center';
                ctx_1.textBaseLine = 'middle';
                ctx_1.fillText(textLabel_1, xCoor_1, yCoor_1);
            },
        }

        var config_1 = {
            type: "doughnut",
            data: {
                // labels: [parseFloat(dataPRSTMPDIG1), 100 - parseFloat(dataPRSTMPDIG1).toFixed(2)],
                datasets: [{
                    backgroundColor: ["#FF6384", "#6c757d"],
                    data: [parseFloat(dataPRSTMPDIG1), 100 - parseFloat(dataPRSTMPDIG1).toFixed(2)]
                }]
            },
            options: {
                // plugins:{
                //     title: {
                //         display: false,
                //         text: "ini title text"
                //     },
                //     legend: {
                //         display: false,
                //         text: "ini legend text"
                //     },
                // }

                // animation: true,
            },
            plugins: [dougnutLabel_1]
        };

        var ctx_1 = document.getElementById("chartDataPRSTMPDIG1").getContext("2d");


        if (myChart_1 == null) {
            myChart_1 = new Chart(ctx_1, config_1);
            dataExist_1 = parseFloat(dataPRSTMPDIG1);

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log('status myChart_1 = baru / ' + dataExist_1);
        } else {

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log(parseFloat(dataExist_1) + ' / ' + parseFloat(dataPRSTMPDIG1));

            if (dataExist_1 != parseFloat(dataPRSTMPDIG1)) {
                myChart_1.destroy();
                myChart_1 = new Chart(ctx_1, config_1);

                dataExist_1 = parseFloat(dataPRSTMPDIG1);
            }

        }

    }

    function generateDataPRSTMPDIG2(dataPRSTMPDIG2) {

        var dougnutLabel_2 = {
            id: 'dougnutLabel_2',
            afterDatasetsDraw(chart, args, pluginOptions) {

                var {
                    ctx,
                    data
                } = chart;

                ctx_2.save();
                var xCoor_2 = chart.getDatasetMeta(0).data[0].x;
                var yCoor_2 = chart.getDatasetMeta(0).data[0].y;

                var textLabel_2 = data.datasets[0].data[0];

                ctx_2.font = 'bold 26px sans-serif';
                ctx_2.fillStyle = 'rgba(54,162, 235,1)';
                ctx_2.textAlign = 'center';
                ctx_2.textBaseLine = 'middle';
                ctx_2.fillText(textLabel_2, xCoor_2, yCoor_2);
            },
        }

        var config_2 = {
            type: "doughnut",
            data: {
                // labels: [parseFloat(dataPRSTMPDIG2), 100 - parseFloat(dataPRSTMPDIG2).toFixed(2)],
                datasets: [{
                    backgroundColor: ["#FF6384", "#6c757d"],
                    data: [parseFloat(dataPRSTMPDIG2), 100 - parseFloat(dataPRSTMPDIG2).toFixed(2)]
                }]
            },
            options: {

            },
            plugins: [dougnutLabel_2]
        };

        var ctx_2 = document.getElementById("chartDataPRSTMPDIG2").getContext("2d");


        if (myChart_2 == null) {
            myChart_2 = new Chart(ctx_2, config_2);
            dataExist_2 = parseFloat(dataPRSTMPDIG2);

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log('status myChart_2 = baru / ' + dataExist_2);
        } else {

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log(parseFloat(dataExist_2) + ' / ' + parseFloat(dataPRSTMPDIG2));

            if (dataExist_2 != parseFloat(dataPRSTMPDIG2)) {
                myChart_2.destroy();
                myChart_2 = new Chart(ctx_2, config_2);

                dataExist_2 = parseFloat(dataPRSTMPDIG2);
            }

        }

    }

    function generateDataPRSTMPDIG3(dataPRSTMPDIG3) {

        var dougnutLabel_3 = {
            id: 'dougnutLabel_3',
            afterDatasetsDraw(chart, args, pluginOptions) {

                var {
                    ctx,
                    data
                } = chart;

                ctx_3.save();
                var xCoor_3 = chart.getDatasetMeta(0).data[0].x;
                var yCoor_3 = chart.getDatasetMeta(0).data[0].y;

                var textLabel_3 = data.datasets[0].data[0];

                ctx_3.font = 'bold 26px sans-serif';
                ctx_3.fillStyle = 'rgba(54,162, 235,1)';
                ctx_3.textAlign = 'center';
                ctx_3.textBaseLine = 'middle';
                ctx_3.fillText(textLabel_3, xCoor_3, yCoor_3);
            },
        }

        var config_3 = {
            type: "doughnut",
            data: {
                // labels: [parseFloat(dataPRSTMPDIG3), 100 - parseFloat(dataPRSTMPDIG3).toFixed(2)],
                datasets: [{
                    backgroundColor: ["#FF6384", "#6c757d"],
                    data: [parseFloat(dataPRSTMPDIG3), 100 - parseFloat(dataPRSTMPDIG3).toFixed(2)]
                }]
            },
            options: {

            },
            plugins: [dougnutLabel_3]
        };

        var ctx_3 = document.getElementById("chartDataPRSTMPDIG3").getContext("2d");


        if (myChart_3 == null) {
            myChart_3 = new Chart(ctx_3, config_3);
            dataExist_3 = parseFloat(dataPRSTMPDIG3);

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log('status myChart_3 = baru / ' + dataExist_3);
        } else {

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log(parseFloat(dataExist_3) + ' / ' + parseFloat(dataPRSTMPDIG3));

            if (dataExist_3 != parseFloat(dataPRSTMPDIG3)) {
                myChart_3.destroy();
                myChart_3 = new Chart(ctx_3, config_3);

                dataExist_3 = parseFloat(dataPRSTMPDIG3);
            }

        }

    }

    function generateDataPRSTMPDIG4(dataPRSTMPDIG4) {

        var dougnutLabel_4 = {
            id: 'dougnutLabel_4',
            afterDatasetsDraw(chart, args, pluginOptions) {

                var {
                    ctx,
                    data
                } = chart;

                ctx_4.save();
                var xCoor_4 = chart.getDatasetMeta(0).data[0].x;
                var yCoor_4 = chart.getDatasetMeta(0).data[0].y;

                var textLabel_4 = data.datasets[0].data[0];

                ctx_4.font = 'bold 26px sans-serif';
                ctx_4.fillStyle = 'rgba(54,162, 235,1)';
                ctx_4.textAlign = 'center';
                ctx_4.textBaseLine = 'middle';
                ctx_4.fillText(textLabel_4, xCoor_4, yCoor_4);
            },
        }

        var config_4 = {
            type: "doughnut",
            data: {
                // labels: [parseFloat(dataPRSTMPDIG4), 100 - parseFloat(dataPRSTMPDIG4).toFixed(2)],
                datasets: [{
                    backgroundColor: ["#FF6384", "#6c757d"],
                    data: [parseFloat(dataPRSTMPDIG4), 100 - parseFloat(dataPRSTMPDIG4).toFixed(2)]
                }]
            },
            options: {

            },
            plugins: [dougnutLabel_4]
        };

        var ctx_4 = document.getElementById("chartDataPRSTMPDIG4").getContext("2d");


        if (myChart_4 == null) {
            myChart_4 = new Chart(ctx_4, config_4);
            dataExist_4 = parseFloat(dataPRSTMPDIG4);

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log('status myChart_4 = baru / ' + dataExist_4);
        } else {

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log(parseFloat(dataExist_4) + ' / ' + parseFloat(dataPRSTMPDIG4));

            if (dataExist_4 != parseFloat(dataPRSTMPDIG4)) {
                myChart_4.destroy();
                myChart_4 = new Chart(ctx_4, config_4);

                dataExist_4 = parseFloat(dataPRSTMPDIG4);
            }

        }

    }

    function generateDataPRSTMPDIG5(dataPRSTMPDIG5) {

        var dougnutLabel_5 = {
            id: 'dougnutLabel_5',
            afterDatasetsDraw(chart, args, pluginOptions) {

                var {
                    ctx,
                    data
                } = chart;

                ctx_5.save();
                var xCoor_5 = chart.getDatasetMeta(0).data[0].x;
                var yCoor_5 = chart.getDatasetMeta(0).data[0].y;

                var textLabel_5 = data.datasets[0].data[0];

                ctx_5.font = 'bold 26px sans-serif';
                ctx_5.fillStyle = 'rgba(54,162, 235,1)';
                ctx_5.textAlign = 'center';
                ctx_5.textBaseLine = 'middle';
                ctx_5.fillText(textLabel_5, xCoor_5, yCoor_5);
            },
        }

        var config_5 = {
            type: "doughnut",
            data: {
                // labels: [parseFloat(dataPRSTMPDIG5), 100 - parseFloat(dataPRSTMPDIG5).toFixed(2)],
                datasets: [{
                    backgroundColor: ["#FF6384", "#6c757d"],
                    data: [parseFloat(dataPRSTMPDIG5), 100 - parseFloat(dataPRSTMPDIG5).toFixed(2)]
                }]
            },
            options: {

            },
            plugins: [dougnutLabel_5]
        };

        var ctx_5 = document.getElementById("chartDataPRSTMPDIG5").getContext("2d");


        if (myChart_5 == null) {
            myChart_5 = new Chart(ctx_5, config_5);
            dataExist_5 = parseFloat(dataPRSTMPDIG5);

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log('status myChart_5 = baru / ' + dataExist_5);
        } else {

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log(parseFloat(dataExist_5) + ' / ' + parseFloat(dataPRSTMPDIG5));

            if (dataExist_5 != parseFloat(dataPRSTMPDIG5)) {
                myChart_5.destroy();
                myChart_5 = new Chart(ctx_5, config_5);

                dataExist_5 = parseFloat(dataPRSTMPDIG5);
            }

        }

    }

    function generateDataPRSTMPDIG6(dataPRSTMPDIG6) {

        var dougnutLabel_6 = {
            id: 'dougnutLabel_6',
            afterDatasetsDraw(chart, args, pluginOptions) {

                var {
                    ctx,
                    data
                } = chart;

                ctx_6.save();
                var xCoor_6 = chart.getDatasetMeta(0).data[0].x;
                var yCoor_6 = chart.getDatasetMeta(0).data[0].y;

                var textLabel_6 = data.datasets[0].data[0];

                ctx_6.font = 'bold 26px sans-serif';
                ctx_6.fillStyle = 'rgba(54,162, 235,1)';
                ctx_6.textAlign = 'center';
                ctx_6.textBaseLine = 'middle';
                ctx_6.fillText(textLabel_6, xCoor_6, yCoor_6);
            },
        }

        var config_6 = {
            type: "doughnut",
            data: {
                // labels: [parseFloat(dataPRSTMPDIG6), 100 - parseFloat(dataPRSTMPDIG6).toFixed(2)],
                datasets: [{
                    backgroundColor: ["#FF6384", "#6c757d"],
                    data: [parseFloat(dataPRSTMPDIG6), 100 - parseFloat(dataPRSTMPDIG6).toFixed(2)]
                }]
            },
            options: {

            },
            plugins: [dougnutLabel_6]
        };

        var ctx_6 = document.getElementById("chartDataPRSTMPDIG6").getContext("2d");


        if (myChart_6 == null) {
            myChart_6 = new Chart(ctx_6, config_6);
            dataExist_6 = parseFloat(dataPRSTMPDIG6);

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log('status myChart_6 = baru / ' + dataExist_6);
        } else {

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log(parseFloat(dataExist_6) + ' / ' + parseFloat(dataPRSTMPDIG6));

            if (dataExist_6 != parseFloat(dataPRSTMPDIG6)) {
                myChart_6.destroy();
                myChart_6 = new Chart(ctx_6, config_6);

                dataExist_6 = parseFloat(dataPRSTMPDIG6);
            }

        }

    }
</script>
<!-- 
<h3>SMA-MQTT2WEBSOCKET</h3>
<h3>HOST: <a href='DevWebSocket.html'>
        <script>
            document.write("<?= $hostname_mqtt ?>");
        </script>
    </a></h3>
<h3>PORT: <a href='DevWebSocket.html'>
        <script>
            document.write(<?= $port_mqtt ?>);
        </script>
    </a></h3>
<h3>ID CLIENT: <a href='DevWebSocket.html'>
        <script>
            document.write("<?= $clientID_mqtt ?>");
        </script>
    </a></h3>
<h3>TOPIC: <a href='DevWebSocket.html'>
        <script>
            document.write("<?= $topic_mqtt_PRSTMPDIG1 ?>");
        </script>
    </a></h3>
<h3>RANGE PUBLIS DATA 0 - 100</h3>
<p>Temperature</p>
<div id="container">
    <div id="top" style="width: 100%; background-color:white;text-align:center;"></div>
</div> -->


<script>
    $(document).ready(function() {
        // generateDataPRSTMPDIG1(70);

        mqttClient = new Paho.MQTT.Client("<?= $hostname_mqtt ?>", <?= $port_mqtt ?>, "<?= $clientID_mqtt ?>");

        Connect();

        mqttClient.onMessageArrived = MessageArrived;
        mqttClient.onConnectionLost = ConnectionLost;

    });

    /*Initiates a connection to the MQTT broker*/
    function Connect() {
        mqttClient.connect({
            onSuccess: Connected,
            onFailure: ConnectionFailed,
            keepAliveInterval: 10,
            reconnect: true
        });
    }

    /*Callback for successful MQTT connection */
    function Connected() {

        // dimatikan agar tidak memenuhi console (nyalakan bila diperlukan)
        // console.log("Connected to broker");

        $("#alertDiv").hide();

        // var messageUnion = [
        mqttClient.subscribe("<?= $topic_mqtt_PRSTMPDIG1 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSPSSSCP1 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSAMPDIG1 ?>");

        mqttClient.subscribe("<?= $topic_mqtt_PRSTMPDIG2 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSPSSSCP2 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSAMPDIG2 ?>");

        mqttClient.subscribe("<?= $topic_mqtt_PRSTMPDIG3 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSPSSSCP3 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSAMPDIG3 ?>");

        mqttClient.subscribe("<?= $topic_mqtt_PRSTMPDIG4 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSPSSSCP4 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSAMPDIG4 ?>");

        mqttClient.subscribe("<?= $topic_mqtt_PRSTMPDIG5 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSPSSSCP5 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSAMPDIG5 ?>");

        mqttClient.subscribe("<?= $topic_mqtt_PRSTMPDIG6 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSPSSSCP6 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSAMPDIG6 ?>");
        // ];
    }

    /*Callback for failed connection*/
    function ConnectionFailed(res) {
        
        $("#textAlertDiv").html('Connection Failed, Please Check Your Connection and <a href="" class="alert-link">Refresh Page</a> !');
        $("#alertDiv").show();

        // dimatikan agar tidak memenuhi console (nyalakan bila diperlukan)
        // console.log("Connect failed:" + res.errorMessage);

    }

    /*Callback for lost connection*/
    function ConnectionLost(res) {
        if (res.errorCode !== 0) {
            $("#textAlertDiv").html('Connection Lost, Please Wait for Reconnect or Try <a href="" class="alert-link">Refresh Page</a> !');
            $("#alertDiv").show();

            // dimatikan agar tidak memenuhi console (nyalakan bila diperlukan)
            // console.log("Connection lost:" + res.errorMessage);
            
            Connect();
        }
    }

    /*Callback for incoming message processing */
    function MessageArrived(message) {

        // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
        // console.log(message.destinationName + " : " + message.payloadString);


        if (message.destinationName == "<?= $topic_mqtt_PRSTMPDIG1 ?>") {

            generateDataPRSTMPDIG1(message.payloadString);

            // bawaan bang hari
            // var a = parseInt(message.payloadString);
            // var ht = 100 - a;
            // document.getElementById("top").style.height = "" + ht + "%";
            // document.getElementById("top").innerHTML = message.payloadString + "&#176" + "C";
            // document.getElementById("container").style.backgroundColor = "yellow";
            // switch (message.payloadString) {
            //     case "ON":
            //         displayClass = "on";
            //         break;
            //     case "OFF":
            //         displayClass = "off";
            //         break;
            //     default:
            //         displayClass = "unknown";
            // }
            // var topic = message.destinationName.split("/");
            // if (topic.length == 3) {
            //     var ioname = topic[1];
            //     UpdateElement(ioname, displayClass);
            // }
            // batas bawaan bang hari
        }

        if (message.destinationName == "<?= $topic_mqtt_PRSTMPDIG2 ?>") {

            generateDataPRSTMPDIG2(message.payloadString);
        }

        if (message.destinationName == "<?= $topic_mqtt_PRSTMPDIG3 ?>") {

            generateDataPRSTMPDIG3(message.payloadString);
        }

        if (message.destinationName == "<?= $topic_mqtt_PRSTMPDIG4 ?>") {

            generateDataPRSTMPDIG4(message.payloadString);
        }

        if (message.destinationName == "<?= $topic_mqtt_PRSTMPDIG5 ?>") {

            generateDataPRSTMPDIG5(message.payloadString);
        }

        if (message.destinationName == "<?= $topic_mqtt_PRSTMPDIG6 ?>") {

            generateDataPRSTMPDIG6(message.payloadString);
        }

        if (message.destinationName.substring(0, 9) == "PRSPSSSCP") {
            $("#data" + message.destinationName).html(message.payloadString);
        }

        if (message.destinationName.substring(0, 9) == "PRSAMPDIG") {
            $("#data" + message.destinationName).html(message.payloadString);
        }

        // if (message.destinationName == "<?= $topic_mqtt_PRSAMPDIG1 ?>") {
        //     $("#dataPRSAMPDIG1").html(message.payloadString);
        // }




    }
</script>