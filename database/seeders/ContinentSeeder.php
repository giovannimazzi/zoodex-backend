<?php

namespace Database\Seeders;

use App\Models\Continent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
                'color' => '#C0D94A',
                'description' => 'Il continente più esteso e popolato della Terra.',
            ],
            [
                'name' => 'Nord America',
                'color' => '#388ad6',
                'description' => 'Comprende ambienti che spaziano dalle regioni artiche alle foreste tropicali.',
            ],
            [
                'name' => 'Sud America',
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
                'color' => '#CFDBDC',
                'description' => 'Continente più freddo della Terra, quasi interamente coperto da ghiaccio.',
            ],
        ];

        foreach ($continents as $data) {

            $continent = new Continent();

            $continent->name = $data['name'];
            $continent->slug = Str::slug($data['name']);

            $continent->image = null;

            $continent->color = $data['color'];
            $continent->description = $data['description'];

            $continent->save();
        }
    }
}
