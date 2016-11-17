/**
 * Authorization.ino
 *
 *  Created on: 09.12.2015
 *
 */

#include <Arduino.h>

#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>

#include <ESP8266HTTPClient.h>

#define USE_SERIAL Serial

ESP8266WiFiMulti WiFiMulti;

int iMQ_4_pin = 0;

void setup() {

    pinMode(15, OUTPUT);
    
    USE_SERIAL.begin(115200);
   // USE_SERIAL.setDebugOutput(true);

    USE_SERIAL.println();
    USE_SERIAL.println();
    USE_SERIAL.println();

    for(uint8_t t = 4; t > 0; t--) {
        USE_SERIAL.printf("[SETUP] WAIT %d...\n", t);
        USE_SERIAL.flush();
        delay(1000);
    }

    WiFiMulti.addAP("Makerversity_2G", "mak3rv3rs1ty");

}

void loop() {
    // wait for WiFi connection
    if((WiFiMulti.run() == WL_CONNECTED)) {

        HTTPClient http;

        USE_SERIAL.print("[HTTP] begin...\n");
        // configure traged server and url
        
        // String httpReq = "http://52.213.86.82/date.php?analogRead=";
        String httpReq = "http://sikarsystems.com/stuff/insert.php?analogRead=";
        httpReq += analogRead(iMQ_4_pin);
        
        USE_SERIAL.println(httpReq);
                
        // http.begin("http://52.209.97.70/date.php");
        http.begin(httpReq);
        
        /*
          // or
          http.begin("http://192.168.1.12/test.html");
          http.setAuthorization("user", "password");

          // or
          http.begin("http://192.168.1.12/test.html");
          http.setAuthorization("dXNlcjpwYXN3b3Jk");
         */


        USE_SERIAL.print("[HTTP] GET...\n");
        // start connection and send HTTP header
        int httpCode = http.GET();

        // httpCode will be negative on error
        if(httpCode > 0) {
            // HTTP header has been send and Server response header has been handled
            USE_SERIAL.printf("[HTTP] GET... code: %d\n", httpCode);

            // file found at server
            if(httpCode == HTTP_CODE_OK) {
                String payload = http.getString();
                USE_SERIAL.println(payload);
                // For future reference
                USE_SERIAL.println(analogRead(0));
            }
        } else {
            USE_SERIAL.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
        }

        http.end();
    }
    
    digitalWrite(15, HIGH);
    delay(500);
    digitalWrite(15, LOW);
    delay(500);
}

