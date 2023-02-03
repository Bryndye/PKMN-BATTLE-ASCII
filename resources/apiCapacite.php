<?php
// $options = array("Option 1", "Option 2", "Option 3");
// $selected = 0;

// while (true) {
//   echo "\033c";

//     for ($i = 0; $i < count($options); $i++) {
//         if ($i == $selected) {
//             echo "> ";
//         } else {
//             echo "  ";
//         }
//         echo $options[$i] . PHP_EOL;
//     }
//     echo "Choisissez une option avec les flèches haut et bas, puis appuyez sur Entrée." . PHP_EOL;

//     $input = "";
//     $inputStreams = array(STDIN);
//     $outputStreams = NULL;
//     $exceptStreams = NULL;
//     if (stream_select($inputStreams, $outputStreams, $exceptStreams, 0)) {
//         $input = ncurses(fgets(STDIN));
//         echo $input;
//         switch ($input) {
//             case "\033[A": // Flèche haut
//                 if ($selected > 0) {
//                     $selected--;
//                 }
//                 break;
//             case "\033[B": // Flèche bas
//                 if ($selected < count($options) - 1) {
//                     $selected++;
//                 }
//                 break;
//             default:
//                 break 2;
//         }
//     }
// }

// echo "Vous avez choisi : " . $options[$selected] . PHP_EOL;

// for($i=1;$i<152;++$i){
//     $url = "https://pokeapi.co/api/v2/pokemon/".$i;
//     $response = @file_get_contents($url);
//     // print($response);
//     $capaciteData = json_decode($response, true);
//     print( name']."\n");
// }

$pokemonList = [];

for ($i = 1; $i <= 2000; ++$i) {
    $url = "https://pokeapi.co/api/v2/move/".$i;
    $response = @file_get_contents($url);

    if ($response === false) {
        echo "Error : failed to open stream for URL " . $url . "\n";
        break;
    }
    $capaciteData = json_decode($response, true);
    // if($capaciteData['generation']['name'] == 'generation-i'){
    //     print("$i bad generation \n");
    //     continue;
    // }

    $array = $capaciteData['learned_by_pokemon'];
    $pokemonsLearned = [];
    for($y = 0; $y < count($array); $y++){
        $pokemonsLearned[] =  $array[$y]['name'];
    }
    $array2 = $capaciteData['stat_changes'];
    print($capaciteData['name'] . $i . "\n");
    // sleep(1);
    $statsChange = [];
    for($z = 0; $z < count($array2); $z++){
        $statsChange[] =  [
            $array2[$z]['change'],
            $array2[$z]['stat']['name']
        ];
    };
    // sleep(1);
    $pokemon = [
        'Name' => $capaciteData['name'],
        'Power' => $capaciteData['power'],
        'Type' => $capaciteData['type']['name'],
        'PP' => $capaciteData['pp'],
        'Category' => $capaciteData['damage_class']['name'],
        'Accuracy' => $capaciteData['accuracy'],
        'crit_rate' => $capaciteData['meta']['crit_rate'],
        'Drain' => $capaciteData['meta']['drain'],
        'Healing' => $capaciteData['meta']['healing'],
        'Ailment' => [
            'ailment' => $capaciteData['meta']['ailment']['name'],
            'ailment_chance' => $capaciteData['meta']['ailment_chance']
        ],
        'Stat Changes' => $statsChange,
        'Pkmns Learned' => $pokemonsLearned,
        'Flinch Chance' => $capaciteData['meta']['flinch_chance'],
        'Ailment' => $capaciteData['meta']['ailment']['name'],
    ];
    $pokemonList[$i] = $pokemon;
    $json = json_encode($pokemonList);
    
}
file_put_contents('C:\Users\hcluzel\Desktop\EXOs\PKMN ASCIIv2\resources\capacites.json', $json);
// print_r($pokemonList);
?>