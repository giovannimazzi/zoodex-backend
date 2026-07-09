<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        return response()->json([

            'success' => true,

            'results' => [

                'app_name' => 'ZooDex',

                'hero_title' => 'ZooDex',

                'hero_subtitle_en' => 'Know Them All',

                'hero_subtitle_it' => 'Conoscili tutti',

                'navbar_logo' => asset('storage/logo-zoodex.png'),

                'hero_logo' => asset('storage/hero-zoodex.png'),

            ]

        ]);
    }
}