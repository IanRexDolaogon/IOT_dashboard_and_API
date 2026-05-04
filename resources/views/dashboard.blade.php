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
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Smart Classroom Environment Monitor</h1>

        <!-- SMART FEATURE: Rule-based Decision Alert -->
        @if($latest && $latest->temperature > 30 && $latest->is_occupied)
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm animate-pulse">
                <p class="font-bold">⚠️ VENTILATION REQUIRED</p>
                <p>Rule triggered: Room is occupied and temperature exceeds 30°C (Current: {{ $latest->temperature }}°C).</p>
            </div>
        @elseif($latest)
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <p class="font-bold">✅ Conditions Normal</p>
                <p>Active monitoring in progress. No thresholds breached.</p>
            </div>
        @endif

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