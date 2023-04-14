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
        $last = end($options);
        foreach($options as $key=>$option){
            $sentence .= $option;
            if($option != $last){
                $sentence .= ' | ';
            }
        }
        // for($i=0;$i<count($options);++$i){
        //     $sentence .= $options[$i];
        //     if($i < count($options)-1){
        //         $sentence .= ' | ';
        //     }
        // };
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

// function sureToLeave(){
//     $choice2 = waitForInput([31,0], ['y','n']);
//     if($choice2 == 'y'){
//         break stop;
//     }
//     else{
//         continue;
//     }
// }

function choice(){
    moveCursor([31,0]);
    // Get the user's input
    $input = readline();
    return $input;
}
?>