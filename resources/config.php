<?php
// AIDE CODE TERMINAL
// echo "\033[?25l"; //hide cursor
// echo "\033[?25h"; //show cursor
// echo "\033[7;7H"; //deplace cursor
// echo "\033[31;40mtexte rouge sur fond noir\033[0m"; // change la couleur

// Affiche la structure 
// -- [ HAUTEUR , LARGEUR] --
// displayBox([29,60],[1,1]);
// clearArea([27,58],[2,2]); // Efface l'écran

// -- HUD PKMN--
// - Afficher HUD du pkmn joueur -
// createPkmnHUD(17,34, $pkmn1);
// displaySprite($pokemonSprites[$pkmn1['Sprite']], 9, 3); 
// - Afficher HUD du pkmn ennemi -
// createPkmnHUD(2,3, $pkmn2);
// displaySprite($pokemonSprites[$pkmn2['Sprite']], 1, 35);

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
?>