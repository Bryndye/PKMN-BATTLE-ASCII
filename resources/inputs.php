<?php
function waitForInput($pos= [31,0], $options = null, $string = null){
    // créer la phrase choose
    if(isset($string)){
        $sentence = $string;
    }
    else{
        $sentence = 'Choose : ';
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
        $last = end($options);
        foreach($options as$option){
            $sentence .= $option;
            if($option != $last){
                $sentence .= ' | ';
            }
        }
        $sentence .= ' : ';
    }
    moveCursor($pos);
    $choice = readline($sentence);

    if($options != null){
        while (!in_array($choice, $options)) {
            moveCursor($pos);
            $choice = readline($sentence);
        }
    }
    clearArea([1,60], $pos);
    return $choice;
    // echo "Vous avez choisi : " . $choice; 
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

    $choice2 = waitForInput([31,0], ['y','n']);
    if($choice2 == 'y'){
        return true;
    }
    else{
        return false;
    }
}

function choice(){
    moveCursor([31,0]);
    // Get the user's input
    $input = readline();
    return $input;
}
?>