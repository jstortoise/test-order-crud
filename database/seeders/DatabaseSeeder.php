<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Vehicle::factory(10)->create();

        \App\Models\Key::factory(10)->create();

        \App\Models\Technician::factory(10)->create();

        for ($i = 0; $i < 50; $i++)
        {
            $key_id = random_int(1, 10);
            $vehicle_id = random_int(1, 10);

            $duplicate = DB::table('key_vehicle')
                ->where('key_id', $key_id)
                ->where('vehicle_id', $vehicle_id)
                ->first();

            if (!$duplicate) {
                DB::table('key_vehicle')->insert([
                    'key_id' => $key_id,
                    'vehicle_id' => $vehicle_id,
                ]);
            }
        } 
    }
}
