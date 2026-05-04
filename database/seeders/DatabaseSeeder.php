<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SensorData; // Don't forget to import your model!

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // This tells Laravel to generate 25 fake records using our Factory
        SensorData::factory(25)->create();
    }
}