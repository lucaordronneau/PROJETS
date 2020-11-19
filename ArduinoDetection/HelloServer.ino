w#include <WiFi.h>
#include <WiFiClient.h>
#include <WebServer.h>
#include <ESPmDNS.h>
#include "ESP32_MailClient.h"

const char* ssid = "SFR_CC10";
const char* password = "nhz53vsys8mnm63xhfb8";

#define emailSenderAccount    "luca.ordnew@gmail.com"    
#define emailSenderPassword   "13LUBAce09"
#define emailRecipient        "ordronneau@eisti.eu"
#define smtpServer            "smtp.gmail.com"
#define smtpServerPort        465
#define emailSubject          "Detection of a person"

// The Email Sending data object contains config and data to send
SMTPData smtpData;

// Callback function to get the Email sending status
void sendCallback(SendStatus info);

//const char* ssid = "HUAWEI P20 Pro Enzo";
//const char* password = "wasabi1989";

WebServer server(80);

#define timeSeconds 15
const int led = 13;
const int motionSensor = 27;

// Timer: Auxiliary variables
unsigned long now = millis();
unsigned long lastTrigger = 0;
boolean startTimer = false;

const char MAIN_page[] PROGMEM = R"=====(
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<style>
html { 
  font-family: Helvetica;
}

h1 {
  text-align: center;
  margin : 60px;
}

a {
  margin : 20px;
}

</style>
<body>
<h1 class="text-secondary">Welcome to your control space Luca</h1>
<div class="container">
  <div class="row">
    <div class="col-sm text-center">
      <a class="btn btn-outline-info" href="/luca" role="button">VIBRATION SENSOR</a>
    </div>
    <div class="col-sm text-center">
      <a class="btn btn-outline-info" href="/irSensor" role="button">IR DISTANCE SENSOR</a>
    </div>
    <div class="col-sm text-center">
      <a class="btn btn-outline-info" href="/motionSensor" role="button">MOTION SENSOR</a>
    </div>
  </div>
</div>


</body>
</html>
)=====";


void sendEmail(){
  Serial.println();
  Serial.println("Preparing to send email");
  Serial.println();
  
  // Set the SMTP Server Email host, port, account and password
  smtpData.setLogin(smtpServer, smtpServerPort, emailSenderAccount, emailSenderPassword);

  // For library version 1.2.0 and later which STARTTLS protocol was supported,the STARTTLS will be 
  // enabled automatically when port 587 was used, or enable it manually using setSTARTTLS function.
  //smtpData.setSTARTTLS(true);

  // Set the sender name and Email
  smtpData.setSender("ESP32", emailSenderAccount);

  // Set Email priority or importance High, Normal, Low or 1 to 5 (1 is highest)
  smtpData.setPriority("High");

  // Set the subject
  smtpData.setSubject(emailSubject);

  // Set the message with HTML format
  smtpData.setMessage("<div style=\"color:#2f4468;\"><h1 tetx-align : \"center\">Somoene is here !</h1><p>- Sent from Luca's control space</p></div>", true);

  // Add recipients, you can add more than one recipient
  smtpData.addRecipient(emailRecipient);
  //smtpData.addRecipient("YOUR_OTHER_RECIPIENT_EMAIL_ADDRESS@EXAMPLE.com");

  smtpData.setSendCallback(sendCallback);

  //Start sending Email, can be set callback function to track the status
  if (!MailClient.sendMail(smtpData))
    Serial.println("Error sending Email, " + MailClient.smtpErrorReason());

  //Clear all data from Email object to free memory
  smtpData.empty();
}

const char MOTIONSENSOR_page[] PROGMEM = R"=====(
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<style>
html { 
  font-family: Helvetica;
}

h1 {
  text-align: center;
  margin : 60px;
}

a {
  margin : 20px;
}

.dotHere {
  height: 50px;
  width: 50px;
  background-color: yellow;
  border-radius: 50%;
  display: inline-block;
}

.dotNotHere {
  height: 50px;
  width: 50px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
}

