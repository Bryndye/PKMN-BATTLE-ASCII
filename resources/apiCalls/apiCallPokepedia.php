<?php

$pokemonList = [];

// for ($i = 1; $i <= 151; $i++) {
//     $url = "https://pokeapi.co/api/v2/pokemon/".$i;
//     $response = @file_get_contents($url);
//     print($response);
//     if ($response === false) {
//         echo "Error : failed to open stream for URL " . $url . "\n";
//         continue;
//     }
//     // $pokemonData = json_decode($response, true);
//     // print($pokemonData);

//     // $pokemon = [
//     //     'Name' => $pokemonData['name'],
//     //     'N Pokedex' => $pokemonData['id'],
//     //     'Type 1' => $pokemonData['types'][0]['type']['name'],
//     //     'Type 2' => (count($pokemonData['types']) > 1) ? $pokemonData['types'][1]['type']['name'] : '',
//     //     'StatsBase' => [
//     //         'Health' => $pokemonData['stats'][5]['base_stat'],
//     //         'Atk' => $pokemonData['stats'][4]['base_stat'],
//     //         'Def' => $pokemonData['stats'][3]['base_stat'],
//     //         'Atk Spe' => $pokemonData['stats'][2]['base_stat'],
//     //         'Def Spe' => $pokemonData['stats'][1]['base_stat'],
//     //         'Vit' => $pokemonData['stats'][0]['base_stat'],
//     //     ],
//     //     'Sprite' => $pokemonData['sprites']['front_default'],
//     // ];
//     // $pokemonList[$i] = $pokemon;
// }

// print_r($pokemonList);

$url = "https://pokeapi.co/api/v2/pokemon/1";
$response = @file_get_contents($url);
$capaciteData = json_decode($response, true);
print_r($capaciteData);

// if ($response === false) {
//     echo "Error : failed to open stream for URL " . $url . "\n";
// }
// $pokemonData = json_decode($response, true);
?>