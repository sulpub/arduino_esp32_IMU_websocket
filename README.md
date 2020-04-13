# arduino_esp32_IMU_websocket
Motion visualisation with ESP32 device using websocket.

For the demonstration we used these parts :
 1. M5Stack or M5Stick developement board with Arduino software for the capture motion and send data using websocket. 
 2. Web page animation that capture the position of the develpement board using websocket. For change ip adress of the module or have more information, two parameters are available. **index.php?ip_websocket='XXX.XXX.XXX.XXX'&infos=1** 

Nota:
 1. To make the demonstration, it is necesary to have an internet connection and wifi share by smartphone or wifi router.
 2. Furthermore, it'a necessary to modify the ssid and password in the arduino software before load in the development board.
 
<p align="center">
  <img width="522" src="https://github.com/sulpub/arduino_esp32_IMU_websocket/blob/master/images/esp32_IMU_websocket.png">
 <br>
 <i>Demonstrator information</i>
</p>

The demonstration follow these stages:
 1. The **M5stack/M5stick start, init sensors and peripherals and make a wifi connexion** (for this demonstration the smartphone share wifi when you want to make this demonstration far from your home).
 2. On the same smartphone, when you **open the specific web page** attach to this project, the wifi server establish an internet connection to the external server that contain this web page.
 3. The **external webserver contain the webpage to see the motion of the M5stack/M5stick dev board**.
 4. That **webpage is loading by the smartphone**. In local, this webpage contain **a javascript that open a local websoccket client to the M5stack/M5stick**. (it's important to know the local IP adress of the M5stack/M5stick. This adress is indicate on the screen of the  M5stack/M5stick when you move the system).
 5. When the websocket link is establish, you can resfresh the webpage to activate it. In this case, you can **see the motion of the cube in the webpage when you move the M5stack/M5stick** development board.

<p align="center">
 <img width="320" src="https://github.com/sulpub/arduino_esp32_IMU_websocket/blob/master/images/sulpub.jpg">
 <img width="320" src="https://github.com/sulpub/arduino_esp32_IMU_websocket/blob/master/images/notice.jpg">
 <img width="320" src="https://github.com/sulpub/arduino_esp32_IMU_websocket/blob/master/images/informations.jpg">
 <br>
 <i>Interface on the screen of the M5stack devboard</i>
</p>


