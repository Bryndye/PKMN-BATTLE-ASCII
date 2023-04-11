<?php 
function drawHub(&$save){
    
    while(true){
        displayGameCadre();
        
        $choiceBefore = [];
        $posY = 7;
        displayBox([12,20],[$posY,5]);
        writeSentence('1 : CONTINUE', [$posY+2,7]);
        writeSentence("2 : TEAM", [$posY+4,7]);
        writeSentence("3 : BAG", [$posY+6,7]);
        writeSentence("4 : SHOP", [$posY+8,7]);
        $choiceBefore = [1,3,4];

        displayBoxTitle([3,5],[3,7], 'HUB');

        displayMoney();
        displayBox([10,30],[$posY+2,28]);

        $saveFight = getSave();
        writeSentence('---------- NEXT ----------', [$posY+3,30]);
        writeSentence('Floor : '.$saveFight['IndexFloor']+1, [$posY+5,30]);
        writeSentence('Route : INDISPONIBLE', [$posY+7,30]);

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

    displayBox([30,60],[1,1]); // Cadre du jeu
    clearArea([28,58],[2,2]); // Efface l'écran
}

function continueToFight(){
    clearInGame();
    displayStatsFromSaveToMenu();
    messageBoiteDialogue('Do you want to continue ?');
    displayBox([7,15],[24,46]);
    writeSentence('1: Continue',[26,48]);
    writeSentence('2: Quit',[28,48]);
    // Attend la selection entre 1 et 2
    $choice = waitForInput([31,0],[1,2]);
    if($choice == 2){
        exitGame();
    }
}
?>