<?php
function drawBoxTitle($pos, $scale, $title){
    drawBox($scale,$pos, '|', '-');
    textArea($title, [$pos[0]+intval($scale[0]/2),$pos[1]+2]);
}

function drawMoney(){
    $money = getDataFromSave('Money');
    drawBox([5,20],[4,35], '|', '-');
    textArea('Money : '.$money, [6,38]);
}

//// draw DIALOGUE ///////////////////////////////////////////
function drawBoiteDialogue(){
    drawBox(getScaleDialogue(), getPosDialogue());
}

function messageBoiteDialogue($message, $pressEnter = false){
    drawBoiteDialogue();
    textAreaLimited($message);
    if($pressEnter){
        waitForInput();
    }
    else{
        sleep(1);
    }
}
function messageBoiteDialogueContinue($message, $time = 0){
    clearBoiteDialogue();
    textAreaLimited($message);
    sleep($time);
}
function clearBoiteDialogue(){
    $pos = getPosDialogue();
    $scale = getScaleDialogue();
    clearArea([$scale[0]-2, $scale[1]-2],[$pos[0]+1, $pos[1]+1]); //clear boite dialogue
}

function drawChoiceMenuRight(){
    drawBox([7,1],[23,43]);
}

//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
?>