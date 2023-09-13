<?php

// $pokemonList = [];

// for ($i = 1; $i <= 200; ++$i) {
//     $url = "https://pokeapi.co/api/v2/move/".$i;
//     $response = @file_get_contents($url);

//     if ($response === false) {
//         echo "Error : failed to open stream for URL " . $url . "\n";
//         break;
//     }
//     $capaciteData = json_decode($response, true);
//     // if($capaciteData['generation']['name'] == 'generation-i'){
//     //     print("$i bad generation \n");
//     //     continue;
//     // }

//     $array = $capaciteData['learned_by_pokemon'];
//     $pokemonsLearned = [];
//     for($y = 0; $y < count($array); $y++){
//         $pokemonsLearned[] =  $array[$y]['name'];
//     }
//     $array2 = $capaciteData['stat_changes'];
//     print($capaciteData['name']. "\n");

//     $statsChangeBoost = [];
//     $statsChangeMalus = [];
//     for($z = 0; $z < count($array2); $z++){
//         if( $array2[$z]['change'] > 0){
//             $statsChangeBoost[] +=  [
//                 'change'=>$array2[$z]['change'],
//                 'name'=>$array2[$z]['stat']['name'],
//                 'chance'=>$capaciteData['meta']['stat_chance'] > 0 ? $capaciteData['meta']['stat_chance'] : 100,
//             ];
//         }
//         else{
//             $statsChangeMalus[] =  [
//                 'change'=>$array2[$z]['change'],
//                 'name'=>$array2[$z]['stat']['name'],
//                 'chance'=>$capaciteData['meta']['stat_chance'] > 0 ? $capaciteData['meta']['stat_chance'] : 100,
//             ];
//         }
//     };

//     $pokemon = [
//         'Name' => $capaciteData['name'],
//         'Power' => $capaciteData['power'],
//         'Type' => $capaciteData['type']['name'],
//         'PP' => $capaciteData['pp'],
//         'Category' => $capaciteData['damage_class']['name'],
//         'Accuracy' => $capaciteData['accuracy'],
//         'crit_rate' => $capaciteData['meta']['crit_rate'],
//         'priority' => $capaciteData['priority'],
//         'effects' => [
//             'Drain' => $capaciteData['meta']['drain'],
//             'Healing' => $capaciteData['meta']['healing'],
//             'Stats Self' => $statsChangeBoost,
//             'Stats Target' => $statsChangeMalus,
//             'Ailment' => [
//                 'ailment' => $capaciteData['meta']['ailment']['name'],
//                 'ailment_chance' => $capaciteData['meta']['ailment_chance']
//             ],
//             'Flinch Chance' => $capaciteData['meta']['flinch_chance'],
//             'hits' => [
//                 'min hits' => $capaciteData['meta']['min_hits'],
//                 'max hits' => $capaciteData['meta']['max_hits']
//             ],
//         ],
//         'Target' => $capaciteData['target']['name'],
//         'Pkmns Learned' => $pokemonsLearned,
//     ];
//     $pokemonList[$i] = $pokemon;
//     $json = json_encode($pokemonList);
    
// }
// file_put_contents('../../json/capacites.json', $json);
// print_r($pokemonList);

// PERMET DE CHANGER INDEX PAR NOM DE LA CAPACITE
$file = file_get_contents('../json/capacitesv5.json'); // choisir le doc a traduir
$array = json_decode($file, true);

// $nom = 'new_index';

// foreach ($array as $key => $value) {
//     // sleep(50);
//     $nom = $value['Name'];
//     $newArray[$nom] = $value;
// }
foreach ($array as $key => $value) {
    // sleep(50);
    $value['critical'] = 0;
    // $array['critical'] = 0;
}
// print_r($array);
// sleep(50);

$json = json_encode($array);
file_put_contents('../json/capacitesv6.json', $json); // envoyer le code 
// -- NE PAS OUBLIER DE CHANGER PP" PAR PP Max"
?>