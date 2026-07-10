<?php

namespace Database\Seeders;

use App\Models\AnimalClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AnimalClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animalClasses = [
            ['name' => 'Mammiferi', 'image' => 'mammiferi.svg', 'color' => '#e49750', 'description' => 'Animali vertebrati caratterizzati dalla presenza di ghiandole mammarie e pelo.'],
            ['name' => 'Uccelli', 'image' => 'uccelli.svg', 'color' => '#B3C6D9', 'description' => 'Vertebrati dotati di piume, becco e, nella maggior parte dei casi, capacità di volare.'],
            ['name' => 'Rettili', 'image' => 'rettili.svg', 'color' => '#00A86B', 'description' => 'Vertebrati a sangue freddo, spesso ricoperti da squame.'],
            ['name' => 'Anfibi', 'image' => 'anfibi.svg', 'color' => '#40E0D0', 'description' => 'Vertebrati che vivono parte della vita in acqua e parte sulla terraferma.'],
            ['name' => 'Pesci', 'image' => 'pesci.svg', 'color' => '#0D6EAF', 'description' => 'Vertebrati acquatici dotati di branchie e pinne.'],
            ['name' => 'Insetti', 'image' => 'insetti.svg', 'color' => '#FFD54F', 'description' => 'Invertebrati con corpo diviso in segmenti e generalmente sei zampe.'],
            ['name' => 'Aracnidi', 'image' => 'aracnidi.svg', 'color' => '#6E4B7E', 'description' => 'Invertebrati con otto zampe, come ragni e scorpioni.'],
            ['name' => 'Molluschi', 'image' => 'molluschi.svg', 'color' => '#FF7F9E', 'description' => 'Invertebrati dal corpo molle, talvolta protetto da una conchiglia.'],
            ['name' => 'Crostacei', 'image' => 'crostacei.svg', 'color' => '#FF4500', 'description' => 'Invertebrati acquatici dotati di esoscheletro e appendici articolate.'],
        ];

        foreach ($animalClasses as $data) {
            $sourcePath = database_path('seeders/assets/animal-classes/' . $data['image']);
            $storagePath = 'animal-classes/' . $data['image'];

            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($storagePath, File::get($sourcePath));
            }

            $animalClass = new AnimalClass();

            $animalClass->name = ucwords(strtolower($data['name']));
            $animalClass->slug = generateUniqueSlug(AnimalClass::class, $data['name']);
            $animalClass->image = $storagePath;
            $animalClass->color = $data['color'];
            $animalClass->description = ucfirst($data['description']);

            $animalClass->save();
        }
    }
}
