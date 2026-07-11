<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,

            'project' => 'ZooDex API',

            'version' => '1.0',

            'description' => 'REST API per la consultazione del database ZooDex.',

            'documentation' => [

                [
                    'method' => 'GET',
                    'endpoint' => '/api/settings',
                    'description' => 'Restituisce le impostazioni generali dell\'applicazione.',
                ],

                [
                    'method' => 'GET',
                    'endpoint' => '/api/taxonomies',
                    'description' => 'Restituisce tutte le tassonomie utilizzate per i filtri.',
                ],

                [
                    'method' => 'GET',
                    'endpoint' => '/api/animals',
                    'description' => 'Restituisce la lista degli animali con ricerca, filtri, ordinamenti e paginazione.',
                    'parameters' => [
                        'search' => 'Cerca per numero ZooDex, nome, nome scientifico e descrizione. Il numero può essere scritto come 1, 0001 o #0001.',

                        'animal_class' => 'Slug della classe animale.',
                        'diet' => 'Slug della dieta.',
                        'conservation_status' => 'Slug dello stato di conservazione.',

                        'continents' => 'Slug dei continenti separati da virgola.',
                        'continents_mode' => ['or', 'and'],

                        'habitats' => 'Slug degli habitat separati da virgola.',
                        'habitats_mode' => ['or', 'and'],

                        'abilities' => 'Slug delle abilità separati da virgola.',
                        'abilities_mode' => ['or', 'and'],

                        'weight_min' => 'Peso minimo in kg.',
                        'weight_max' => 'Peso massimo in kg.',

                        'height_min' => 'Altezza minima in cm.',
                        'height_max' => 'Altezza massima in cm.',

                        'length_min' => 'Lunghezza minima in cm.',
                        'length_max' => 'Lunghezza massima in cm.',

                        'lifespan_min' => 'Longevità minima in anni.',
                        'lifespan_max' => 'Longevità massima in anni.',

                        'sort' => [
                            'id',
                            'name',
                            'scientific_name',
                            'weight_kg',
                            'height_cm',
                            'length_cm',
                            'lifespan_years',
                            'animal_class',
                            'diet',
                            'conservation_status',
                        ],

                        'direction' => ['asc', 'desc'],

                        'page' => 'Numero della pagina.',
                        'per_page' => 'Numero di risultati per pagina, da 1 a 100.',
                    ],
                    'examples' => [
                        '/api/animals?search=leo',
                        '/api/animals?search=%230001',
                        '/api/animals?animal_class=mammiferi&diet=carnivoro',
                        '/api/animals?continents=africa,europa&continents_mode=or',
                        '/api/animals?habitats=prateria-savana,foresta-bosco&habitats_mode=and',
                        '/api/animals?weight_min=50&weight_max=300',
                        '/api/animals?sort=weight_kg&direction=desc',
                        '/api/animals?page=2&per_page=12',
                    ],
                ],

                [
                    'method' => 'GET',
                    'endpoint' => '/api/animals/{slug}',
                    'description' => 'Restituisce il dettaglio completo di un animale.',
                    'example' => '/api/animals/leone',
                ],

            ],
        ]);
    }
}