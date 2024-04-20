#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

// Conexion WiFi de la casa***********************//
//const char* ssid = "CLARO_bmaXH9";
//const char* password = "1D8F26C9C1";
//***********************************************//

// Conexion WiFi de la casa 2 ***********************//
//const char* ssid = "Nexxt_A7EC46";
//const char* password = "Alice2024*";
//***********************************************//

// Conexion WiFi de oficina ***********************//
const char* ssid = "CLARO1_E6FB7E";
const char* password = "V4553DRobo";
//***********************************************//

//*************** conexion WiFi HNS ************//
//const char* ssid = "H0115-69LP03 1092";
//const char* password = "RRhh2023";
//*********************************************//
//String url = "http://bricotronicsv.net/index.php";

//****************************** VARIABLES USADAS PARA LAS LUCES Y LOS BOTONES *********************************//
String LED_id = "1";                  //SE COLOCA EL ID DE LA LUZ PARA IDENTIFICARLO SI QUEREMOS COLOCAR MAS DE 1
String LED_id2 = "2";                  //SE COLOCA EL ID DE LA LUZ PARA IDENTIFICARLO SI QUEREMOS COLOCAR MAS DE 1
String LED_id3 = "3";                  //SE COLOCA EL ID DE LA LUZ PARA IDENTIFICARLO SI QUEREMOS COLOCAR MAS DE 1
bool toggle_pressed = false;          //Each time we press the push button    
String data_to_send = "";             //Text data to send to the server
unsigned int Actual_Millis, Previous_Millis;
int refresh_time = 200;               //Refresh rate of connection to website (recommended more than 1s)
//**************************************************************************************************************//

//********************* DECLARACION DE ENTRADAS Y SALIDAS ******************************//
int button1 = 13;                     //Connect push button on this pin
int button2 = 5;
int button3 = 6;
int LED = 2;                          //Connect LED on this pin (add 150ohm resistor)
int LED2 = 20; 
int LED3 = 19; 

//*************************************************************************************//

//Button press interruption
void IRAM_ATTR isr() {
  toggle_pressed = true; 
}

void setup()
{
  Serial.begin(115200);
  delay(10);
  pinMode(LED, OUTPUT);                      //Set pin 2 as OUTPUT
  pinMode(LED2, OUTPUT);                     //Set pin 20 as OUTPUT
  pinMode(LED3, OUTPUT);                     //Set pin 19 as OUTPUT
  pinMode(button1, INPUT_PULLDOWN_16);       //Set pin 13 as INPUT with pulldown
  pinMode(button2, INPUT_PULLDOWN_16);       //Set pin 5 as INPUT with pulldown
  pinMode(button3, INPUT_PULLDOWN_16);       //Set pin 6 as INPUT with pulldown
  
  attachInterrupt(button3, isr, RISING);  //Create interruption on pin 13

  // Conectar WiFi
  WiFi.begin(ssid, password);
  Serial.print("Conectando...");
  while (WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
    
    }
    
    Serial.print("Connected, my IP: ");
    Serial.println(WiFi.localIP());
    Actual_Millis = millis();               //Save time for refresh loop
    Previous_Millis = Actual_Millis;  
    
}

void loop(){  
  //We make the refresh loop using millis() so we don't have to sue delay();
  Actual_Millis = millis();
  if(Actual_Millis - Previous_Millis > refresh_time){
    Previous_Millis = Actual_Millis;  
    if(WiFi.status()== WL_CONNECTED){                   //Check WiFi connection status  
      HTTPClient http;                                  //Create new client
      if(toggle_pressed){                               //If button was pressed we send text: "toggle_LED"
        data_to_send = "toggle_LED=" + LED_id;  
        toggle_pressed = false;                         //Also equal this variable back to false 
      }
      else{
        data_to_send = "check_LED_status=" + LED_id;    //If button wasn't pressed we send text: "check_LED_status"
      }
      
      //Begin new connection to website
      WiFiClient client;       
      http.begin(client, "http://bricotronicsv.net/esp32_update.php");   //Indicate the destination webpage 
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");         //Prepare the header
      
      int response_code = http.POST(data_to_send);                                //Send the POST. This will giveg us a response code
      
      //If the code is higher than 0, it means we received a response
      if(response_code > 0){
        Serial.println("HTTP code " + String(response_code));                     //Print return code
  
        if(response_code == 200){                                                 //If code is 200, we received a good response and we can read the echo data
          String response_body = http.getString();                                //Save the data comming from the website
          Serial.print("Server reply: ");                                         //Print data to the monitor for debug
          Serial.println(response_body);

          //Si los datos recibidos son LED_is_off, configuramos el pin LED en BAJO
          if(response_body == "LED_is_off"){
            digitalWrite(LED, LOW);
          }
          //Si los datos recibidos son LED_is_on, configuramos el pin LED en AlTO
          else if(response_body == "LED_is_on"){
            digitalWrite(LED, HIGH);
          }
          else if(response_body == "LED2_is_off"){
            digitalWrite(LED2, LOW);
          }
          else if(response_body == "LED2_is_on"){
            digitalWrite(LED2, HIGH);
          }
          else if(response_body == "LED3_is_off"){
            digitalWrite(LED3, LOW);
          }
          else if(response_body == "LED3_is_on"){
            digitalWrite(LED2, HIGH);
            }  
        }//End of response_code = 200
      }//END of response_code > 0
      
      else{
       Serial.print("Error sending POST, code: ");
       Serial.println(response_code);
      }
      http.end();                                                                 //End the connection
    }//END of WIFI connected
    else{
      Serial.println("WIFI connection error");
    }
  }
}
