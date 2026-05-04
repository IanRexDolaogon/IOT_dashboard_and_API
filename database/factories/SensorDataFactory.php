<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SensorDataFactory extends Factory
{
    public function definition(): array
    {
        return [
            'device_id' => 'ESP32_Simulated',
            // Random temp between 25.0 and 34.0
            'temperature' => fake()->randomFloat(1, 25, 34), 
            // Random humidity between 50% and 85%
            'humidity' => fake()->randomFloat(1, 50, 85), 
            // Random light between 200 (dim) and 1200 (bright)
            'light_level' => fake()->numberBetween(200, 1200), 
            // 70% chance the room is occupied
            'is_occupied' => fake()->boolean(70), 
            // Spread the data out over the last 8 hours so the chart looks good
            'created_at' => fake()->dateTimeBetween('-8 hours', 'now'),
        ];
    }
}