<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Animal;

class SettingsController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'results' => [
                'app_name' => config('app.name', 'ZooDex'),
                'navbar_logo' => asset('storage/logo-zoodex.png'),
                'hero_logo' => asset('storage/hero-zoodex.png'),
                'globe_image' => asset('storage/continents/globo.png'),
                'animals_count' => Animal::count(),
            ],
        ]);
    }
}