<?php 
function drawHub(&$save){
    
    while(true){
        Display_Game::drawGameCadre();
        
        $choiceBefore = [1, 2, 3, 4, 6];
        $choiceBeforeHUD = ['1 : CONTINUE', '2 : POKEDEX', '3 : POKEMON', '4 : BAG', '6 : QUIT'];
        $townAccessibleResult = townAccessible($save['IndexFloor']);
        if($townAccessibleResult) {
            array_splice($choiceBefore, 4, 0, 5);
            global $towns;
            $townName = $towns[$save['IndexFloor']];
            array_splice($choiceBeforeHUD, 4, 0, '5 : '.$townName);
        }
        drawBoxTextJusitfy(Parameters::getPosMenuHUD(), $choiceBeforeHUD);
        drawBoxTitle(Parameters::getPosPlaceHUD(),[3,7], 'HUB');
        drawMoney(null,$save['Money']);
        drawNextFloor([10,28]);

        Display_Game::messageBoiteDialogue('What do you want to do?');

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
        }
        elseif($choice == 6){
            exitGame();
        }
        setFile($save, Parameters::getSavePath('save'));
    }
    Animations::enterBattle();

    Display_Game::drawGameCadre();
     Display::clearGameScreen();
}

function drawNextFloor($pos){
    $posY = $pos[0];
    $posX = $pos[1];
    Display::drawBox([10,30],[$posY,$posX]);

    $saveFight = getSave(Parameters::getSavePath('save'));
    Display::justifyText('NEXT', 30, $pos, 'center');
    Display::textArea('Floor : '.$saveFight['IndexFloor'], [$posY+2,$posX+2]);

    $currentRoute = getRouteFromIndex($saveFight['IndexFloor'],true);
    $pnj = checkPNJExist($saveFight['IndexFloor']);
    if(!is_null($currentRoute)){
        Display::textArea('Route : '.$currentRoute, [$posY+4,$posX+2],26);

        if(!is_null($pnj)){
            Display::textArea('Trainer : '.ucfirst($pnj['Name']), [$posY+6,$posX+2], 26);
        }
    }
    else{
        if(!is_null($pnj)){
            Display::textArea('Trainer : '.ucfirst($pnj['Name']), [$posY+4,$posX+2], 26);
        }
    }
}
//// TEAM MENU ///////////////////////////////////////////////////////////////////////
function checkTeamPkmnFromMenu(&$pkmnTeam){
    while(true){ // LOOP SELECT PKMN
        $choice = selectPkmn($pkmnTeam, null, true, 'Choose a Pokemon.');
        if(is_numeric($choice)){
            while(true){ // LOOP ACTION TO A SINGLE PKMN
                Display_Game::messageBoiteDialogue("1: Stats ".$pkmnTeam[$choice]['Name']."\n2: Move to First Place");
                $choice2 = waitForInput(Parameters::getPosChoice(), [leaveInputMenu(),1,2]);
                if($choice2 == 1){
                    seeSheetPkmn($pkmnTeam[$choice]);
                    break;
                }
                else if($choice2 == 2){
                    Display_Game::messageBoiteDialogue('Switch place '.$pkmnTeam[$choice]['Name'].' where?');
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
     Display::clearGameScreen();
    displayPkmnLeftMenu($pkmn);
    displayCapacitiesMenu($pkmn);
    displayBottonPkmnStatsInterface($pkmn);
    waitForInput();
    Display::clearArea([20,30], [2,30]);
    dispslayStatsPkmnMenu($pkmn);
    waitForInput();
}

function displayPkmnLeftMenu($pkmn, $catch = null){
    if(is_null($pkmn)){
        $pkmn['N Pokedex'] = '???';
        $pkmn['Name'] = '???';
        $pkmn['Sprite'] = '?';
        $pkmn['Type 1'] = '???';
        $pkmn['Type 2'] = '???';
    }
    Display::drawSprite(getSprites($pkmn['Sprite']), [8,3]);
    Display::drawBox([5,24], [2,3]);
    if(array_key_exists('Level', $pkmn)){
        Display::justifyText('Lv:'.$pkmn['Level'], 20, [3,5], 'right');
    }
    Display::textAreaLimited(ucfirst($pkmn['Name']),30,[3,5]);
    // CustomFunctions::debugLog($catch);
    if(!is_null($catch)){
        Display::justifyText($catch, 20, [4,5], 'right');
    }
    else{
        Display::justifyText('    ', 20, [4,5], 'right');
    }
    Display::textAreaLimited('N° : '.$pkmn['N Pokedex'],30,[4,5]);

    Display_Game::setColorByType($pkmn['Type 2']);
    Display::justifyText($pkmn['Type 2'], 20, [5,5], 'right');
    
    Display_Game::setColorByType($pkmn['Type 1']);
    Display::textAreaLimited($pkmn['Type 1'],30,[5,5]);
    Display::setColor('reset');
}

function displayCapacitiesMenu($pkmn){
    $i = 1;
    $y = 0;
    $x = 30;
    foreach($pkmn['Capacites'] as $capacitePkmn){
        Display_Game::setColorByType($capacitePkmn['Type']);
        Display::drawBox([4,30],[2+$i,$x],'|','-',true);
        Display::setColor('reset');

        if($capacitePkmn['Category'] != 'status'){
            Display::justifyText('Power:'.$capacitePkmn['Power'], 9, [4+$i,$x+19],'right');
        }      
        Display_Game::setColorByType($capacitePkmn['Category']);
        Display::justifyText(ucfirst($capacitePkmn['Category']), 9, [3+$i,$x+19],'right');
        Display::setColor('reset');

        Display::textAreaLimited(($y+1).' : '.$capacitePkmn['Name'],23,[3+$i,$x+2]);
        Display::textAreaLimited('PP : '.$capacitePkmn['PP'].'/'.$capacitePkmn['PP Max'],23,[4+$i,$x+2]);
        ++$y;
        $i += 4;
    }
}

function dispslayStatsPkmnMenu($pkmn){
    $i = 6;
    $x = 35;
    $stats = $pkmn['Stats'];
    Display::drawBox([15,22],[$i,$x]);
    foreach($stats as $key=>$stat){
        Display::justifyText($stat, 18 ,[1+$i,$x+2], 'right');
        Display::textArea($key, [1+$i,$x+2]);
        $i += 2;
    }
}
//// TOWN ////////////////////////////////////////////////////////////////////////////
function inTown(&$save){
    while(true){
        Display_Game::drawGameCadre();
        $choiceBefore = [];
        // choice change si shop disponible ou pokecenter
        $choiceBefore = [1,2,3];
        global $towns;
        $townName = $towns[$save['IndexFloor']];
        drawBoxTitle(Parameters::getPosPlaceHUD(),[3,strlen($townName)+4], $townName);
        drawBoxTextJusitfy(Parameters::getPosMenuHUD(), ['1 : POKE CENTER', '2 : POKE SHOP', '3 : EXIT']);
        Display::drawSprite(getSprites('Town'), [8, 29]);
        Display_Game::messageBoiteDialogue('Welcome to '.$townName.'!');

        // Attend la selection entre 1 et 2
        $choice = waitForInput([31,0],$choiceBefore);
        if($choice == 1){
            // poke center heal
             Display::clearGameScreen();
            Display::drawSprite(getSprites('healer'),[4,17]);
            Display_Game::messageBoiteDialogue("Welcome to our Pokémon Center!\nWe heal your Pokémon back to perfect health!\nShall we heal your Pokémon?");
            if(binaryChoice()){
                fullHealTeam($save['Team']);
                Display_Game::messageBoiteDialogue("Thank you! Your Pokémon are fighting fit!\nWe hope to see you again!",-1);
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


function displayBottonPkmnStatsInterface($pkmn){
    Display_Fight::drawPkmnInfoHUD([23,3], $pkmn);
    // $texts = ['Exp :'.$pkmn['exp'], 'Exp To Level :'.$pkmn['expToLevel']];
    Display::drawBox([5,25],[23,30]);
    Display_Game::setColorByType('exp');
    Display::textArea('Exp :'.$pkmn['exp'], [24,32]);
    Display::textArea('Exp To Level :'.$pkmn['expToLevel'], [26,32]);
    // drawBoxTextJusitfy([23,30], $texts);
    Display::setColor('reset');
}
?>