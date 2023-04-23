<?php
//// DRAW HUB PLACE ///////////////////////////////////////////

function drawMoney($pos){
    $posY = $pos[0];
    $posX = $pos[1];
    $money = getDataFromSave('Money');
    drawBox([4,20],[$posY,$posX], '|', '-');
    textArea('Pokedols : ', [$posY+1,$posX+3]);
    textArea($money, [$posY+2,$posX+4]);
}

function drawMenuSelectionHub($pos){
    $posY = $pos[0];
    $posX = $pos[1];
    drawBox([13,20],[$posY,5], '|', '-');
    textArea('1 : CONTINUE', [$posY+2,$posX]);
    textArea("2 : TEAM", [$posY+4,$posX]);
    textArea("3 : BAG", [$posY+6,$posX]);
    textArea("4 : SHOP", [$posY+8,$posX]);
    textArea("5 : QUIT", [$posY+10,$posX]);
}

function drawNextFloor($pos){
    $posY = $pos[0];
    $posX = $pos[1];
    drawBox([10,30],[$posY+2,$posX], '|', '-', true);

    $saveFight = getSave();
    textArea('NEXT', [$posY+3,$posX+13]);
    textArea('Floor : '.$saveFight['IndexFloor'], [$posY+4,$posX+2]);
    textArea('Route : '.getRouteFromIndex($saveFight['IndexFloor'], true), [$posY+6,$posX+2]);

    $pnj = checkPNJExist($saveFight['IndexFloor']);
    if(!is_null($pnj)){
        textArea('Trainer : '.$pnj['Name'], [$posY+8,$posX+2]);
    }
}

function drawCategorySelected($categories, $caterogySelected, $pos){
    // pos = 4,2
    drawBox([1,getScreenScale()[1]-2],$pos,'-','-'); // pos pour mettre la ligne en dessous des categories

    $newPosX = $pos[1]+1;
    $posYCategory = $pos[0]-1;
    foreach($categories as $category){
        // debugLog($category == $caterogySelected);
        if($category == $caterogySelected){
            $scale = countLinesAndColumns($category);
            drawBox([$scale[0]+2,$scale[1]+2],[$posYCategory-1,$newPosX-1],'|','-',true);
            clearArea([1,$scale[1]], [$posYCategory+1,$newPosX]);
            // textArea($category,[$posYCategory,$newPosX]);
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
    drawBox($scale,$pos, '|', '-', true);
    textArea($title, [$pos[0]+intval($scale[0]/2),$pos[1]+2]);
}

function Name($string){
    return ucfirst($string);
}
?>