<?php 
function drawHub(&$save){
    
    while(true){
        drawGameCadre();
        
        $choiceBefore = [];
        // choice change si shop disponible ou pokecenter
        $choiceBefore = [1,2,3,4,5];
        drawBoxChoiceMenu(getPosMenuHUD(), ['1 : CONTINUE', '2 : TEAM', '3 : BAG', '4 : TOWN', '5 : QUIT']);
        drawBoxTitle(getPosPlaceHUD(),[3,7], 'HUB');
        drawMoney(null,$save['Money']);
        drawNextFloor([10,28]);

        messageBoiteDialogue('What do you want to do?');

        // Attend la selection entre 1 et 2
        $choice = waitForInput([31,0],$choiceBefore);
        if($choice == 3){
            while(true){
                $action = enterIntoBag($save);
                if(str_contains($action, leaveInputMenu())){
                    break;
                }
                else{
                    actionBagHub($save, $save['Team'], $action);
                }
            }
        }
        elseif($choice == 2){
            // debugLog($save);
            drawPkmnTeam($save['Team']);
            waitForInput(getPosChoice(), leaveInputMenu());
        }
        elseif($choice == 4){
            inTown($save);
            // managerShop($save);
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

function inTown(&$save){
    while(true){
        drawGameCadre();
        $choiceBefore = [];
        // choice change si shop disponible ou pokecenter
        $choiceBefore = [1,2,3];
        $townName = 'INSERT NAME';
        // drawBoxTitle(getPosPlaceHUD(),[3,strlen($townName)+4], $townName);
        drawBoxChoiceMenu(getPosMenuHUD(), ['1 : POKE CENTER', '2 : POKE SHOP', '3 : QUIT']);
        messageBoiteDialogue('Welcome to '.$townName.'!');

        // Attend la selection entre 1 et 2
        $choice = waitForInput([31,0],$choiceBefore);
        if($choice == 1){
            // poke center heal
            drawSprite(getSprites('healer'),[4,17]);
            messageBoiteDialogue("Welcome to our Pokémon Center!\nWe heal your Pokémon back to perfect health!\nShall we heal your Pokémon?");
            if(binaryChoice()){
                fullHealTeam($save['Team']);
                messageBoiteDialogue("Thank you! Your Pokémon are fighting fit!\nWe hope to see you again!",-1);
            }
        }
        elseif($choice == 2){
            // shop
            managerShop($save);
        }
        elseif($choice == 3){
            // out
            break;
        }
    }
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