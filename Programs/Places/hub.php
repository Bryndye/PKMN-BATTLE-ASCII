<?php 
function drawHub(&$save){
    
    while(true){
        drawGameCadre();
        
        $choiceBefore = [];
        // choice change si shop disponible ou pokecenter
        $choiceBefore = [1,2,3,4,5];
        drawMenuSelectionHub([7,7]);
        drawBoxTitle([3,5],[3,7], 'HUB');
        drawMoney([4,35]);
        drawNextFloor([7,28]);

        messageBoiteDialogue('What do you want to do?');

        // Attend la selection entre 1 et 2
        $choice = waitForInput([31,0],$choiceBefore);
        if($choice == 3){
            $action = enterIntoBag($save);
            if(str_contains($action, 'c')){
                continue;
            }
            else{
                actionBagHub($save, $save['Team'], $action);
            }
        }
        elseif($choice == 2){
            // debugLog($save);
            drawPkmnTeam($save['Team']);
            waitForInput([31,0], 'c');
        }
        elseif($choice == 4){
            managerShop($save);
        }
        elseif($choice == 1){
            break;
        }
        elseif($choice == 5){
            exitGame();
        }
    }
    animationEnterBattle();

    drawGameCadre();
    clearGameScreen();
}

function continueToFight(){
    clearGameScreen();
    drawStatsFromSaveToMenu();
    messageBoiteDialogue('Do you want to continue ?');
    drawBox([7,15],[24,46]);
    textArea('1: Continue',[26,48]);
    textArea('2: Quit',[28,48]);
    // Attend la selection entre 1 et 2
    $choice = waitForInput([31,0],[1,2]);
    if($choice == 2){
        exitGame();
    }
}
?>