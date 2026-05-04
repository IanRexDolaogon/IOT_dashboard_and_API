<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorData; // This is the model you made earlier!

class SensorController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate the incoming data from the ESP32 to ensure no errors
        $validated = $request->validate([
            'device_id' => 'required|string',
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'light_level' => 'required|numeric',
            'is_occupied' => 'required|boolean',
        ]);

        // 2. Save the validated data directly to your MySQL database
        $data = SensorData::create($validated);

        // 3. YOUR SMART FEATURE (Rule-based Decision System)
        $trigger_buzzer = false;
        
        // Logic: If Temp > 30 AND the PIR sensor detects someone is there
        if ($data->temperature > 30 && $data->is_occupied == true) {
            $trigger_buzzer = true; 
        }

        // 4. Send a response back to the ESP32
        return response()->json([
            'status' => 'success',
            'message' => 'Data recorded successfully',
            'trigger_buzzer' => $trigger_buzzer 
        ], 201);
    }
}