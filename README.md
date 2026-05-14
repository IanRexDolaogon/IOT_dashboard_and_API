# Smart Classroom IoT System

A full-stack Internet of Things (IoT) solution designed to monitor classroom environmental metrics and occupancy in real-time. Built with a Laravel backend and an ESP32 hardware client, featuring automated email alerts and physical buzzer actuators.

## 🛠️ Hardware Requirements
* **ESP32 Microcontroller** (ESP-WROOM-32 or similar)
* **DHT11 Sensor** (3-pin module preferred; if 4-pin, requires a 10k resistor)
* **PIR Motion Sensor** (HC-SR501)
* **LDR (Photoresistor)** (Requires a 10k resistor for voltage dividing)
* **Active Buzzer** (5V)
* **Breadboard & Jumper Wires**

## 💻 Software Dependencies
Ensure the following are installed on your machine before running the setup script:
* **PHP** (v8.1+)
* **Composer**
* **Node.js & NPM**
* **Arduino IDE** (For flashing the ESP32)

### Arduino IDE Libraries
Install these via `Tools > Manage Libraries` in the Arduino IDE:
1. `DHT sensor library` by Adafruit (Install dependencies when prompted)
2. `ArduinoJson` by Benoit Blanchon

---

## 🚀 Quick Setup (Windows)

1. **Clone the repository.**
2. **Run the Setup Script:** Double-click the `setup.bat` file in the project root. This will automatically install all Composer and NPM dependencies, generate your `.env` file, and run database migrations.
3. **Configure Mailtrap:** Open the `.env` file and input your Mailtrap SMTP credentials to enable email alerting.

---

## 📡 Network Architecture: The "Hotspot Bridge" Method
University and enterprise networks often block device-to-device communication (Client Isolation) or custom ports like 8000. To ensure a flawless defense presentation, this system utilizes a Mobile Hotspot Bridge.

### Step 1: Create the Local Network
1. Connect your smartphone to the school/home Wi-Fi (to provide internet for Mailtrap).
2. Turn on your phone's **Mobile Hotspot**. 
3. **CRITICAL:** Ensure the hotspot band is set to **2.4 GHz** or "Maximize Compatibility". The ESP32 physically cannot see 5 GHz networks.

### Step 2: Connect the Server (Laptop)
1. Connect your laptop to the phone's Mobile Hotspot.
2. Open Command Prompt, run `ipconfig`, and locate your **IPv4 Address** (e.g., `172.31.X.X`).
3. Start the Laravel server, explicitly opening it to the local network:
   ```bash
   php artisan serve --host 0.0.0.0 --port 8000


Step 3: Connect the Client (ESP32)
Open the .ino file in the Arduino IDE.

Update the network credentials to match your phone's Hotspot:

C++
const char* ssid = "YOUR_HOTSPOT_NAME"; 
const char* password = "YOUR_HOTSPOT_PASSWORD";
Update the API Endpoint with your laptop's newly acquired IPv4 Address:

C++
const char* serverName = "http://YOUR_LAPTOP_IPV4_ADDRESS:8000/api/sensor-data";