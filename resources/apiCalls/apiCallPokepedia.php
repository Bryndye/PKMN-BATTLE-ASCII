<?php

$pokemonList = [];

// for ($i = 1; $i <= 78; $i++) {
//     $url = "https://pokeapi.co/api/v2/pokemon/".$i;
//     $response = @file_get_contents($url);

//     // $url2 = "https://pokeapi.co/api/v2/evolution-chain/".$i;
//     // $response2 = @file_get_contents($url2);
//     // print($i . "\n");
//     // if ($response2 === false) {
//     //     echo "Error : failed to open stream for URL " . $url . "\n";
//     //     continue;
//     // }
//     // $pokemonData2 = json_decode($response2, true);
//     // $pokemonChain = [];
//     // array_push($pokemonChain, $pokemonData2['chain']['species']['name']); // first 
//     // array_push($pokemonChain, [$pokemonData2['chain']['evolves_to'][0]['species']['name'], $pokemonData2['chain']['evolves_to'][0]['evolution_details'][0]]); // second
//     // array_push($pokemonChain, [$pokemonData2['chain']['evolves_to'][0]['evolves_to'][0]['species']['name'], $pokemonData2['chain']['evolves_to'][0]['evolves_to'][0]['evolution_details'][0]]); // third
//     // print($i);
//     //sleep(50);

//     // for($z=0;$z<count($pokemonData2['chain']['evolves_to']);++$z){
//     //     array_push($pokemonChain, $pokemonData2['chain']['evolves_to'][$z]['species']['name']);
//     // }

//     $pokemonData = json_decode($response, true);

//     $pokemon = [
//         'Name' => $pokemonData['name'],
//         'N Pokedex' => $pokemonData['id'],
//         'Type 1' => $pokemonData['types'][0]['type']['name'],
//         'Type 2' => (count($pokemonData['types']) > 1) ? $pokemonData['types'][1]['type']['name'] : '',
//         'scale' => [
//             'height' => $pokemonData['height'],
//             'weight' => $pokemonData['weight'],
//         ],
//         'StatsBase' => [
//             'Health' => $pokemonData['stats'][5]['base_stat'],
//             'Atk' => $pokemonData['stats'][4]['base_stat'],
//             'Def' => $pokemonData['stats'][3]['base_stat'],
//             'Atk Spe' => $pokemonData['stats'][2]['base_stat'],
//             'Def Spe' => $pokemonData['stats'][1]['base_stat'],
//             'Vit' => $pokemonData['stats'][0]['base_stat'],
//         ],
//         'evolutions' => [
//             'before' => '',
//             'after' => ''
//         ],
//         'capacities' => [

//         ],
//         'Sprite' => 'Zone',
//     ];
//     $pokemonList[$i] = $pokemonChain;
// }
$file = file_get_contents('../../json/pokemonsv1.json');
$array = json_decode($file, true);


// $response = @file_get_contents($file);
foreach($array as &$pkmn){
    $pkmn['capacites'] = [
        [
            'name' => 'tackle',
            'level' => 1
        ]
    ];
}
$json = json_encode($array);


file_put_contents('../../json/pokemonsTest.json', $json);
// print_r($pokemonList);
?>