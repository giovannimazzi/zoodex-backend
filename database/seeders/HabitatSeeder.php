<?php

namespace Database\Seeders;

use App\Models\Habitat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HabitatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $habitats = [
            [
                'name' => 'Foresta / Bosco',
                'image' => 'foresta-bosco.png',
                'color' => '#006400',
                'description' => 'Ambiente ricco di alberi, vegetazione e biodiversità.',
            ],
            [
                'name' => 'Deserto',
                'image' => 'deserto.png',
                'color' => '#EDC988',
                'description' => 'Ambiente arido con scarse precipitazioni e forti escursioni termiche.',
            ],
            [
                'name' => 'Montagna',
                'image' => 'montagna.png',
                'color' => '#8B6F47',
                'description' => 'Ambiente d’alta quota caratterizzato da pendii, rocce e clima variabile.',
            ],
            [
                'name' => 'Prateria / Savana',
                'image' => 'prateria-savana.png',
                'color' => '#CDE77F',
                'description' => 'Ambiente aperto dominato da erbe, con pochi alberi sparsi.',
            ],
            [
                'name' => 'Palude',
                'image' => 'palude.png',
                'color' => '#6B8E23',
                'description' => 'Zona umida con acqua stagnante o poco profonda e vegetazione fitta.',
            ],
            [
                'name' => 'Fiume / Lago',
                'image' => 'fiume-lago.png',
                'color' => '#4FC3F7',
                'description' => 'Ambiente d’acqua dolce, corrente o stagnante.',
            ],
            [
                'name' => 'Mare / Oceano',
                'image' => 'mare-oceano.png',
                'color' => '#1565C0',
                'description' => 'Ambiente acquatico salato che ospita moltissime forme di vita.',
            ],
            [
                'name' => 'Grotte',
                'image' => 'grotte.png',
                'color' => '#424242',
                'description' => 'Ambiente sotterraneo spesso buio, umido e ricco di specie adattate.',
            ],
            [
                'name' => 'Artico / Polare',
                'image' => 'artico-polare.png',
                'color' => '#ECEFF1',
                'description' => 'Ambiente freddo caratterizzato da ghiaccio, neve e temperature estreme.',
            ],
        ];

        foreach ($habitats as $data) {
            $sourcePath = database_path('seeders/assets/habitats/' . $data['image']);
            $storagePath = 'habitats/' . $data['image'];

            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($storagePath, File::get($sourcePath));
            }

            $habitat = new Habitat();

            $habitat->name = $data['name'];
            $habitat->slug = Str::slug($data['name']);
            $habitat->image = $storagePath;
            $habitat->color = $data['color'];
            $habitat->description = $data['description'];

            $habitat->save();
        }
    }
}
