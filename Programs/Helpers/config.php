<?php
class Parameters{
    static function getPathScript($script){
        $link = '';
        switch($script){
            case 'sprites':
                $link = 'Resources/sprites.php';
                break;
        }
    
        return $link;
    }
    
    //// MENU LIST SCROLLING ///////////////////////////////////////////
    static function getAllCategoriesItem(){
        return [Parameters::getTypeItemBag('Heals'),
                Parameters::getTypeItemBag('PokeBalls'),
                Parameters::getTypeItemBag('Items'),
                Parameters::getTypeItemBag('TMs')
            ];
    }

    static function getTypeItemBag($type = 'Heals'){
        switch($type){
            case 'PokeBalls':
                return 'PokeBalls';
            case 'TMs':
                return 'TMs';   
            case 'Heals':
                return 'Heals';
            case 'Items':
                return 'Items';     
        }
    }
    
    static function getCategoryName($categories, $actualCategory){
        if(is_int($actualCategory)){
            return $categories[$actualCategory];
        }
    }
    
    static function getMessageBoiteDialogue($Mode = 'use', $sentence = 'Which item to use?'){
        $string = $sentence."\n   z   \n<q   d>";
        if($Mode == 'use'){
            $string .= "  Use : v\n   s";
        }
        elseif($Mode == 'count'){
            $string .= "  Find by number : ***\n   s";
        }
        else{
            $string .= "\n   s";
        }
        return$string;
    }
    
    //// SAVES ///////////////////////////////////////////////
    
    static function getParameterPathSave(){
        return 1;
    }
    
    static function getSavePath($name = 'save'){
        if($name == 'save'){
            return Parameters::getFolderSave(Parameters::getParameterPathSave()).'save.json';
        }
        else{
            return Parameters::getFolderSave(Parameters::getParameterPathSave()).'myGame.json';
        }
    }
    
    static function getFolderSave($state = 0){
        if($state == 0){
            return 'Save/';
        }
        else{
            return '../Save/';
        }
    }
    
    static function getIndexFloorMaxOriginal(){
        return 110;
    }
    //// POSITIONS ///////////////////////////////////////////////
    static function getPosSpritePkmn($isJoueur) : array{
        if($isJoueur)
        {
            return [9,2]; // joueur
        }
        else{
            return [2,31]; // enemy
        }
    }
    
    static function getPosSpriteTrainer($isJoueur) : array{
        if($isJoueur)
        {
            return [2,2]; // joueur
        }
        else{
            return [2,41]; // enemy
        }
    }
    
    static function getPosHealthPkmn($isJoueur) : array{    
        if($isJoueur){
            return [18,34]; // joueur
        }
        else{
            return [2,3]; // enemy
        }
    }
    
    static function getPosTeam($isJoueur) : array{    
        if($isJoueur){
            return [17,34]; // joueur
        }
        else{
            return [7,3]; // enemy
        }
    }
    
    static function getPosPlaceHUD() : array{
        return [3,5];
    }
    
    static function getPosMenuHUD() : array{
        return [7,5];
    }
    
    static function getPosDialogue() : array{
        return [24,1];
    }
    
    static function getPosChoice() : array{
        return [31,0];
    }
    
    static function getPosYesOrNo(){
        $scaleDialogue = Parameters::getScaleDialogue();
        $screenScale = Parameters::getScreenScale();
        $scale = Parameters::getScaleYesOrNo();
        return [$screenScale[0]-($scaleDialogue[0]+$scale[0]), $screenScale[1]-2-$scale[1]];
    }
    //// SCALE ///////////////////////////////////////////////
    static function getScreenScale() : array{
        return [30,60];
    }
    
    static function getScaleSpritePkmn() : array{
        return [15,28];
    }
    
    
    static function getScaleHUDPkmn() : array{
        return [5,25];
    }
    
    static function getScaleDialogue() : array{
        return [7,60];
    }
    
    static function getScaleYesOrNo() : array{
        return [5,10];
    }
}

class CustomFunctions{
    static function multipleOf($number, $multiple) {
        $result = bcdiv($number, $multiple, 0); // 0 decimal places
        return $result;
    }
    
    static function remove(&$var, &$array) {
        $index = array_search($var, $array);
        if ($index !== false) {
            unset($array[$index]);
        }
    }
    
    static function add($name, &$array, $value){
        if (array_key_exists($name, $array)) {
            $array[$name] += $value;
        } else {
            $array[$name] = $value;
        }
    }
    
    static function formatMoney($int){
        return number_format($int, 0, '.', ' ').'P';
    }
    
    static function Vector2Distance($arrayA, $arrayB){
        return [$arrayB[0]-$arrayA[0],$arrayB[1]-$arrayA[1]];
    }
    
    static function countLinesAndColumns($text, $screenWidth =0) {
        if($screenWidth != 0){
            // Wrap text into lines based on screen width
            $text = wordwrap($text, $screenWidth, "\n");
    
        }
        // Count number of lines
        $numLines = substr_count($text, "\n") + 1;
    
        // Count number of columns (characters per line)
        $lines = explode("\n", $text);
    
        $maxColumns = 0;
        // $longestLine = '';
        foreach ($lines as $line) {
            $numColumns = CustomFunctions::countChar($line);
            if ($numColumns > $maxColumns) {
                $maxColumns = $numColumns;
                // $longestLine = $line;
            }
        }
            // $numColumns = CustomFunctions::countChar($lines[0]);
        return array($numLines, $maxColumns);
    }
    
    static function countChar($text){
        $chars = str_split($text, 1);
        return count($chars);
    }
    
    static function debugLog($message, $time = 5){
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
}

?>