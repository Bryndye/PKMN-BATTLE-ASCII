<?php
$json = file_get_contents('../../Save/save.json');
// $jsonEvol = file_get_contents('../../json/pokemonsEvolutions.json');

$pokemonPokedex = json_decode($json, true);
// $pokemonEvolutions = json_decode($jsonEvol, true);
// $newArray = array();
// foreach ($pokemonPokedex as $key => $value) {
//     if (isset($value['Name'])) {
//         $newArray[$value['Name']] = $value;
//     } else {
//         $newArray[$key] = $value;
//     }
// }

foreach($pokemonPokedex['Team'] as &$pokemon){
    $statBaseHp = $pokemon['StatsBase']['Health'];
    $statBaseAtk = $pokemon['StatsBase']['Atk'];
    $statBaseDef = $pokemon['StatsBase']['Def'];
    $statBaseAtkSpe = $pokemon['StatsBase']['Atk Spe'];
    $statBaseDefSpe = $pokemon['StatsBase']['Def Spe'];
    $statBaseVit = $pokemon['StatsBase']['Vit'];

    $pokemon['StatsBase']['Health'] = $statBaseVit;
    $pokemon['StatsBase']['Vit'] = $statBaseHp;
    // $pokemon['StatsBase']['Atk'] = $statBaseDefSpe;
    // $pokemon['StatsBase']['Def Spe'] = $statBaseAtk;
    // $pokemon['StatsBase']['Def'] = $statBaseAtkSpe;
    // $pokemon['StatsBase']['Atk Spe'] = $statBaseDef;
    print($pokemon['Name']."\n");
}
// print_r($newArray);
// sleep(50);

$json = json_encode($pokemonPokedex);
file_put_contents('../../Save/save.json', $json); // envoyer le cod
// ACTUELLEMENT IL CREE DES POKEMONS DANS LE TABLEAU ALORS QUILS NEXISTENT PAS !!!!

// function getEvol($pkmn, $pkmnEvol){
//     foreach($pkmnEvol as $family){
//         foreach($family as $key=>$pkmnE){
//             if($pkmn == $key){

//             }
//         }
//     }
// }
?>