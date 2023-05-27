<?php
function waitForInput($pos= [31,0], $options = null, $string = null, $showOption = true){
    // créer la phrase choose
    if(isset($string)){
        $sentence = $string;
    }
    else{
        $sentence = ' Select ';
    }

    if($options == null){
        if($string){
            $sentence = $string;
        }
        else{
            $sentence = 'Press Enter ';
        }
    }
    else{
        if(!is_array($options)){
            $options = [$options];
        }
        if($showOption){
            $last = end($options);
            foreach($options as$option){
                $sentence .= $option;
                if($option != $last){
                    $sentence .= ' | ';
                }
            }
            $sentence .= ' : ';
        }
        else{
            $sentence .= leaveInputMenu().' : ';
        }
    }
    moveCursor($pos);
    $choice = readline($sentence);
    $scaleToClear = [3,getScreenScale()[1]];

    if($options != null){
        while (!in_array($choice, $options)) {
            clearArea($scaleToClear, $pos);
            moveCursor($pos);
            $choice = readline($sentence);
        }
    }
    // drawBox($scaleToClear, $pos);
    clearArea($scaleToClear, $pos);
    return $choice;
}

function enterToContinue($pos, $showMessage){
    $sentence = 'Enter to keep going';

    moveCursor($pos);
    $choice = readline($sentence);
    clearArea([1,60], $pos);
    return $choice;
}

function binaryChoice(){
    $pos = getPosYesOrNo();
    $scale = getScaleYesOrNo();
    drawBox($scale,$pos, '|','-',true);
    textArea('YES', [$pos[0]+1,$pos[1]+2]);
    textArea('NO', [$pos[0]+3,$pos[1]+2]);

    $choice2 = waitForInput(getPosChoice(), ['y','n']);
    clearArea($scale, $pos);
    if($choice2 == 'y'){
        return true;
    }
    else{
        return false;
    }
}

//// List inputs //////////////////////////////////////////////////////////
function inputsNavigate($categories, $listItems, $canUse = true){
    $choice = [leaveInputMenu()];
    if(count($categories) > 0){
        array_push($choice, 'q','d');
    }
    if(count($listItems)>0){
        array_push($choice, 'z','s');
        if($canUse){
            array_push($choice, 'v');
        }
    }
    return $choice;
}

////////////////////////////////////////////////////////////////////////////
function leaveInputMenu(){
    return 'c';
}
?>