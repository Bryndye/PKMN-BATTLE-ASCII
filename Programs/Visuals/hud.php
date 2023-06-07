<?php
class Display_Game{
    static function drawSpritePkmn($pkmn, $isJoueur){
        $posFinal = Parameters::getPosSpritePkmn($isJoueur);
        
        Display::drawSprite(getSprites($pkmn['Sprite']), $posFinal);
    }

    static function drawGameCadre(){
        Display::drawBox(Parameters::getScreenScale(),[1,1]);
    }

    static function drawSkeletonHUD(){
        Display_Game::drawGameCadre();
        Display_Game::drawBoiteDialogue();
    }

    static function setColorByType($type = 'normal'){
        switch($type){
            case 'normal':
                Display::setColor('white');
                break;
            case 'grass':
                Display::setColor('green');
                break;
            case 'water':
                Display::setColor('blue');
                break;
            case 'fire':
                Display::setColor('red');
                break;
            case 'electric':
                Display::setColor('yellow');
                break;
            case 'rock':
                Display::setColor('brown');
                break;
            case 'ground':
                Display::setColor('orange');
                break;
            case 'bug':
                Display::setColor('green bug');
                break;
            case 'ice':
                Display::setColor('cyan');
                break;
            case 'fighting':
                Display::setColor('brown');
                break;
            case 'poison':
                Display::setColor('purple');
                break;
            case 'flying':
                Display::setColor('cyan');
                break;
            case 'psychic':
                Display::setColor('pink');
                break;
            case 'ghost':
                Display::setColor('purple');
                break;
            case 'fairy':
                Display::setColor('pink');
                break;
            case 'dark':
                Display::setColor('grey');
                break;
            case 'steel':
                Display::setColor('grey');
                break;
            case 'dragon':
                Display::setColor('blue');
                break;
    
            case 'physical':
                Display::setColor('red');
                break;
            case 'special':
                Display::setColor('blue');
                break;
            case 'status':
                Display::setColor('white');
                break;
            case 'exp':
                Display::setColor('cyan');
                break;
        }
    }

    //// CLEAR
    static function clearGameplayScreen(){
        // clear screen hors boit ede dialogue
        $screenScale = Parameters::getScreenScale();
        $boiteDialogueScale = Parameters::getScaleDialogue();
        Display::clearArea([$screenScale[0]-$boiteDialogueScale[0]-1,$screenScale[1]-2], [2,2]);
    }
    
    static function clearSpritePkmn($isJoueur, $pauseTime = 0){
        if($pauseTime != 0){
            if($pauseTime > 100){
                usleep($pauseTime);
            }
            else{
                sleep($pauseTime);
            }
        }
        $posClearSprite = Parameters::getPosSpritePkmn($isJoueur);
        $scaleClear = Parameters::getScaleSpritePkmn();
        Display::clearArea($scaleClear,$posClearSprite);
    }

    //// DRAW DIALOGUE ///////////////////////////////////////////
    static function drawBoiteDialogue(){
        Display::drawBox(Parameters::getScaleDialogue(), Parameters::getPosDialogue(), '|','-',true,['|','|','+','+']);
    }

    static function messageBoiteDialogue($message, $time = 0){
        Display_Game::drawBoiteDialogue();
        Display_Game::clearBoiteDialogue();
        Display::textAreaLimited($message);
        if($time >= 0){
            sleep($time);
        }
        elseif($time < 0){
            waitForInput();
        }
    }


    static function clearBoiteDialogue(){
        $pos = Parameters::getPosDialogue();
        $scale = Parameters::getScaleDialogue();
        Display::clearArea([$scale[0]-2, $scale[1]-2],[$pos[0]+1, $pos[1]+1]); //clear boite dialogue
    }
}
//// DRAW HUB PLACE ///////////////////////////////////////////

function drawMoney($pos = null, $currentMoney = null){
    if($pos == null){
        $pos = [5,38];
    }
    if(!is_numeric($currentMoney)){
        $money = getDataFromSave('Money', Parameters::getSavePath('save'));
    }
    else{
        $money = $currentMoney;
    }

    $posY = $pos[0];
    $posX = $pos[1];
    $scaleX = 15;
    Display::drawBox([3,$scaleX],[$posY,$posX]);
    Display::justifyText('Pokedols', $scaleX,[$posY,$posX], 'center');
    Display::justifyText(CustomFunctions::formatMoney($money), $scaleX-3,[$posY+1,$posX+1], 'right');
}

function drawCategorySelected($categories, $caterogySelected, $pos){
    // pos = 4,2
    Display::drawBox([1,Parameters::getScreenScale()[1]-2],$pos,'-','-'); // pos pour mettre la ligne en dessous des categories

    $newPosX = $pos[1]+1;
    $posYCategory = $pos[0]-1;
    foreach($categories as $category){
        if($category == $caterogySelected){
            $scale = CustomFunctions::countLinesAndColumns($category);
            Display::drawBox([$scale[0]+2,$scale[1]+2],[$posYCategory-1,$newPosX-1],'|','-',true);
            Display::clearArea([1,$scale[1]], [$posYCategory+1,$newPosX]);
        }
        Display::textArea($category,[$posYCategory,$newPosX]);
        $newPosX = CustomFunctions::countLinesAndColumns($category)[1]+2+$newPosX;
    }
}


//////////////////////////////////////////////////////////////
//// COLOR TEXT///////////////////////////////////////////////

function textColored($text, $color) {
    $colorCode = Display::setColor($color);

    echo "\033[{$colorCode}m{$text}\033[0m\n";
}

function textColoredByType($text, $color) {
    $colorCode = Display_Game::setColorByType($color);
    
    echo "\033[{$colorCode}m{$text}\033[0m\n";
}



//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
function drawBoxTitle($pos, $scale, $title){
    Display::drawBox($scale,$pos);
    Display::textArea($title, [$pos[0]+intval($scale[0]/2),$pos[1]+2]);
}

function drawBoxTextJusitfy($pos, $choices){
    $posY = $pos[0];
    $posX = $pos[1];

    // Calcul the max length to draw the box
    $maxLength = 0;
    for($i=0; $i<count($choices);++$i){
        $maxLength = strlen($choices[$i]) > $maxLength ? strlen($choices[$i]) : $maxLength;
    }
    Display::drawBox([count($choices)*2+3,$maxLength+5],[$posY,$posX]);

    // Draw each lines
    for($i=0; $i<count($choices);++$i){
        Display::textArea($choices[$i], [$posY+2*($i+1),$posX+2]);
        $maxLength = strlen($choices[$i]) > $maxLength ? strlen($choices[$i]) : $maxLength;
    }
}

function Name($string){
    return ucfirst($string);
}
?>