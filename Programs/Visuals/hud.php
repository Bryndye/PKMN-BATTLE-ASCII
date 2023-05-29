<?php
//// DRAW HUB PLACE ///////////////////////////////////////////

function drawMoney($pos = null, $currentMoney = null){
    if($pos == null){
        $pos = [5,38];
    }
    if(!is_numeric($currentMoney)){
        $money = getDataFromSave('Money', getSavePath('save'));
    }
    else{
        $money = $currentMoney;
    }

    $posY = $pos[0];
    $posX = $pos[1];
    $scaleX = 15;
    drawBox([3,$scaleX],[$posY,$posX]);
    justifyText('Pokedols', $scaleX,[$posY,$posX], 'center');
    justifyText(formatMoney($money), $scaleX-3,[$posY+1,$posX+1], 'right');
}


function drawNextFloor($pos){
    $posY = $pos[0];
    $posX = $pos[1];
    drawBox([10,30],[$posY,$posX]);

    $saveFight = getSave(getSavePath('save'));
    justifyText('NEXT', 30, $pos, 'center');
    textArea('Floor : '.$saveFight['IndexFloor'], [$posY+2,$posX+2]);

    $currentRoute = getRouteFromIndex($saveFight['IndexFloor'],true);
    $pnj = checkPNJExist($saveFight['IndexFloor']);
    if(!is_null($currentRoute)){
        textArea('Route : '.$currentRoute, [$posY+4,$posX+2]);

        if(!is_null($pnj)){
            textArea('Trainer : '.$pnj['Name'], [$posY+6,$posX+2]);
        }
    }
    else{
        if(!is_null($pnj)){
            textArea('Trainer : '.$pnj['Name'], [$posY+4,$posX+2]);
        }
    }
}

function drawCategorySelected($categories, $caterogySelected, $pos){
    // pos = 4,2
    drawBox([1,getScreenScale()[1]-2],$pos,'-','-'); // pos pour mettre la ligne en dessous des categories

    $newPosX = $pos[1]+1;
    $posYCategory = $pos[0]-1;
    foreach($categories as $category){
        if($category == $caterogySelected){
            $scale = countLinesAndColumns($category);
            drawBox([$scale[0]+2,$scale[1]+2],[$posYCategory-1,$newPosX-1],'|','-',true);
            clearArea([1,$scale[1]], [$posYCategory+1,$newPosX]);
        }
        textArea($category,[$posYCategory,$newPosX]);
        $newPosX = countLinesAndColumns($category)[1]+2+$newPosX;
    }
}
//// DRAW DIALOGUE ///////////////////////////////////////////
function drawBoiteDialogue(){
    drawBox(getScaleDialogue(), getPosDialogue());
}

function messageBoiteDialogue($message, $time = 0){
    drawBoiteDialogue();
    clearBoiteDialogue();
    textAreaLimited($message);
    if($time >= 0){
        sleep($time);
    }
    elseif($time < 0){
        waitForInput();
    }
}


function clearBoiteDialogue(){
    $pos = getPosDialogue();
    $scale = getScaleDialogue();
    clearArea([$scale[0]-2, $scale[1]-2],[$pos[0]+1, $pos[1]+1]); //clear boite dialogue
}

//////////////////////////////////////////////////////////////
//// COLOR TEXT///////////////////////////////////////////////

function textColored($text, $color) {
    $colorCode = selectColor($color);

    echo "\033[{$colorCode}m{$text}\033[0m\n";
}

function textColoredByType($text, $color) {
    $colorCode = getColorByType($color);
    
    echo "\033[{$colorCode}m{$text}\033[0m\n";
}



//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
function drawBoxTitle($pos, $scale, $title){
    drawBox($scale,$pos);
    textArea($title, [$pos[0]+intval($scale[0]/2),$pos[1]+2]);
}

function drawBoxTextJusitfy($pos, $choices){
    $posY = $pos[0];
    $posX = $pos[1];

    // Calcul the max length to draw the box
    $maxLength = 0;
    for($i=0; $i<count($choices);++$i){
        $maxLength = strlen($choices[$i]) > $maxLength ? strlen($choices[$i]) : $maxLength;
    }
    drawBox([count($choices)*2+3,$maxLength+5],[$posY,$posX]);

    // Draw each lines
    for($i=0; $i<count($choices);++$i){
        textArea($choices[$i], [$posY+2*($i+1),$posX+2]);
        $maxLength = strlen($choices[$i]) > $maxLength ? strlen($choices[$i]) : $maxLength;
    }
}

function Name($string){
    return ucfirst($string);
}
?>