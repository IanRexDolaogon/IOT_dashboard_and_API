<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Classroom Monitor</title>
    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js for graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-8 font-sans">

    <div class="max-w-6xl mx-auto">
       <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Smart Classroom Environment Monitor</h1>
    
    <a href="/export" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow-sm transition-colors duration-200">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
        </svg>
        Export Data (CSV)
    </a>
</div>

        <!-- SMART FEATURE: Rule-based Decision Alert -->
        @if($latest && $latest->temperature > $threshold && $latest->is_occupied)
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm animate-pulse">
                <p class="font-bold">VENTILATION REQUIRED</p>
                <p>Rule triggered: Room is occupied and temperature exceeds {{ $threshold }}°C (Current: {{ $latest->temperature }}°C).</p>
            </div>
        @elseif($latest)
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <p class="font-bold">Conditions Normal</p>
                <p>Active monitoring. Alert threshold is set to {{ $threshold }}°C.</p>
            </div>
        @endif

        <!-- System Settings Panel -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-8 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800 mb-2">System Settings</h2>
            <form action="/update-threshold" method="POST" class="flex items-end gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Alert Threshold (°C)</label>
                    <input type="number" step="0.1" name="threshold" value="{{ $threshold }}" class="mt-1 block w-32 rounded-md border-gray-300 shadow-sm p-2 border focus:border-blue-500 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded shadow transition-colors">
                    Save Changes
                </button>
            </form>
            <p class="text-xs text-gray-500 mt-2">Alerts will only trigger if the room is occupied and temperature exceeds this value.</p>
        </div>

        <!-- Real-time Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-gray-500 text-sm font-semibold">Temperature</h3>
                <p class="text-3xl font-bold text-gray-800">{{ $latest ? $latest->temperature : '--' }} °C</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-gray-500 text-sm font-semibold">Humidity</h3>
                <p class="text-3xl font-bold text-gray-800">{{ $latest ? $latest->humidity : '--' }} %</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-gray-500 text-sm font-semibold">Light Level</h3>
                <p class="text-3xl font-bold text-gray-800">{{ $latest ? $latest->light_level : '--' }} Lux</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-gray-500 text-sm font-semibold">Room Status</h3>
                <p class="text-3xl font-bold text-blue-600">
                    {{ $latest && $latest->is_occupied ? 'Occupied' : 'Empty' }}
                </p>
            </div>
        </div>

        <!-- Analytics Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Line Graph -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Temperature Trends</h2>
                <canvas id="tempChart"></canvas>
            </div>
            
            <!-- Bar Chart -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Light Level Comparisons</h2>
                <canvas id="lightChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart Setup Script -->
    <script>
        // Data passed from Laravel Controller
        const labels = {!! json_encode($labels ?? []) !!};
        const tempValues = {!! json_encode($temperatures ?? []) !!};
        const lightValues = {!! json_encode($lightLevels ?? []) !!};

        // Render Line Chart (Temperature Trends)
        const tempCtx = document.getElementById('tempChart').getContext('2d');
        new Chart(tempCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Temperature (°C)',
                    data: tempValues,
                    borderColor: 'rgb(239, 68, 68)',
                    tension: 0.3,
                    fill: false
                }]
            }
        });

        // Render Bar Chart (Light Levels)
        const lightCtx = document.getElementById('lightChart').getContext('2d');
        new Chart(lightCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Brightness (Lux)',
                    data: lightValues,
                    backgroundColor: 'rgb(59, 130, 246)',
                }]
            }
        });
    </script>
</body>
</html>