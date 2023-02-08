<?php
// -- POSITIONS --------------------------------------------
$posSpritePkmnEnemy = [1,35];
$posSpritePkmnJoueur = [7,2];
function getPosSpritePkmn($isJoueur){
    // Pour get une var global d'un script il faut créer le global dans la function
    global $posSpritePkmnEnemy, $posSpritePkmnJoueur;
    
    if($isJoueur){
        $posFinal = $posSpritePkmnJoueur;
    }
    else{
        $posFinal = $posSpritePkmnEnemy;
    }
    return $posFinal;
}

$scaleSpritePkmn = [15,25];
function getScaleSpritePkmn(){
    global $scaleSpritePkmn;
    return $scaleSpritePkmn;
}
$posHealthPkmnEnemy = [2,3];
$posHealthPkmnJoueur = [18,34];
function getPosHealthPkmn($isJoueur){
    global $posHealthPkmnJoueur, $posHealthPkmnEnemy;
    
    if($isJoueur){
        $posFinal = $posHealthPkmnJoueur;
    }
    else{
        $posFinal = $posHealthPkmnEnemy;
    }
    return $posFinal;
}

$scaleHUDPkmn = [5,25];
function getScaleHUDPkmn(){
    global $scaleHUDPkmn;
    return $scaleHUDPkmn;
}

$scaleBoiteDialogue = [5,58];
function getScaleDialogue(){
    global $scaleBoiteDialogue;
    return $scaleBoiteDialogue;
}

$posBoiteDialogue = [24,2];
function getPosDialogue(){
    global $posBoiteDialogue;
    return $posBoiteDialogue;
}

$posCHocie = [30,0];
function getPosChoice(){
    global $posCHocie;
    return $posCHocie;
}
// ----------------------------------------------------

?>