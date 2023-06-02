<?php
// https://tldp.org/HOWTO/Bash-Prompt-HOWTO/x329.html

//// CURSOR //////////////////////////////////////////
function hideCursor(){
    echo "\033[?25l";
}

function showCusor(){
    echo "\033[?25h";
}

function moveCursor($pos){
    $x = $pos[1];
    $y = $pos[0];
    echo "\033[".$y.";".$x."H";
} 

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
        case 'white':
            $string = '1;37m';
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
        case 'cyan':
            $string = '1;34m';
            break;
        case 'green':
            $string = '0;32m';
            break;
        case 'green light':
            $string = '1;32m';
            break;
        case 'green bug':
            $string = '38;5;118m';
            break;     
        case 'orange':
            $string = '38;5;208m';
            break;
        case 'brown':
            $string = '38;5;202m';
            break;
        case 'yellow':
            $string = '0;33m';
            break;
        case 'grey':
            $string = '1;30m';
            break;
        case 'purple':
            $string = '0;35m';
            break;
        case 'pink':
            $string = '1;35m';
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
            selectColor('white');
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
            selectColor('brown');
            break;
        case 'ground':
            selectColor('orange');
            break;
        case 'bug':
            selectColor('green bug');
            break;
        case 'ice':
            selectColor('cyan');
            break;
        case 'fighting':
            selectColor('brown');
            break;
        case 'poison':
            selectColor('purple');
            break;
        case 'flying':
            selectColor('cyan');
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
            selectColor('grey');
            break;
        case 'steel':
            selectColor('grey');
            break;
        case 'dragon':
            selectColor('blue');
            break;
    }
}


function moveCursorIndex($pos, $i){
    $x = (int)$pos[1];
    $y = (int)$pos[0]+$i;
    echo "\033[".$y.";".$x."H";
}  

function drawBox($scale, $pos, $styleH='|', $styleL='-', $corner = true, $cornerStyle = ['+','+','+','+']){
    moveCursor($pos);
    
    for ($i = 0; $i < $scale[0]; $i++) {
        moveCursorIndex($pos, $i);
        for ($j = 0; $j < $scale[1]; $j++) {
            if($corner){
                if ($i == 0 && $j == 0) {
                    echo $cornerStyle[0];
                } elseif ($i == 0 && $j == $scale[1] - 1) {
                    echo $cornerStyle[1];
                } elseif ($i == $scale[0] - 1 && $j == 0) {
                    echo $cornerStyle[3];
                } elseif ($i == $scale[0] - 1 && $j == $scale[1] - 1) {
                    echo $cornerStyle[2];
                }
                else if ($i == 0 || $i == $scale[0] - 1) {
                    echo $styleL;
                } elseif ($j == 0 || $j == $scale[1] - 1) {
                    echo $styleH;
                } 
                else {
                    echo ' ';
                }
            }
            else if ($i == 0 || $i == $scale[0] - 1) {
                echo $styleL;
            } elseif ($j == 0 || $j == $scale[1] - 1) {
                echo $styleH;
            } 
            else {
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

function drawDiagonal($scale, $pos) {
    $height = $scale[0];
    $width = $scale[1];
    for ($i = 1; $i <= $height; $i++) {
        for ($j = 1; $j <= $width; $j++) {
            if ($i == $j) {
                moveCursor([$pos[0]+$i, $pos[1]+$j]);
                echo "*";
            }
        }
    }
}

function drawGameCadre(){
    drawBox(getScreenScale(),[1,1]);
}

function textArea($string, $pos, $scale = 0){
    if($scale != null && $scale != 0){
        $string = textAreaLimited($string, $scale, $pos);
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

function justifyText($string, $scale, $pos, $where){
    if($where == 'right'){
        // Aligner à droite
        textArea(str_pad($string, $scale, " ", STR_PAD_LEFT),$pos);
    }
    elseif($where == 'center'){
        // Centrer
        $left = intval(($scale - strlen($string)) / 2);
        // $right = ceil(($scale - strlen($string)) / 2);
        $newPos = [$pos[0], $pos[1]+$left];
        textArea($string,$newPos);
    }
}
//////////////////////////////////////////////////////////////
///// CLEAR //////////////////////////////////////////////////

function clear(){
    echo "\033c";
}

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
    $posClearSprite = [$posClearSprite[0],$posClearSprite[1]];
    $scaleClear = getScaleSpritePkmn();
    clearArea($scaleClear,$posClearSprite);
}

//////////////////////////////////////////////////////////////
///// draw SPRITE /////////////////////////////////////////
function drawSprite($sprite, $pos) {
    $lines = explode("\n", $sprite); // séparer les lignes du sprite
    for ($i = 0; $i < count($lines); $i++) {
        moveCursorIndex($pos, $i);
        echo $lines[$i]; // afficher chaque ligne du sprite
        if($i < count($lines)-1){
            echo "\n";
        }
    }
}

function drawSpritePkmn($pkmn, $isJoueur){
    $posFinal = getPosSpritePkmn($isJoueur);
    
    drawSprite(getSprites($pkmn['Sprite']), $posFinal);
}
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
?>