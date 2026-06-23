<?php

namespace Database\Seeders;

use App\Models\Continent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $continents = [
            [
                'name' => 'Africa',
                'color' => '#A0522D',
                'description' => 'Secondo continente più grande del pianeta, caratterizzato da savane, deserti e foreste tropicali.',
            ],
            [
                'name' => 'Europa',
                'color' => '#2844c5',
                'description' => 'Continente caratterizzato da una grande varietà di ecosistemi e climi temperati.',
            ],
            [
                'name' => 'Asia',
                'color' => '#a8bd40',
                'description' => 'Il continente più esteso e popolato della Terra.',
            ],
            [
                'name' => 'America del Nord',
                'color' => '#388ad6',
                'description' => 'Comprende ambienti che spaziano dalle regioni artiche alle foreste tropicali.',
            ],
            [
                'name' => 'America del Sud',
                'color' => '#FF6F61',
                'description' => 'Ricco di biodiversità grazie alla foresta amazzonica e ad altri ecosistemi unici.',
            ],
            [
                'name' => 'Oceania',
                'color' => '#7B1FA2',
                'description' => 'Comprende Australia, Nuova Zelanda e numerose isole del Pacifico.',
            ],
            [
                'name' => 'Antartide',
                'color' => '#90a0a1',
                'description' => 'Continente più freddo della Terra, quasi interamente coperto da ghiaccio.',
            ],
        ];

        $sourcePath = database_path('seeders/assets/continents/globo.png');
        $storagePath = 'continents/globo.png';

        if (File::exists($sourcePath)) {
            Storage::disk('public')->put($storagePath, File::get($sourcePath));
        }

        foreach ($continents as $data) {

            $continent = new Continent();

            $continent->name = ucfirst($data['name']);
            $continent->slug = Str::slug($data['name']);

            $continent->image = null;

            $continent->color = $data['color'];
            $continent->description = ucfirst($data['description']);

            $continent->save();
        }
    }
}
