#include <DallasTemperature.h>

#include <DHT.h>

#include <Wire.h>
#include <Adafruit_HTU21DF.h>
#include <OneWire.h>

/*
  Web client

 This sketch connects to a website (http://yourwebsite)
 using a WiFi shield.
 Sending sensor values with POST

 Sensors in this project
 2 DS18B20
 1 HTU21DF
 1 Jordfuktmtare

 Sensors to add
 Ljus

 Set an min value for the hygrometer to start the water pump

 Circuit:
 * WiFi shield attached

 created 10 May 2015
 by Ingvar
 modified 15 May 2015
 by Ingvar
 */

#include <SPI.h>
#include <WiFi.h>
#include "Hygrometer.h"
#include <OneWire.h>
#include <DallasTemperature.h>

// Setup a oneWire instance to communicate with any OneWire devices (not just Maxim/Dallas temperature ICs)
OneWire oneWire(ONE_WIRE_BUS);
Adafruit_HTU21DF htu = Adafruit_HTU21DF();

// Pass our oneWire reference to Dallas Temperature.
DallasTemperature sensors(&oneWire);

// arrays to hold device addresses
DeviceAddress insideThermometer, outsideThermometer;
bool requestTemp = true;

char ssid[] = "ingo-9F24"; //  your network SSID (name)
char pass[] = "Liljor&Lindar43";    // your network password (use for WPA, or use as key for WEP)


unsigned long hygrometerValue = 0;
unsigned int hygroRaw;
int status = WL_IDLE_STATUS;

// Initialize the Ethernet client library
// with the IP address and port of the server
// that you want to connect to (port 80 is default for HTTP):
char server[] = "api.ingvarkreft.se";    // name address for Google (using DNS)
WiFiClient client;

unsigned long lastConnectionTime = 0;            // last time you connected to the server, in milliseconds
const unsigned long postingInterval = 60L * 1000L; // delay between updates, in milliseconds

void setup() {
  pinMode(hygrometerInput, INPUT);
  pinMode(WATER_PUMP, OUTPUT);
  digitalWrite(WATER_PUMP, LOW);

  //Initialize serial and wait for port to open:
  Serial.begin(9600);
  while (!Serial) {
    ; // wait for serial port to connect. Needed for Leonardo only
  }
  if (!htu.begin()) {
    Serial.println("Couldn't find sensor!");
    while (1);
  }

  // check for the presence of the shield:
  if (WiFi.status() == WL_NO_SHIELD) {
    Serial.println("WiFi shield not present");
    // don't continue:
    while (true);
  }

  while (status != WL_CONNECTED) {
    // Connect to WPA/WPA2 network. Change this line if using open or WEP network:
    status = WiFi.begin(ssid, pass);

    // wait 10 seconds for connection:
    delay(10000);
  }
  printWifiStatus();
  // Start up the DS library
  sensors.begin();

  // method 1: by index
  if (!sensors.getAddress(insideThermometer, 0)) Serial.println("Unable to find address for Device 0");
  if (!sensors.getAddress(outsideThermometer, 1)) Serial.println("Unable to find address for Device 1");

  // set the resolution to 12 bit
  sensors.setResolution(insideThermometer, TEMPERATURE_PRECISION);
  sensors.setResolution(outsideThermometer, TEMPERATURE_PRECISION);

}


void loop() {
  int index = 0;
  float temp3;
  float hum2;
  pinMode(hygrometerInput, INPUT);

  // Only read temp once before we send it to the server
  if (requestTemp) {
    // call sensors.requestTemperatures() to issue a global temperature
    // request to all devices on the bus
    sensors.requestTemperatures();
    requestTemp = false;
  }
  // if 60 seconds have passed since your last connection,
  // then connect again and send data:
  if (millis() - lastConnectionTime > postingInterval) {
    temp3 = htu.readTemperature();
    hum2 = htu.readHumidity();

    // Build the POST message
    //TH tempHumi = getTempHumidity();
    readHygrometer();
    String hygro = String(hygrometerValue);
    String hygroR = String(hygroRaw);
    float temp1 = sensors.getTempC(insideThermometer);
    float temp2 = sensors.getTempC(outsideThermometer);
    String content = String("hygrometer=" + hygro + "&temp1=" + temp1 + "&temp2=" + temp2 + "&temp3=" + temp3 + "&humidity=" + hum2 + "&hygroRaw=" + hygroR);
    httpRequest(content);
    analogReference(DEFAULT);
    requestTemp = true;
  }

  // Check for server response
  while (client.available()) {
    char c = client.read();
    //Serial.print(c);
    if (c == waterOn.charAt(index)) {
      serverCommand += c;
      index++;
      if (waterOn == serverCommand) {
        digitalWrite(WATER_PUMP, HIGH);
        Serial.println("water on");
        serverCommand = "";
        delay(1000);
        digitalWrite(WATER_PUMP, LOW);
      }
    }
    else {
      index = 0;
      serverCommand = "";
    }
  }
}

// function to print a device address
void printAddress(DeviceAddress deviceAddress)
{
  for (uint8_t i = 0; i < 8; i++)
  {
    // zero pad the address if necessary
    if (deviceAddress[i] < 16) Serial.print("0");
    Serial.print(deviceAddress[i], HEX);
  }
}

// function to print the temperature for a device
void printTemperature(DeviceAddress deviceAddress)
{
  float tempC = sensors.getTempC(deviceAddress);
  //  Serial.print("Temp C: ");
  //  Serial.print(tempC);
  // Serial.print(" Temp F: ");
  // Serial.print(DallasTemperature::toFahrenheit(tempC));
}

// function to print a device's resolution
void printResolution(DeviceAddress deviceAddress)
{
  Serial.print("Resolution: ");
  Serial.print(sensors.getResolution(deviceAddress));
  Serial.println();
}

// main function to print information about a device
void printData(DeviceAddress deviceAddress)
{
  Serial.print("Device Address: ");
  printAddress(deviceAddress);
  Serial.print(" ");
  printTemperature(deviceAddress);
  Serial.println();
}


// this method makes a HTTP connection to the server:
void httpRequest(String content) {
  // close any connection before send a new request.
  // This will free the socket on the WiFi shield
  client.stop();

  // if there's a successful connection:
  if (client.connect(server, 80)) {
    Serial.println(content);
    // Make a HTTP request:
    client.println("POST / HTTP/1.1");
    client.println("Host: api.ingvarkreft.se");
    client.println("User-Agent: Arduino/1.0");
    client.println("Connection: close");
    client.println("Content-Type: application/x-www-form-urlencoded;");
    client.print("Content-Length: ");
    client.println(content.length());
    client.println();
    client.println(content);

    // note the time that the connection was made:
    lastConnectionTime = millis();
  }
  else {
    // if you couldn't make a connection:
    Serial.println("connection failed");
  }
}

int readHygrometer()
{
  byte i;
  hygrometerValue = 0;
  for (i = 0; i < 100; i++) {
    hygrometerValue += analogRead(hygrometerInput);
  }
  hygroRaw = hygrometerValue /= 100L;
  hygrometerValue = constrain(hygrometerValue, 100, 700);
  hygrometerValue = map(hygrometerValue, 100, 700, 100, 0);
}

void printWifiStatus() {
  // print the SSID of the network you're attached to:
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address:
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);

  // print the received signal strength:
  long rssi = WiFi.RSSI();
  Serial.print("signal strength (RSSI):");
  Serial.print(rssi);
  Serial.println(" dBm");
}

