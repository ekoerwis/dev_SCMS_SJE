var hostname = "10.20.38.199";
var port = 9001;
var clientId = "HARI_TEST_WS1";
clientId += new Date().getUTCMilliseconds();
var topic = "PRSTMPDIG1";

mqttClient = new Paho.MQTT.Client(hostname, port, clientId);
mqttClient.onMessageArrived = MessageArrived;
mqttClient.onConnectionLost = ConnectionLost;
Connect();

/*Initiates a connection to the MQTT broker*/
function Connect() {
  mqttClient.connect({
    onSuccess: Connected,
    onFailure: ConnectionFailed,
    keepAliveInterval: 10,
  });
}

/*Callback for successful MQTT connection */
function Connected() {
  console.log("Connected to broker");
  mqttClient.subscribe(topic);
}

/*Callback for failed connection*/
function ConnectionFailed(res) {
  console.log("Connect failed:" + res.errorMessage);
}

/*Callback for lost connection*/
function ConnectionLost(res) {
  if (res.errorCode !== 0) {
    console.log("Connection lost:" + res.errorMessage);
    Connect();
  }
}

/*Callback for incoming message processing */
function MessageArrived(message) {
  console.log(message.destinationName + " : " + message.payloadString);

  var a = parseInt(message.payloadString);
  var ht = 100 - a;
  document.getElementById("top").style.height = "" + ht + "%";
  document.getElementById("top").innerHTML =
    message.payloadString + "&#176" + "C";
  document.getElementById("container").style.backgroundColor = "yellow";
  switch (message.payloadString) {
    case "ON":
      displayClass = "on";
      break;
    case "OFF":
      displayClass = "off";
      break;
    default:
      displayClass = "unknown";
  }
  var topic = message.destinationName.split("/");
  if (topic.length == 3) {
    var ioname = topic[1];
    UpdateElement(ioname, displayClass);
  }
}
