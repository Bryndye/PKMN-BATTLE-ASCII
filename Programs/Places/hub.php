<?php 
function drawHub(&$save){
    
    while(true){
        drawGameCadre();
        
        $choiceBefore = [];
        $choiceBefore = [1,3,4];
        drawMenuSelectionHub([7,7]);
        drawBoxTitle([3,5],[3,7], 'HUB');
        drawMoney([4,35]);
        drawNextFloor([7,28]);

        messageBoiteDialogue('What do you want to do?');

        // Attend la selection entre 1 et 2
        $choice = waitForInput([31,0],$choiceBefore);
        if($choice == 3){
            managerItemsIntoMenu($save);
        }
        elseif($choice == 4){
            managerShop($save);
        }
        elseif($choice == 1){
            break;
        }
    }
    animationEnterBattle();

    drawBox([30,60],[1,1]); // Cadre du jeu
    clearArea([28,58],[2,2]); // Efface l'écran
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