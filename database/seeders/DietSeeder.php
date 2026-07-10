<?php

namespace Database\Seeders;

use App\Models\Diet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DietSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diets = [
            [
                'name' => 'Erbivoro',
                'image' => 'erbivoro.svg',
                'color' => '#4CAF50',
                'description' => 'Si nutre principalmente di piante, foglie, erba o altri vegetali.',
            ],
            [
                'name' => 'Carnivoro',
                'image' => 'carnivoro.svg',
                'color' => '#E53935',
                'description' => 'Si nutre principalmente di carne o di altri animali.',
            ],
            [
                'name' => 'Onnivoro',
                'image' => 'onnivoro.svg',
                'color' => '#D97706',
                'description' => 'Si nutre sia di alimenti vegetali sia di alimenti animali.',
            ],
            [
                'name' => 'Insettivoro',
                'image' => 'insettivoro.svg',
                'color' => '#F4C430',
                'description' => 'Si nutre principalmente di insetti e piccoli invertebrati.',
            ],
            [
                'name' => 'Piscivoro',
                'image' => 'piscivoro.svg',
                'color' => '#1E88E5',
                'description' => 'Si nutre principalmente di pesci.',
            ],
            [
                'name' => 'Frugivoro',
                'image' => 'frugivoro.svg',
                'color' => '#8E24AA',
                'description' => 'Si nutre principalmente di frutti.',
            ],
            [
                'name' => 'Nettarivoro',
                'image' => 'nettarivoro.svg',
                'color' => '#DDA0DD',
                'description' => 'Si nutre principalmente di nettare.',
            ],
        ];

        foreach($diets as $data){
            $sourcePath = database_path('seeders/assets/diets/' . $data['image']);
            $storagePath = 'diets/' . $data['image'];

            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($storagePath, File::get($sourcePath));
            }

            $diet = new Diet();

            $diet->name = ucwords(strtolower($data['name']));
            $diet->slug = generateUniqueSlug(Diet::class, $data['name']);
            $diet->image = $storagePath;
            $diet->color = $data['color'];
            $diet->description = ucfirst($data['description']);

            $diet->save();
        }
    }
}
