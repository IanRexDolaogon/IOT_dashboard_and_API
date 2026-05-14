<!DOCTYPE html>
<html>
<head>
    <title>Classroom Alert</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-w-md mx-auto p-4 border border-red-500 rounded bg-red-50">
        <h2 style="color: #d32f2f;">Action Required: High Temperature Detected</h2>
        <p>The Smart Classroom Monitor has detected unsafe conditions in a currently occupied room.</p>
        
        <h3>Current Status:</h3>
        <ul>
            <li><strong>Device/Room:</strong> {{ $sensorData->device_id }}</li>
            <li><strong>Temperature:</strong> {{ $sensorData->temperature }} °C</li>
            <li><strong>Humidity:</strong> {{ $sensorData->humidity }} %</li>
            <li><strong>Time Logged:</strong> {{ $sensorData->created_at }}</li>
        </ul>

        <p style="font-weight: bold;">Please deploy maintenance staff or advise the instructor to open windows immediately.</p>
        
        <hr>
        <p style="font-size: 12px; color: #777;">This is an automated message from the Smart Classroom System.</p>
    </div>
</body>
</html>