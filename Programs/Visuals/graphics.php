<?php
// https://tldp.org/HOWTO/Bash-Prompt-HOWTO/x329.html

class Cursor{
    static function hideCursor(){
        echo "\033[?25l";
    }
    
    static function showCusor(){
        echo "\033[?25h";
    }
    
    static function moveCursor($pos){
        $x = $pos[1];
        $y = $pos[0];
        echo "\033[".$y.";".$x."H";
    } 

    static function moveCursorIndex($pos, $i){
        $x = (int)$pos[1];
        $y = (int)$pos[0]+$i;
        echo "\033[".$y.";".$x."H";
    }  
}

class Display{
    static function drawBox($scale, $pos, $styleH='|', $styleL='-', $corner = true, $cornerStyle = ['+','+','+','+']){
        Cursor::moveCursor($pos);
        
        for ($i = 0; $i < $scale[0]; $i++) {
            Cursor::moveCursorIndex($pos, $i);
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
    
    
    static function drawFullBox($scale, $pos, $style=['*','*','*']){
        Cursor::moveCursor($pos);
        
        for ($i = 0; $i < $scale[0]; $i++) {
            Cursor::moveCursorIndex($pos, $i);
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
    
    static function drawDiagonal($scale, $pos) {
        $height = $scale[0];
        $width = $scale[1];
        for ($i = 1; $i <= $height; $i++) {
            for ($j = 1; $j <= $width; $j++) {
                if ($i == $j) {
                    Cursor::moveCursor([$pos[0]+$i, $pos[1]+$j]);
                    echo "*";
                }
            }
        }
    }    

    static function drawSprite($sprite, $pos) {
        $lines = explode("\n", $sprite); // séparer les lignes du sprite
        for ($i = 0; $i < count($lines); $i++) {
            Cursor::moveCursorIndex($pos, $i);
            echo $lines[$i]; // afficher chaque ligne du sprite
            if($i < count($lines)-1){
                echo "\n";
            }
        }
    }

    //// CLEAR
    static function clear(){
        echo "\033c";
    }
    
    static function clearArea($scale, $pos) {
        for ($i = 0; $i <  $scale[0]; $i++) {
            Cursor::moveCursorIndex($pos, $i);
            for ($j = 0; $j <  $scale[1]; $j++) {
                echo ' ';
            }
        }
    }

    static function clearSprite($pos) : void{
        $posClear = [$pos[0]+1,$pos[1]];
        $scaleClear = Parameters::getScaleSpritePkmn();
        Display::clearArea($scaleClear,$posClear);
    }

    static function  clearGameScreen(){
        $screenScale = Parameters::getScreenScale();
        Display::clearArea([$screenScale[0]-2,$screenScale[1]-2], [2,2]);
    }

    static function setColor($color = 'black'){
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


    //// TEXT
    static function textArea($string, $pos, $scale = 0){
        if($scale != null && $scale != 0){
            $string = Display::textAreaLimited($string, $scale, $pos);
        }
        Cursor::moveCursor($pos);
        echo $string;
    }
    
    static function textAreaLimited($string, $scale = 50, $pos = [26,4]){ //pos dialogue default
        $x = $scale; // taille maximale du texte
    
        // Découpe le texte en plusieurs lignes en respectant une longueur maximale de x caractères par ligne
        $texteDecoupe = wordwrap($string, $x, "\n", true);
    
        // Affiche chaque ligne de texte en respectant la position y
        $lines = explode("\n", $texteDecoupe);
        for ($i = 0; $i < count($lines); $i++) {
            Cursor::moveCursorIndex($pos, $i);
            echo $lines[$i]; // affiche la ligne de texte
        }
    }
    
    static function justifyText($string, $scale, $pos, $where){
        if($where == 'right'){
            // Aligner à droite
            Display::textArea(str_pad($string, $scale, " ", STR_PAD_LEFT),$pos);
        }
        elseif($where == 'center'){
            // Centrer
            $left = intval(($scale - strlen($string)) / 2);
            // $right = ceil(($scale - strlen($string)) / 2);
            $newPos = [$pos[0], $pos[1]+$left];
            Display::textArea($string,$newPos);
        }
    }
}
?>