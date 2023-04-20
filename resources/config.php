<?php
//// PARAMETRE APP ///////////////////////////////////////////////
function onDevice(){
    return 'cmd';
}

function colorOn(){
    return false;
}

function styleBox(){
    return '*';
}

function getPathScript($script){
    $link = '';
    switch($script){
        case 'sprites':
            $link = 'Resources/sprites.php';
            break;
    }

    return $link;
}
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
        return [17,34]; // joueur
    }
    else{
        return [7,3]; // enemy
    }
}

function getPosDialogue(){
    return [24,1];
}

function getPosChoice(){
    return [31,0];
}
//// SCALE ///////////////////////////////////////////////
function getScreenScale(){
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

function Vector2Distance($arrayA, $arrayB){
    return [$arrayB[0]-$arrayA[0],$arrayB[1]-$arrayA[1]];
}

function countLinesAndColumns($text, $screenWidth =0) {
    if($screenWidth != 0){
        // Wrap text into lines based on screen width
        $text = wordwrap($text, $screenWidth, "\n");

    }
    // Count number of lines
    $numLines = substr_count($text, "\n") + 1;

    // Count number of columns (characters per line)
    $lines = explode("\n", $text);

    $maxColumns = 0;
    $longestLine = '';
    foreach ($lines as $line) {
        $numColumns = countChar($line);
        if ($numColumns > $maxColumns) {
            $maxColumns = $numColumns;
            $longestLine = $line;
        }
    }
        // $numColumns = countChar($lines[0]);
    return array($numLines, $maxColumns);
}

function countChar($text){
    $chars = str_split($text, 1);
    return count($chars);
}

function debugLog($message, $time = 5){
    if(is_array($message)){
        print_r($message);
    }
    else{
        print($message);
    }
    if(is_int($time) && $time >0){
        sleep($time);
    }
}
?>