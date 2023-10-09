<div class="card ">
    <!-- <div class="card"> -->
    <div class="card-body text-center" style="background-color: rgb(255, 99, 132, 0.5);">
        <h3 class="card-title" style="color: black;">PRESSURE STATION REALTIME DATA</h3>
    </div>
    <!-- </div> -->

    <div id="alertDiv" class="alert alert-warning" role="alert" style="display:none;">
        <a id="textAlertDiv">xxx</a>
    </div>

    <div class="row col-12 mt-3">
        <?php

        for ($i = 1; $i < 7; $i++) {

            echo '
        <div class=" col-xl-3 col-lg-3 col-md-3 col-sm-12 pr-0 pl-1">
            <div class="card">
                <div class="card-header text-center" style="padding: 10px 10px 10px 10px;">
                    <h4> PRESS ' . $i . ' </h4>
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
    var myChart = [], dataExist = [];

    function generateDataPRSTMPDIG(dataPRSTMPDIG, iNumberChart) {

        let dougnutLabel = {
            id: 'dougnutLabel',
            afterDatasetsDraw(chart, args, pluginOptions) {

                let { ctx, data } = chart;

                ctx.save();
                let xCoor = chart.getDatasetMeta(0).data[0].x;
                let yCoor = chart.getDatasetMeta(0).data[0].y;

                let textLabel = data.datasets[0].data[0];

                ctx.font = 'bold 26px sans-serif';
                ctx.fillStyle = 'rgba(54,162, 235,1)';
                ctx.textAlign = 'center';
                ctx.textBaseLine = 'middle';
                ctx.fillText(textLabel, xCoor, yCoor);
            },
        }

        let config = {
            type: "doughnut",
            data: {
                // labels: [parseFloat(dataPRSTMPDIG1), 100 - parseFloat(dataPRSTMPDIG1).toFixed(2)],
                datasets: [{
                    backgroundColor: ["#FF6384", "#6c757d"],
                    data: [parseFloat(dataPRSTMPDIG), 100 - parseFloat(dataPRSTMPDIG).toFixed(2)]
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
            plugins: [dougnutLabel]
        };

        let ctx = document.getElementById("chartDataPRSTMPDIG" + iNumberChart).getContext("2d");


        let iNumberChartArray = iNumberChart - 1;

        if (myChart[iNumberChartArray] == null) {
            myChart[iNumberChartArray] = new Chart(ctx, config);
            dataExist[iNumberChartArray] = parseFloat(dataPRSTMPDIG);

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log('status myChart[iNumberChartArray] = baru / ' + dataExist[iNumberChartArray]);
        } else {

            // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
            // console.log(parseFloat(dataExist[iNumberChartArray]) + ' / ' + parseFloat(dataPRSTMPDIG));

            if (dataExist[iNumberChartArray] != parseFloat(dataPRSTMPDIG)) {
                myChart[iNumberChartArray].destroy();
                myChart[iNumberChartArray] = new Chart(ctx, config);

                dataExist[iNumberChartArray] = parseFloat(dataPRSTMPDIG);
            }
        }

    }
</script>



<script>
    $(document).ready(function() {

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

    }

    /*Callback for failed connection*/
    function ConnectionFailed(res) {

        $("#textAlertDiv").html('Connection Failed, Please Check Your Connection and <a href="" class="alert-link">Refresh Page</a> !');
        $("#alertDiv").show();

        // dimatikan agar tidak memenuhi console (nyalakan bila diperlukan)
        console.log("Connect failed:" + res.errorMessage);

    }

    /*Callback for lost connection*/
    function ConnectionLost(res) {
        if (res.errorCode !== 0) {
            $("#textAlertDiv").html('Connection Lost, Please Wait for Reconnect or Try <a href="" class="alert-link">Refresh Page</a> !');
            $("#alertDiv").show();

            // dimatikan agar tidak memenuhi console (nyalakan bila diperlukan)
            console.log("Connection lost:" + res.errorMessage);

            Connect();
        }
    }

    /*Callback for incoming message processing */
    function MessageArrived(message) {

        // dimatikan agar tidak memenuhi console karena data banyak (nyalakan bila diperlukan)
        // console.log(message.destinationName.substring(0, 9) + " : " + message.destinationName.substr(9,2));
        // console.log(message.destinationName + " : " + message.payloadString);

        if (message.destinationName.substring(0, 9) == "PRSTMPDIG") {
            generateDataPRSTMPDIG(message.payloadString, message.destinationName.substr(9, 2));
        }

        if (message.destinationName.substring(0, 9) == "PRSPSSSCP") {
            $("#data" + message.destinationName).html(message.payloadString);
        }

        if (message.destinationName.substring(0, 9) == "PRSAMPDIG") {
            $("#data" + message.destinationName).html(message.payloadString);
        }

    }
</script>