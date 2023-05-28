<?php
function addPkmnToPokedex($pkmn, $type){
    $main = getSave(getSavePath('myGame'));
    if(!array_key_exists($pkmn['N Pokedex'], $main['Pokedex'])){
        $main['Pokedex'][$pkmn['N Pokedex']] = getTypePkmnToPokedex($type);
    }
    ksort($main['Pokedex']);
    setData($main['Pokedex'], 'Pokedex', getSavePath('myGame'));
}

function getTypePkmnToPokedex($type){
    // type : 0, 1:see, 2:catch
    switch($type){
        default:
            return 0;
        case 'see':
            return 1;
        case 'catch':
            return 2;
    }
}

function countPkmnCatchFromPokedex(){
    $main = getSave(getSavePath('myGame'));
    $result = array_filter($main['Pokedex'], function($value) {
        return $value == 2;
    });
    return count($result);
}
?>