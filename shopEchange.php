<?php
function wantNewPkmn(){
    // include 'resources/pokemonList.php';
    $indexPkmn = random_int(1, count(getPokedex()));
    $newPkmn = getPkmnFromPokedex($indexPkmn);
    print_r($newPkmn);
    sleep(20);
}
?>