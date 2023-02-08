<?php
function waitForInput($pos, $options = null){
    // créer la phrase choose
    $sentence = 'Choose ';
    if($options == null){
        $sentence = 'Enter to keep going';
    }
    else{
        for($i=0;$i<count($options);++$i){
            $sentence .= $options[$i];
            if($i < count($options)-1){
                $sentence .= ' | ';
            }
        };
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

function choice(){
    // echo "\033[31;0H";
    moveCursor([31,0]);
    // Get the user's input
    $input = readline();
    return $input;
}
?>