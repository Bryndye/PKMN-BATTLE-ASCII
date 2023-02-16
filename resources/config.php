<?php
// -- POSITIONS --------------------------------------------
$posSpritePkmnEnemy = [1,31];
$posSpritePkmnJoueur = [8,2];
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

$scaleSpritePkmn = [15,28];
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

$posTeamE = [7,3];
$posTeamJ = [17,34];
function getPosTeam($isJoueur){
    global $posTeamJ, $posTeamE;
    
    if($isJoueur){
        $posFinal = $posTeamJ;
    }
    else{
        $posFinal = $posTeamE;
    }
    return $posFinal;
}

$scaleHUDPkmn = [5,25];
function getScaleHUDPkmn(){
    global $scaleHUDPkmn;
    return $scaleHUDPkmn;
}

$scaleBoiteDialogue = [7,60];
function getScaleDialogue(){
    global $scaleBoiteDialogue;
    return $scaleBoiteDialogue;
}

$posBoiteDialogue = [24,1];
function getPosDialogue(){
    global $posBoiteDialogue;
    return $posBoiteDialogue;
}

$posCHocie = [31,0];
function getPosChoice(){
    global $posCHocie;
    return $posCHocie;
}
///////////////////////////////////////////////////////

?>