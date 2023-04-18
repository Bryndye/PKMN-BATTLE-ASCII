<?php
// AIDE CODE TERMINAL
// echo "\033[?25l"; //hide cursor
// echo "\033[?25h"; //show cursor

// https://tldp.org/HOWTO/Bash-Prompt-HOWTO/x329.html


//// STANDARD FCT DRAW ///////////////////////////////
function selectColor($color = 'black'){
    if(is_int($color)){
        echo "\033[".$color;
        return;
    }

    $string = '0m';
    switch($color){
        case 'reset':
            $string = '0m'; //reset style text
            break;
        case 'black':
            $string = '30m';
            break;
        case 'red':
            $string = '31;40m';
            break;
        case 'blue':
            $string = '34m';
            break;
        case 'green':
            $string = '0;32m';
            break;
        case 'orange':
            $string = '0;31m';
            break;
        case 'yellow':
            $string = '14';
            break;
        case 'grey':
            $string = '8';
            break;
        case 'purple':
            $string = '5';
            break;
        case 'pink':
            $string = '12';
            break;
        case 'health':
            $string = '38;2;255;165;0';
            break;
    }
    echo "\033[".$string;
}

function getColorByType($type = 'normal'){
    switch($type){
        case 'normal':
            selectColor(0);
            break;
        case 'grass':
            selectColor('green');
            break;
        case 'water':
            selectColor('blue');
            break;
        case 'fire':
            selectColor('red');
            break;
        case 'electric':
            selectColor('yellow');
            break;
        case 'rock':
            selectColor(6);
            break;
        case 'ground':
            selectColor(3);
            break;
        case 'bug':
            selectColor(10);
            break;
        case 'ice':
            selectColor('ice');
            break;
        case 'fighting':
            selectColor('brown');
            break;
        case 'poison':
            selectColor('purple');
            break;
        case 'flying':
            selectColor(11);
            break;
        case 'psychic':
            selectColor('pink');
            break;
        case 'ghost':
            selectColor('purple');
            break;
        case 'fairy':
            selectColor('pink');
            break;
        case 'dark':
            selectColor('black');
            break;
        case 'steel':
            selectColor('grey');
            break;
        case 'dragon':
            selectColor(1);
            break;
    }
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

function drawBox($scale, $pos, $styleH='*', $styleL='*'){
    moveCursor($pos);
    
    for ($i = 0; $i < $scale[0]; $i++) {
        moveCursorIndex($pos, $i);
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

function drawFullBox($scale, $pos, $style=['*','*','*']){
    moveCursor($pos);
    
    for ($i = 0; $i < $scale[0]; $i++) {
        moveCursorIndex($pos, $i);
        for ($j = 0; $j < $scale[1]; $j++) {
            if ($i == 0 || $i == $scale[0] - 1) {
                echo $style[0];
            } elseif ($j == 0 || $j == $scale[1] - 1) {
                echo $style[1];
            } else {
                echo $style[2];
            }
        }
    }
}

function drawGameCadre(){
    drawBox([30,60],[1,1]);
}

function textArea($string, $pos, $scale = 0){
    if($scale != null && $scale != 0){
        $string = textAreaLimited($string, $scale);
    }
    moveCursor($pos);
    echo $string;
}

function textAreaLimited($string, $scale = 50, $pos = [26,4]){ //pos dialogue default
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

function justifyText($string, $scale, $comble, $where){
    $align = STR_PAD_LEFT;
    if($where == 'right'){
        $align = STR_PAD_RIGHT;
    }
    else if($where == 'left'){
        $align = STR_PAD_LEFT;
    }
    return str_pad($string, 3, " ", $align);
}
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////


///// CLEAR /////////////////////////////////////////
function clearArea($scale, $pos){
    for ($i = 0; $i <  $scale[0]; $i++) {
        moveCursorIndex($pos, $i);
        for ($j = 0; $j <  $scale[1]; $j++) {
            echo ' ';
        }
    }
}

function clearGameScreen(){
    $screenScale = getScreenScale();
    clearArea([$screenScale[0]-2,$screenScale[1]-2], [2,2]);
}

function clearGameplayScreen(){
    // clear screen hors boit ede dialogue
    $screenScale = getScreenScale();
    $boiteDialogueScale = getScaleDialogue();
    clearArea([$screenScale[0]-$boiteDialogueScale[0]-1,$screenScale[1]-2], [2,2]);
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



///// draw SPRITE /////////////////////////////////////////
function drawSprite($sprite, $pos) {
    $lines = explode("\n", $sprite); // séparer les lignes du sprite
    for ($i = 1; $i < count($lines); $i++) {
        moveCursorIndex($pos, $i);
        echo $lines[$i]; // afficher chaque ligne du sprite
        echo "\n";
    }
}

function drawSpritePkmn($pkmn, $isJoueur){
    $posFinal = getPosSpritePkmn($isJoueur);
    
    include 'Resources/sprites.php';
    drawSprite($sprites[$pkmn['Sprite']], $posFinal);
}
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
?>