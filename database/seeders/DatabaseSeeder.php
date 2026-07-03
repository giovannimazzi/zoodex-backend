<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $logoSourcePath = database_path('seeders/assets/logos/logo-zoodex.png');
        $heroSourcePath = database_path('seeders/assets/logos/hero-zoodex.png');

        if (File::exists($logoSourcePath)) {
            Storage::disk('public')->put('logo-zoodex.png', File::get($logoSourcePath));
        }

        if (File::exists($heroSourcePath)) {
            Storage::disk('public')->put('hero-zoodex.png', File::get($heroSourcePath));
        }

        $this->call([
            AnimalClassSeeder::class, 
            DietSeeder::class, 
            ConservationStatusSeeder::class, 
            HabitatSeeder::class, 
            ContinentSeeder::class, 
            AbilitySeeder::class,
            AnimalSeeder::class
            ]);
    }
}
