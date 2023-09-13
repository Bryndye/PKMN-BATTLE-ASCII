<?php
$json = file_get_contents('../Resources/Pokemons/pokemonsv2.json');
$pokemons = json_decode($json, true);

foreach($pokemons as $pkmn){
    $pkmn['Name'] = ucfirst($pkmn['Name']);
    $pkmn['evolution']['after']['Name'] = ucfirst($pkmn['evolution']['after']['Name']);
}   

$json = json_encode($pokemons);
print_r($pokemons);
sleep(50);
file_put_contents('../Resources/Pokemons/pokemonsv2.json', $json); // envoyer le cod
?>