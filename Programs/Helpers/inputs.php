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
    Cursor::moveCursor($pos);
    $choice = readline($sentence);
    $scaleToClear = [3,Parameters::getScreenScale()[1]];

    if($options != null){
        while (!in_array($choice, $options)) {
            Display::clearArea($scaleToClear, $pos);
            Cursor::moveCursor($pos);
            $choice = readline($sentence);
        }
    }
    // Display::drawBox($scaleToClear, $pos);
    Display::clearArea($scaleToClear, $pos);
    return $choice;
}

function enterToContinue($pos, $showMessage){
    $sentence = 'Enter to keep going';

    Cursor::moveCursor($pos);
    $choice = readline($sentence);
    Display::clearArea([1,60], $pos);
    return $choice;
}

function binaryChoice(){
    $pos = Parameters::getPosYesOrNo();
    $scale = Parameters::getScaleYesOrNo();
    Display::drawBox($scale,$pos, '|','-',true);
    Display::textArea('YES', [$pos[0]+1,$pos[1]+2]);
    Display::textArea('NO', [$pos[0]+3,$pos[1]+2]);

    $choice2 = waitForInput(Parameters::getPosChoice(), ['y','n']);
    Display::clearArea($scale, $pos);
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