@php

$animals = [
  [
    "id" => 1,
    "nomeAnimale" => "Leone",
    "isMammifero" => true,
    "pesoMedioChili" => 190,
  ],
  [
    "id" => 2,
    "nomeAnimale" => "Aquila Reale",
    "isMammifero" => false,
    "pesoMedioChili" => 5,
  ],
  [
    "id" => 3,
    "nomeAnimale" => "Delfino",
    "isMammifero" => true,
    "pesoMedioChili" => 200,
  ],
  [
    "id" => 4,
    "nomeAnimale" => "Iguana Verde",
    "isMammifero" => false,
    "pesoMedioChili" => 4,
  ],
];


$results = [];

foreach($animals as $animal){
    if($animal['isMammifero']){
        $results[] = $animal['nomeAnimale'];
    }
}

dd($results);



@endphp