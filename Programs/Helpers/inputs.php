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

    if($options != null){
        while (!in_array($choice, $options)) {
            moveCursor($pos);
            $choice = readline($sentence);
        }
    }
    $scaleToClear = [getScreenScale()[0]+2,getScreenScale()[1]];
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

function sureToLeave(){
    $pos = getPosYesOrNo();
    drawBox(getScaleYesOrNo(),$pos, '|','-',true);
    // debugLog(getPosYesOrNo());
    textArea('YES', [$pos[0]+1,$pos[1]+2]);
    textArea('NO', [$pos[0]+3,$pos[1]+2]);

    $choice2 = waitForInput(getPosChoice(), ['y','n']);
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