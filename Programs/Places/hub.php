<?php 
function drawHub(&$save){
    
    while(true){
        drawGameCadre();
        
        $choiceBefore = [1, 2, 3, 4, 6];
        $choiceBeforeHUD = ['1 : CONTINUE', '2 : POKEDEX', '3 : POKEMON', '4 : BAG', '6 : QUIT'];
        $townAccessibleResult = townAccessible($save['IndexFloor']);
        if($townAccessibleResult) {
            array_splice($choiceBefore, 4, 0, 5);
            global $towns;
            $townName = $towns[$save['IndexFloor']];
            array_splice($choiceBeforeHUD, 4, 0, '5 : '.$townName);
        }
        drawBoxTextJusitfy(getPosMenuHUD(), $choiceBeforeHUD);
        drawBoxTitle(getPosPlaceHUD(),[3,7], 'HUB');
        drawMoney(null,$save['Money']);
        drawNextFloor([10,28]);

        messageBoiteDialogue('What do you want to do?');

        // Attend la selection entre 1 et 2
        $choice = waitForInput([31,0],$choiceBefore);
        if($choice == 1){
            break;
        }
        elseif($choice == 2){
            pokedexInterface();
        }
        elseif($choice == 3){
            checkTeamPkmnFromMenu($save['Team']);
        }
        elseif($choice == 4){
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
        elseif($choice == 5){
            inTown($save);
            // managerShop($save);
        }
        elseif($choice == 6){
            exitGame();
        }
    }
    animationEnterBattle();

    drawGameCadre();
    clearGameScreen();
}

//// TEAM MENU ///////////////////////////////////////////////////////////////////////
function checkTeamPkmnFromMenu(&$pkmnTeam){
    while(true){ // LOOP SELECT PKMN
        $choice = selectPkmn($pkmnTeam, null, true, 'Choose a Pokemon.');
        if(is_numeric($choice)){
            while(true){ // LOOP ACTION TO A SINGLE PKMN
                messageBoiteDialogue("1: Sheet Pkmn\n2: First Place");
                $choice2 = waitForInput(getPosChoice(), [leaveInputMenu(),1,2]);
                if($choice2 == 1){
                    seeSheetPkmn($pkmnTeam[$choice]);
                    break;
                }
                else if($choice2 == 2){
                    messageBoiteDialogue('Switch place '.$pkmnTeam[$choice]['Name'].' where?');
                    switchPkmn($pkmnTeam, $choice, false);
                    break;
                }
                else if($choice2 == 'c'){
                    break;
                }
            }
        }
        else if($choice == 'c'){
            break;
        }
    }
}

function seeSheetPkmn($pkmn){
    clearGameScreen();
    displayPkmnLeftMenu($pkmn);
    displayCapacitiesMenu($pkmn);
    waitForInput();
    clearArea([20,30], [2,30]);
    dispslayStatsPkmnMenu($pkmn);
    waitForInput();
}

function displayPkmnLeftMenu($pkmn){
    if(is_null($pkmn)){
        $pkmn['N Pokedex'] = '???';
        $pkmn['Name'] = '???';
        $pkmn['Sprite'] = '?';
        $pkmn['Type 1'] = '???';
        $pkmn['Type 2'] = '???';
    }
    drawSprite(getSprites($pkmn['Sprite']), [8,3]);
    drawBox([5,24], [2,3]);
    if(array_key_exists('Level', $pkmn)){
        justifyText('Lv:'.$pkmn['Level'], 20, [3,5], 'right');
    }
    textAreaLimited($pkmn['Name'],30,[3,5]);
    textAreaLimited('N° : '.$pkmn['N Pokedex'],30,[4,5]);

    getColorByType($pkmn['Type 2']);
    justifyText($pkmn['Type 2'], 20, [5,5], 'right');
    
    getColorByType($pkmn['Type 1']);
    textAreaLimited($pkmn['Type 1'],30,[5,5]);
    selectColor('reset');
}

function displayCapacitiesMenu($pkmn){
    $i = 4;
    $y = 0;
    $x = 35;
    foreach($pkmn['Capacites'] as $capacitePkmn){
        getColorByType($capacitePkmn['Type']);
        drawBox([4,20],[2+$i,$x],'|','-',true);
        selectColor('reset');
        textAreaLimited($y.' : '.$capacitePkmn['Name'],23,[3+$i,$x+2]);
        textAreaLimited('PP : '.$capacitePkmn['PP'].'/'.$capacitePkmn['PP Max'],23,[4+$i,$x+2]);
        ++$y;
        $i += 4;
    }
}

function dispslayStatsPkmnMenu($pkmn){
    $i = 6;
    $x = 35;
    $stats = $pkmn['Stats'];
    drawBox([15,22],[$i,$x]);
    foreach($stats as $key=>$stat){
        justifyText($stat, 18 ,[1+$i,$x+2], 'right');
        textArea($key, [1+$i,$x+2]);
        $i += 2;
    }
}
//// TOWN ////////////////////////////////////////////////////////////////////////////
function inTown(&$save){
    while(true){
        drawGameCadre();
        $choiceBefore = [];
        // choice change si shop disponible ou pokecenter
        $choiceBefore = [1,2,3];
        global $towns;
        $townName = $towns[$save['IndexFloor']];
        drawBoxTitle(getPosPlaceHUD(),[3,strlen($townName)+4], $townName);
        drawBoxTextJusitfy(getPosMenuHUD(), ['1 : POKE CENTER', '2 : POKE SHOP', '3 : EXIT']);
        drawSprite(getSprites('Town'), [8, 29]);
        messageBoiteDialogue('Welcome to '.$townName.'!');

        // Attend la selection entre 1 et 2
        $choice = waitForInput([31,0],$choiceBefore);
        if($choice == 1){
            // poke center heal
            clearGameScreen();
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