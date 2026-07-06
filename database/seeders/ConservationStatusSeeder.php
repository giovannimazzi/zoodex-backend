<?php

namespace Database\Seeders;

use App\Models\ConservationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ConservationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Non a rischio',
                'image' => 'rischio-0.png',
                'color' => '#4CAF50',
                'description' => 'Specie stabile e diffusa in natura.',
            ],
            [
                'name' => 'Quasi minacciato',
                'image' => 'rischio-1.png',
                'color' => '#F4C430',
                'description' => 'Potrebbe diventare minacciata nel prossimo futuro.',
            ],
            [
                'name' => 'Vulnerabile',
                'image' => 'rischio-2.png',
                'color' => '#FF9800',
                'description' => 'Specie esposta a un elevato rischio di estinzione.',
            ],
            [
                'name' => 'In pericolo',
                'image' => 'rischio-3.png',
                'color' => '#F44336',
                'description' => 'Specie con rischio molto elevato di estinzione.',
            ],
            [
                'name' => 'Gravemente in pericolo',
                'image' => 'rischio-4.png',
                'color' => '#8E44AD',
                'description' => 'Specie a rischio critico di estinzione.',
            ],
            [
                'name' => 'Estinto in natura',
                'image' => 'rischio-5.png',
                'color' => '#7A7A7A',
                'description' => 'Non esistono più popolazioni selvatiche; sopravvive solo in cattività.',
            ],
            [
                'name' => 'Estinto',
                'image' => 'rischio-6.png',
                'color' => '#424242',
                'description' => 'Non esistono più individui viventi della specie.',
            ],
        ];

        foreach($statuses as $data){
            $sourcePath = database_path('seeders/assets/conservation-status/' . $data['image']);
            $storagePath = 'conservation-status/' . $data['image'];

            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($storagePath, File::get($sourcePath));
            }

            $status = new ConservationStatus();

            $status->name = ucfirst($data['name']);
            $status->slug = generateUniqueSlug(ConservationStatus::class, $data['name']);
            $status->image = $storagePath;
            $status->color = $data['color'];
            $status->description = ucfirst($data['description']);

            $status->save();
        }
    }
}
