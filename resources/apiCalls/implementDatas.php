<?php
$json = file_get_contents('../../json/pokemons.json');
$jsonEvol = file_get_contents('../../json/pokemonsEvolutions.json');

$pokemonPokedex = json_decode($json, true);
$pokemonEvolutions = json_decode($jsonEvol, true);
$newArray = array();
foreach ($pokemonPokedex as $key => $value) {
    if (isset($value['Name'])) {
        $newArray[$value['Name']] = $value;
    } else {
        $newArray[$key] = $value;
    }
}

foreach($newArray as &$pokemon){
    foreach($pokemonEvolutions as $family){
        for($i=0;$i<count($family);$i++){
            $pkmnE = &$family[$i];

            if($pokemon['Name'] == $pkmnE){
                // print_r($pokemon['Name']);
                // sleep(1);

                if(isset($family[1])){
                    // print_r($family[1]);
                    // sleep(50);

                    if(isset($family[1]) && isset($newArray[$family[1][0]])){
                        $pokemon['evolutions']['after'] = [
                            'Name'=>$family[1][0], 
                            'min level'=> isset($family[1][1]['min_level'])? $family[1][1]['min_level'] : 16, 
                            'stade'=> 2
                        ];
                        // stade 1 : 64*4
                    }

                    if(isset($family[2]) && isset($newArray[$family[2][0]])){
                        // print_r($newArray[$family[1][0]]);
                        // sleep(50);
                        // $newArray[$family[1][0]]['evolutions']['after'] = [$family[2][0], 
                        // isset($family[2][1]['min_level'])? $family[2][1]['min_level'] : 36];
                        $newArray[$family[1][0]]['evolutions']['after'] = [
                            'Name'=>$family[2][0], 
                            'min level'=> isset($family[2][1]['min_level'])? $family[2][1]['min_level'] : 36, 
                            'stade'=> 3
                        ];
                        // stade 2 : 64*4
                    }
                }
            }
        }
    }  
}
// print_r($newArray);
// sleep(50);

$json = json_encode($newArray);
file_put_contents('../../json/pokemonsv1.json', $json); // envoyer le cod
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