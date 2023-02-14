<?php
// Affiche la structure 
// -- [ HAUTEUR , LARGEUR] --
// displayBox([29,60],[1,1]);
// clearArea([27,58],[2,2]); // Efface l'écran

// AIDE CODE TERMINAL
// echo "\033[?25l"; //hide cursor
// echo "\033[?25h"; //show cursor
// echo "\033[7;7H"; //deplace cursor
// echo "\033[31;40mtexte rouge sur fond noir\033[0m"; // change la couleur

// https://tldp.org/HOWTO/Bash-Prompt-HOWTO/x329.html
function selectColor(){
    //\033[0m permet de remettre la couleur par defaut
    //\033[31;40m 31:rouge & 40:noir
    echo "\033[31;40mtexte rouge sur fond noir\033[0m";
}

function moveCursor($pos){
    echo "\033[".$pos[0].";".$pos[1]."H";
}   

// DISPLAY A BOX
function displayBox($scale, $pos, $styleH='*', $styleL='*'){
    moveCursor($pos);
    // echo "\033[".$pos[0].";".$pos[1]."H";
    
    for ($i = 0; $i < $scale[0]; $i++) {
        echo "\033[".$pos[0]+$i.";".$pos[1]."H";
        for ($j = 0; $j < $scale[1]; $j++) {
            if ($i == 0 || $i == $scale[0] - 1) {
                echo $styleL;
            } elseif ($j == 0 || $j == $scale[1] - 1) {
                echo $styleH;
            } else {
                echo ' ';
            }
        }
    }
}

function displayGameCadre(){
    displayBox([29,60],[1,1]);
}

// -- CLEAR ------------------------------------------
function clearArea($scale, $pos){
    for ($i = 0; $i <  $scale[0]; $i++) {
        echo "\033[".$pos[0]+$i.";".$pos[1]."H";
        for ($j = 0; $j <  $scale[1]; $j++) {
            echo ' ';
        }
    }
}

function clearInGame(){
    clearArea([27,58], [2,2]);
}

function clear(){
    echo "\033c";
}

function clearSpritePkmn($isJoueur, $pauseTime = 0){
    if($pauseTime != 0){
        sleep($pauseTime);
    }
    $posClearSprite = getPosSpritePkmn($isJoueur);
    $posClearSprite = [$posClearSprite[0]+1,$posClearSprite[1]];
    $scaleClear = getScaleSpritePkmn();
    clearArea($scaleClear,$posClearSprite);
}
// function clearSpritePkmn($isJoueur){
//     $posFinal = getPosSpritePkmn($isJoueur);
//     // clear area pkmn sprite in battle
//     clearArea([13,25],$posFinal);
// }

// ----------------------------------------------------

function displaySprite($sprite, $pos) {
    $lines = explode("\n", $sprite); // séparer les lignes du sprite
    for ($i = 1; $i < count($lines); $i++) {
        echo "\033[".$pos[0]+$i.";".$pos[1]."H";
        echo $lines[$i]; // afficher chaque ligne du sprite
        echo "\n";
    }
}

function displaySpritePkmn($pkmn, $isJoueur){
    $posFinal = getPosSpritePkmn($isJoueur);
    
    include 'visuals/sprites.php';
    displaySprite($pokemonSprites[$pkmn['Sprite']], $posFinal);
}

function messageBoiteDialogue($message){
    clearArea([5,58],[24,2]); //clear boite dialogue
    echo "\033[25;3H";
    echo $message;
    // sleep(1);
    // waitForInput([30,0]);
}


function debugLog($pos, $msg){
    moveCursor($pos);
    if(is_array($msg)){
        print_r($msg);
    }
    else{
        echo 'Debug : ' . $msg;
    }
}
?>