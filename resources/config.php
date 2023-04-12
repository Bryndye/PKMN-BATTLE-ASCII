<?php

//// POSITIONS ///////////////////////////////////////////////
function getPosSpritePkmn($isJoueur){
    if($isJoueur){
        return [8,2]; // joueur
    }
    else{
        return [1,31]; // enemy
    }
}

function getPosHealthPkmn($isJoueur){    
    if($isJoueur){
        return [18,34]; // joueur
    }
    else{
        return [2,3]; // enemy
    }
}

function getPosTeam($isJoueur){    
    if($isJoueur){
        $posFinal = [17,34]; // joueur
    }
    else{
        $posFinal = [7,3]; // enemy
    }
    return $posFinal;
}

function getPosDialogue(){
    return [24,1];
}

function getPosChoice(){
    return [31,0];
}
//// SCALE ///////////////////////////////////////////////
function screenScale(){
    return [30,60];
}

function getScaleSpritePkmn(){
    return [15,28];
}


function getScaleHUDPkmn(){
    return [5,25];
}

function getScaleDialogue(){
    return [7,60];
}


///////////////////////////////////////////////////////
//// CUSTOM FUNCTIONS /////////////////////////////////

function multipleOf($number, $multiple) {
    $result = bcdiv($number, $multiple, 0); // 0 decimal places
    return $result;
}

function remove(&$var, &$array) {
    $index = array_search($var, $array);
    if ($index !== false) {
        unset($array[$index]);
    }
}

function add($name, &$array, $value){
    if (array_key_exists($name, $array)) {
        $array[$name] += $value;
    } else {
        $array[$name] = $value;
    }
}
?>