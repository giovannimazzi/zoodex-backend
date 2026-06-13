<?php

namespace Database\Seeders;

use App\Models\Ability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AbilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abilities = [
            [
                'name' => 'Veleno',
                'image' => 'veleno.png',
                'color' => '#8E24AA',
                'description' => 'Capacità di produrre o inoculare sostanze tossiche per difesa o caccia.',
            ],
            [
                'name' => 'Elettrocezione',
                'image' => 'elettrocezione.png',
                'color' => '#FFEA00',
                'description' => 'Capacità di percepire campi elettrici prodotti da altri organismi.',
            ],
            [
                'name' => 'Bioluminescenza',
                'image' => 'bioluminescenza.png',
                'color' => '#00E5FF',
                'description' => 'Capacità di produrre luce attraverso reazioni chimiche naturali.',
            ],
            [
                'name' => 'Rigenerazione',
                'image' => 'rigenerazione.png',
                'color' => '#4CAF50',
                'description' => 'Capacità di ricostruire parti del corpo danneggiate o perdute.',
            ],
            [
                'name' => 'Mimetismo',
                'image' => 'mimetismo.png',
                'color' => '#8E8E3A',
                'description' => 'Capacità di confondersi con l’ambiente o imitare altri organismi.',
            ],
            [
                'name' => 'Volo',
                'image' => 'volo.png',
                'color' => '#81D4FA',
                'description' => 'Capacità di spostarsi nell’aria tramite ali o strutture simili.',
            ],
            [
                'name' => 'Visione notturna',
                'image' => 'visione-notturna.png',
                'color' => '#8B1E1E',
                'description' => 'Capacità di vedere efficacemente in condizioni di scarsa luminosità.',
            ],
            [
                'name' => 'Ecolocalizzazione',
                'image' => 'ecolocalizzazione.png',
                'color' => '#7E57C2',
                'description' => 'Capacità di orientarsi tramite onde sonore e relativi echi.',
            ],
            [
                'name' => 'Corazza',
                'image' => 'corazza.png',
                'color' => '#D2691E',
                'description' => 'Presenza di strutture protettive rigide come carapaci, scudi o esoscheletri.',
            ],
            [
                'name' => 'Velocità',
                'image' => 'velocita.png',
                'color' => '#FFD54F',
                'description' => 'Capacità di muoversi rapidamente rispetto ad altri animali.',
            ],
            [
                'name' => 'Arrampicata',
                'image' => 'arrampicata.png',
                'color' => '#8B5E34',
                'description' => 'Capacità di scalare superfici verticali, alberi, rocce o altri supporti.',
            ],
            [
                'name' => 'Nuoto rapido',
                'image' => 'nuoto-rapido.png',
                'color' => '#0288D1',
                'description' => 'Capacità di muoversi velocemente in acqua.',
            ],
            [
                'name' => 'Termoregolazione estrema',
                'image' => 'termoregolazione-estrema.png',
                'color' => '#E53935',
                'description' => 'Capacità di sopravvivere o regolare il corpo in condizioni termiche difficili.',
            ],
            [
                'name' => 'Forza eccezionale',
                'image' => 'forza-eccezionale.png',
                'color' => '#757575',
                'description' => 'Capacità di esercitare una forza superiore rispetto alla propria dimensione.',
            ],
            [
                'name' => 'Salto',
                'image' => 'salto.png',
                'color' => '#B0BEC5',
                'description' => 'Capacità di compiere salti notevoli per altezza o distanza.',
            ],
            [
                'name' => 'Produzione seta',
                'image' => 'produzione-seta.png',
                'color' => '#B39DDB',
                'description' => 'Capacità di produrre fibre naturali resistenti, come ragnatele o bozzoli.',
            ],
            [
                'name' => 'Comunicazione sonora',
                'image' => 'comunicazione-sonora.png',
                'color' => '#546E7A',
                'description' => 'Capacità di comunicare tramite richiami, suoni, vibrazioni o canti.',
            ],
        ];

        foreach ($abilities as $data) {
            $sourcePath = database_path('seeders/assets/abilities/' . $data['image']);
            $storagePath = 'abilities/' . $data['image'];

            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($storagePath, File::get($sourcePath));
            }

            $ability = new Ability();

            $ability->name = $data['name'];
            $ability->slug = Str::slug($data['name']);
            $ability->image = $storagePath;
            $ability->color = $data['color'];
            $ability->description = $data['description'];

            $ability->save();
        }
    }
}