</style>
<body>
<h1 class="text-secondary">Motion Sensor</h1>
<div class="container">
  <p class="text-center" id="value"><span class='dotNotHere'></span></p>
</div>

<script>
 
setInterval(function() {
  // Call a function repetatively with 2 Second interval
  getData();
}, 2000); //2000mSeconds update rate
 
function getData() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "1"){
        var here = "<span class='dotHere'></span>"
        document.getElementById("value").innerHTML = here;
        sendEmail();
      }
      else{
        var notHere = "<span class='dotNotHere'></span>"
        document.getElementById("value").innerHTML = notHere;
      }

    }
  };
  xhttp.open("GET", "motionSensorValue", true);
  xhttp.send();
}
</script>


</body>
</html>
)=====";


void handle_motionSensor() {
  Serial.println("Motion Sensor Page");
  String m = MOTIONSENSOR_page; //Read HTML contents
  server.send(200, "text/html", m); //Send web page
}

void handle_motionSensorValue() {
  Serial.println("Motion Sensor Value");
  server.send(200, "text/plane", String(startTimer)); 
}

// Checks if motion was detected, sets LED HIGH and starts a timer
void IRAM_ATTR detectsMovement() {
  Serial.println("MOTION DETECTED!!!");
  //sendEmail();
  digitalWrite(led, HIGH);
  startTimer = true;
  lastTrigger = millis();
  
}

void handle_luca() {
  Serial.println("What's up");
  server.send(200, "text/plain", String(startTimer)); 
}

void handleRoot() {
  digitalWrite(led, 1);
  String s = MAIN_page; //Read HTML contents
  server.send(200, "text/html", s); //Send web page
  digitalWrite(led, 0);
}

void handleNotFound() {
  digitalWrite(led, 1);
  String message = "File Not Found\n\n";
  message += "URI: ";
  message += server.uri();
  message += "\nMethod: ";
  message += (server.method() == HTTP_GET) ? "GET" : "POST";
  message += "\nArguments: ";
  message += server.args();
  message += "\n";
  for (uint8_t i = 0; i < server.args(); i++) {
    message += " " + server.argName(i) + ": " + server.arg(i) + "\n";
  }
  server.send(404, "text/plain", message);
  digitalWrite(led, 0);
}


void setup(void) {
  // Serial port for debugging purposes
  Serial.begin(115200);
  // PIR Motion Sensor mode INPUT_PULLUP
  pinMode(motionSensor, INPUT_PULLUP);
  // Set motionSensor pin as interrupt, assign interrupt function and set RISING mode
  attachInterrupt(digitalPinToInterrupt(motionSensor), detectsMovement, RISING);
  // Set LED to LOW
  pinMode(led, OUTPUT);
  digitalWrite(led, LOW);
  
  //pinMode(led, OUTPUT);
  //digitalWrite(led, 0);
  
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.println("");

  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

  if (MDNS.begin("esp32")) {
    Serial.println("MDNS responder started");
  }

  server.on("/", handleRoot);
  server.on("/luca", handle_luca);
  server.on("/motionSensor", handle_motionSensor);
  server.on("/motionSensorValue", handle_motionSensorValue);
  
  server.on("/inline", []() {
    server.send(200, "text/plain", "this works as well");
  });

  server.onNotFound(handleNotFound);

  server.begin();
  Serial.println("HTTP server started");

  
}

// Callback function to get the Email sending status
void sendCallback(SendStatus msg) {
  // Print the current status
  Serial.println(msg.info());

  // Do something when complete
  if (msg.success()) {
    Serial.println("----------------");
  }
}

bool alreadySend = true;
void loop(void) {
  server.handleClient();
  // Current time
  now = millis();

  // Turn off the LED after the number of seconds defined in the timeSeconds variable
  if(startTimer && (now - lastTrigger > (timeSeconds*1000))) {
    Serial.println("Motion stopped...");
    //digitalWrite(led, LOW);
    startTimer = false;
    alreadySend = true; 
  }

  if (startTimer && alreadySend){
    sendEmail();
    alreadySend = false; 
  }
}
