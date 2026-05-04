## Installation & Setup

Follow these steps to get the server running on your local machine.

### 1. Prerequisites
Ensure you have the following installed on your computer:
* **XAMPP** (or any environment with PHP 8.2+ and MySQL)
* **Composer** (PHP dependency manager)
* **Postman Desktop App** (For API testing)

### 2. Project Initialization
Clone the repository or open the project folder in your terminal, then install dependencies:
```bash
composer install
3. Environment Configuration
Duplicate the .env.example file and rename it to .env. Update the database section to point to your local MySQL server:

Code snippet
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smart_classroom_db
DB_USERNAME=root
DB_PASSWORD=
Note: Make sure to create a database named smart_classroom_db in phpMyAdmin before proceeding.

Generate your application key:

Bash
php artisan key:generate
4. Database Setup & Dummy Data
Run the migrations to create the required tables in your database:

Bash
php artisan migrate
To populate the dashboard with 25 realistic, simulated data points for testing, run the database seeder:

Bash
php artisan db:seed
5. Start the Server
Launch the local development server:

Bash
php artisan serve
You can now view the dashboard by opening http://127.0.0.1:8000 in your web browser.

API Documentation
The Laravel backend provides a RESTful API endpoint to receive data from the ESP32 hardware.

Endpoint: POST /api/sensor-data
Headers Required:

Accept: application/json

Content-Type: application/json

Expected JSON Payload:

JSON
{
    "device_id": "ESP32_Room_302",
    "temperature": 31.5,
    "humidity": 65.0,
    "light_level": 850,
    "is_occupied": true
}

Successful Response (Status 201 Created):
The API will return instructions for the hardware node. If the Smart Rule is triggered (Temp > 30 & Occupied), trigger_buzzer will return true.

JSON
{
    "status": "success",
    "message": "Data recorded successfully",
    "trigger_buzzer": true
}

Testing the System Locally
Before connecting physical hardware, you can test the system's logic using Postman:

Ensure php artisan serve is running.

Open the Postman Desktop App.

Create a POST request to http://127.0.0.1:8000/api/sensor-data.

Set the header Accept to application/json.

Under the Body tab, select raw and JSON, then paste the payload from the API Documentation above.

Click Send.

Refresh your web dashboard (http://127.0.0.1:8000) to see the new data point and verify if the "VENTILATION REQUIRED" alert is triggered