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


//// STANDARD FCT DRAW ///////////////////////////////
function selectColor(){
    //\033[0m permet de remettre la couleur par defaut
    //\033[31;40m 31:rouge & 40:noir
    echo "\033[31;40mtexte rouge sur fond noir\033[0m";
}

function moveCursor($pos){
    $x = $pos[1];
    $y = $pos[0];
    echo "\033[".$y.";".$x."H";
} 

function moveCursorIndex($pos, $i){
    $x = (int)$pos[1];
    $y = (int)$pos[0]+$i;
    echo "\033[".$y.";".$x."H";
}  

// DISPLAY A BOX
function displayBox($scale, $pos, $styleH='*', $styleL='*'){
    moveCursor($pos);
    
    for ($i = 0; $i < $scale[0]; $i++) {
        moveCursorIndex($pos, $i);
        // echo "\033[".$pos[0]+$i.";".$pos[1]."H";
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
    displayBox([30,60],[1,1]);
}

function writeSentence($string, $pos, $scale = 0){
    if($scale != null && $scale != 0){
        $string = limitSentence($string, $scale);
    }
    moveCursor($pos);
    echo $string;
}

function limitSentence($string, $scale = 50, $pos = [26,4]){
    $x = $scale; // taille maximale du texte

    // Découpe le texte en plusieurs lignes en respectant une longueur maximale de x caractères par ligne
    $texteDecoupe = wordwrap($string, $x, "\n", true);

    // Affiche chaque ligne de texte en respectant la position y
    $lines = explode("\n", $texteDecoupe);
    for ($i = 0; $i < count($lines); $i++) {
        moveCursorIndex($pos, $i);
        echo $lines[$i]; // affiche la ligne de texte
    }
}

function alignText($string, $scale, $comble, $where){
    $align = STR_PAD_LEFT;
    if($where == 'right'){
        $align = STR_PAD_RIGHT;
    }
    else if($where == 'left'){
        $align = STR_PAD_LEFT;
    }
    $phrase_alignee = str_pad($string, 3, " ", STR_PAD_LEFT);
}
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////


///// CLEAR /////////////////////////////////////////
function clearArea($scale, $pos){
    for ($i = 0; $i <  $scale[0]; $i++) {
        // echo "\033[".$pos[0]+$i.";".$pos[1]."H";
        moveCursorIndex($pos, $i);
        for ($j = 0; $j <  $scale[1]; $j++) {
            echo ' ';
        }
    }
}

function clearInGame(){
    clearArea([28,58], [2,2]);
}

function clear(){
    echo "\033c";
}

function clearSprite($pos){
    $posClearSprite = [$pos[0]+1,$pos[1]];
    $scaleClear = getScaleSpritePkmn();
    clearArea($scaleClear,$posClearSprite);
}

function clearSpritePkmn($isJoueur, $pauseTime = 0){
    if($pauseTime != 0){
        if($pauseTime > 100){
            usleep($pauseTime);
        }
        else{
            sleep($pauseTime);
        }
    }
    $posClearSprite = getPosSpritePkmn($isJoueur);
    $posClearSprite = [$posClearSprite[0]+1,$posClearSprite[1]];
    $scaleClear = getScaleSpritePkmn();
    clearArea($scaleClear,$posClearSprite);
}

//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////



///// DISPLAY SPRITE /////////////////////////////////////////
function displaySprite($sprite, $pos) {
    $lines = explode("\n", $sprite); // séparer les lignes du sprite
    for ($i = 1; $i < count($lines); $i++) {
        // echo "\033[".$pos[0]+$i.";".$pos[1]."H";       
        moveCursorIndex($pos, $i);
        echo $lines[$i]; // afficher chaque ligne du sprite
        echo "\n";
    }
}

function displaySpritePkmn($pkmn, $isJoueur){
    $posFinal = getPosSpritePkmn($isJoueur);
    
    include 'visuals/sprites.php';
    displaySprite($sprites[$pkmn['Sprite']], $posFinal);
}
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////


//// DISPLAY DIALOGUE ///////////////////////////////////////////
function displayBoiteDialogue(){
    displayBox(getScaleDialogue(), getPosDialogue());
}

function messageBoiteDialogue($message, $pressEnter = false){
    // clearBoiteDialogue();
    displayBoiteDialogue();
    limitSentence($message);
    if($pressEnter){
        waitForInput();
    }
    else{
        sleep(1);
    }
}
function messageBoiteDialogueContinue($message, $time = 0){
    clearBoiteDialogue();
    limitSentence($message);
    sleep($time);
}
function clearBoiteDialogue(){
    $pos = getPosDialogue();
    $scale = getScaleDialogue();
    clearArea([$scale[0]-2, $scale[1]-2],[$pos[0]+1, $pos[1]+1]); //clear boite dialogue
}

function displayChoiceMenuRight(){
    displayBox([7,1],[23,43]);
}

//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////


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