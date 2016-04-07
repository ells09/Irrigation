
//#define  DHTPIN 2
//#define  DHTTYPE DHT11
#define  hygrometerInput A1
#define ONE_WIRE_BUS 3
#define TEMPERATURE_PRECISION 12
#define WATER_PUMP 4
#define NEXA_TEMP 6
#define NEXA_FAN 5
#define NEXA_LIGHT 4

//struct TH {
//  float  celsius;
//  float  humidity;
//  float farenheit;
//};

// Commands returned from server
String waterOn = ("C=W_ON");
String lightOn = ("C=L_ON");
String lightOff = ("C=L_OFF");

String serverCommand = ("");


