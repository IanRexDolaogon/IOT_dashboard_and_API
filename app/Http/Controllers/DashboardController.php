<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the single most recent reading for the KPI cards and Smart Alert
        $latest = SensorData::latest()->first();

        // Get the last 15 readings for the Line Graph and Bar Chart
        // We use reverse() so the chart reads left-to-right chronologically
        $history = SensorData::latest()->take(15)->get()->reverse();

        // Extract data arrays for Chart.js
        $labels = $history->pluck('created_at')->map(function($date) {
            return $date->format('H:i'); // Format time as Hours:Minutes
        });
        $temperatures = $history->pluck('temperature');
        $lightLevels = $history->pluck('light_level');

        return view('dashboard', compact('latest', 'labels', 'temperatures', 'lightLevels'));
    }
}