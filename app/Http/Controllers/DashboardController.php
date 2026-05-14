<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\SensorData;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlertNotification;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the single most recent reading for the KPI cards and Smart Alert
        $latest = SensorData::latest()->first();

        // Get the last 15 readings for the Line Graph and Bar Chart
        $history = SensorData::latest()->take(15)->get()->reverse();

        // Extract data arrays for Chart.js
        $labels = $history->pluck('created_at')->map(function($date) {
            return $date->format('H:i'); // Format time as Hours:Minutes
        });
        $temperatures = $history->pluck('temperature');
        $lightLevels = $history->pluck('light_level');

        // NEW: Get the threshold from Cache, default to 30 if it hasn't been set yet
        $threshold = Cache::get('temp_threshold', 30);

        // Make sure 'threshold' is included in the compact() list here!
        return view('dashboard', compact('latest', 'labels', 'temperatures', 'lightLevels', 'threshold'));
    }

    public function updateThreshold(Request $request)
    {
        // 1. Save the new setting
        $request->validate(['threshold' => 'required|numeric']);
        Cache::put('temp_threshold', $request->threshold);
        
        // --- THE BUG FIX: RETROACTIVE CHECK ---
        
        // 2. Grab the most recent sensor reading from the database
        $latest = SensorData::latest()->first();

        // 3. If data exists, AND it breaks the new rule, AND the room is occupied...
        if ($latest && $latest->temperature > $request->threshold && $latest->is_occupied == true) {
            // Fire the email immediately without waiting for the ESP32!
            Mail::to('admin@school.edu')->send(new AlertNotification($latest));
        }

        // 4. Refresh the dashboard
        return back(); 
    }

    public function exportCsv()
    {
        // Name of the file that will be downloaded
        $fileName = 'classroom_data_' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            // Open a temporary memory stream
            $file = fopen('php://output', 'w');

            // 1. Add the CSV Header Row
            fputcsv($file, ['ID', 'Device ID', 'Temperature (°C)', 'Humidity (%)', 'Light Level (Lux)', 'Occupied', 'Timestamp']);

            // 2. Get all data from newest to oldest
            $data = SensorData::orderBy('created_at', 'desc')->get();

            // 3. Loop through the data and add each row to the CSV
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->device_id,
                    $row->temperature,
                    $row->humidity,
                    $row->light_level,
                    $row->is_occupied ? 'Yes' : 'No', // Translate true/false to Yes/No
                    $row->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        }, $fileName);
    }
}