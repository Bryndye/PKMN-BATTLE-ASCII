<?php
// include 'graphics.php';
function intro(){
    Display_Game::drawGameCadre();
    
    // Animation de * en diagonale sur l'écran
    $height = Parameters::getScreenScale();
    for ($i = 0; $i < $height[0]-2; $i++) {
         Display::clearGameScreen();
        // Display::drawFullBox([1,1],[$i,2*$i+4]);
        if($i != ($height[0]-1) && $i > 1){
            Display::drawFullBox([3,3],[$i,2*$i]);
        }
        if($i>6){
            Display::drawDiagonal([4,4], [$i-6,2*($i-3)]);
            // Display::drawFullBox([1,1],[($i-6)+4,2*($i-3)]);
            Display::drawDiagonal([3,3],[$i-5,2*($i-1)]);
            Display::drawDiagonal([3,3],[$i-3,2*($i-3)]);
        }
        usleep(25000); // Arrête l'exécution d'un programme durant un laps de temps
    }
     Display::clearGameScreen();

    // Fait apparaitre un Charizard au milieu de l'écran pendant x TEMPS
    animationIntro();

    // Menu titre + press pour joueur
    Display_Game::drawGameCadre();
    Display::drawSprite(getSprites('title'),[3,2]);
    Display::drawSprite(getSprites('Pikachu'),[15,15]);

    waitForInput();
}

function animationIntro(){
    Display::drawSprite(getSprites('Charizard'),[3,2]);
    sleep(2);
    Display::drawSprite(getSprites('effectTitle'),[3,2]);
    sleep(1);
    Display::drawSprite(getSprites('effectFireTitle'),[22,53]);
    sleep(1);
    Display::drawSprite(getSprites('effectFireTitle2'),[21,4]);
    sleep(1);
}
function menuStart(){
    Display_Game::drawGameCadre();
    
    $choiceBefore = [];
    if(isSaveExist(Parameters::getSavePath('save'),true)){
        drawBoxTextJusitfy(Parameters::getPosMenuHUD(), ['1 : CONTINUE', '2 : DELETE', '3 : QUIT']);
        $choiceBefore = [1,2,3];
    }
    else{
        Display::drawBox([7,20],[5,5]);
        Display::textArea('1 : NEW GAME', [7,7]);
        Display::textArea("3 : QUIT", [9,7]);
        $choiceBefore = [1,3];
    }

    drawStatsFromSaveToMenu();

    // Attend la selection entre 1 et 2
    $choice = waitForInput([31,0],$choiceBefore);
    if($choice == 3){
        exitGame();
    }
    elseif($choice == 2){
        deleteSave(Parameters::getSavePath('save'));
    }

     Display::clearGameScreen();
}
function exitGame(){
    echo "\033c";
    exit();
}

function drawStatsFromSaveToMenu(){
    if(isSaveExist(Parameters::getSavePath('myGame'))){
        Display::drawBox([21,30],[3,28]);
        $save = getSave(Parameters::getSavePath('myGame'));
        Display::textArea('Name : '.$save['name'], [5,30]);
        Display::textArea('Pokedex : '. countPkmnCatchFromPokedex().'/'.getCountPokedex(), [7,30]);
        Display::textArea('Floor Max : '.$save['IndexFloor Max'], [8,30]);

        // if(isSaveExist(Parameters::getSavePath('myGame'))){
        //     $floorMaxReached = getDataFromSave('Record IndexFloor', Parameters::getSavePath('myGame')) ?? 0;
        //     Display::textArea('Floor reached Max : '.$floorMaxReached, [9,30]);
        // }
        Display::textArea('Win Count : '.$save['Game wins'], [10,30]);

        if(isSaveExist(Parameters::getSavePath('save'))){
            $saveFight = getSave(Parameters::getSavePath('save'));
            Display::textArea('------ Current Game ------', [12,30]);
            Display::textArea('Floor : '.$saveFight['IndexFloor'], [13,30]);
            Display::textArea("Money : ".CustomFunctions::formatMoney($saveFight['Money']), [14,30]);
            
            $y = 0;
            foreach($saveFight['Team'] as $key => $pkmn){
                Display::justifyText('Lv: '.$pkmn['Level'], 7,[16+$y,45], 'right');
                Display::textArea(ucfirst($pkmn['Name']), [16+$y,30]);
                $y +=1;
            }
        }
    }
}

function chooseFirstPokemon(){
    drawBoiteDialogue();
    Display::drawSprite(getSprites('Pokeball'), [8,2]);
    Display::drawSprite(getSprites('Pokeball'), [8,32]);
    Display::drawSprite(getSprites('Pokeball'), [1,17]);
    messageBoiteDialogue('Choose your first Pokemon : 
       
1 : Bulbasaur  2 : Squirtle  3 : Charmander');
    $team = [];
    $choice = waitForInput([31,0], [1,2,3]);
    if($choice == 1){
        $team[0] = generatePkmnBattle('bulbasaur', 5);
    }
    else if($choice == 2){
        $team[0] = generatePkmnBattle('squirtle',5);
    }
    else if($choice == 3){
        $team[0] = generatePkmnBattle('charmander', 5);
    }
    addPkmnToPokedex($team[0], 'catch');
    return [$team, $choice];
}

//////////////////////////////////////////////////////////////////////////////////////////////
//// FIRST TIME IN GAME //////////////////////////////////////////////////////////////////////
function startGame(){
    // CustomFunctions::debugLog(Parameters::getSavePath('myGame'));
    // CustomFunctions::debugLog(isSaveExist(Parameters::getSavePath('myGame')));
    if(!isSaveExist(Parameters::getSavePath('myGame'))){
        cinematicPresentation();
    }
    else{
        $file = file_get_contents(Parameters::getSavePath('myGame'));
        $array = json_decode($file, true);

        if(!isset($array['name'])){
            deleteSave(Parameters::getSavePath('myGame'));
            cinematicPresentation();
        }
    }
}

function cinematicPresentation(){
    $posSprite = [5,16];
    Display_Game::drawGameCadre();
    drawBoiteDialogue();
    Display::drawSprite(getSprites('trainer'), $posSprite);
    messageBoiteDialogue("Hello, i'm Prof. Twig and welcome to the world of Pokemon!", -1);
    messageBoiteDialogue("Let me show you what a pokemon is.", -1);
    Display::clearArea([15,50],[2,2]);
    Display::clearSprite($posSprite);
    Display::drawSprite(getSprites('Pokeball_1'),$posSprite);
    sleep(1);
    Display::drawSprite(getSprites("Pikachu"), $posSprite);
    messageBoiteDialogue("Here's Pikachu!", -1);
    messageBoiteDialogue("He's an electric type. You'll need Pokemons to do Pokemon battles. You can meet him later on your journey.", -1);
    Display::clearSprite($posSprite);
    Display::drawSprite(getSprites('trainer'), $posSprite);
    messageBoiteDialogue("By the way, what is your name?", -1);

    messageBoiteDialogue("'To select/ choose an action, write your answer under this box.'", -1);
    saveMainManager();
    $save = getSave(Parameters::getSavePath('myGame'));
    messageBoiteDialogue("Hi ". $save['name'].". Let me introduce you the rules.", -1);
    messageBoiteDialogue("But this time, it will be different. You have ".Parameters::getIndexFloorMaxOriginal()." battles to win.", -1);
    messageBoiteDialogue("You loose, you restart. Everytime you can choose a new starter Pokemon.", -1);
    messageBoiteDialogue("You can still buy items that can help you on your journey, but be careful with your money!", -1);
    messageBoiteDialogue("Capture Pokemons to grow up your team! You can only stock 6 Pokemons with you. If you capture one, you must replace it with a member of your team.", -1);
    messageBoiteDialogue("Do you see the difference? Of course you do!", -1);
    messageBoiteDialogue("I almost forgot! Here's a Pokedex that might help. When you see a Pokemon, It records Pokemon data .", -1);
    messageBoiteDialogue("And id you see my nephew, tell him his grandfather's looking for him.", -1);
    messageBoiteDialogue("So, you are ready. Good luck!", -1);
}

function cinematicLeagueEnding(&$save){
     Display::clearGameScreen();
    $name = getDataFromSave('name', Parameters::getSavePath('myGame'));
    messageBoiteDialogue('Congratulations! You beat the league Pokemon!', -1);

    foreach($save['Team'] as $pkmn){
         Display::clearGameScreen();
        Display::drawSprite(getSprites($pkmn['Sprite']), [3,18]);
        Display::drawBox([4,20],[20,20]);

        Display::justifyText(ucfirst($pkmn['Name']), 20, [21,20], 'center');
        Display::justifyText("Lv: ".$pkmn['Level'], 20, [22,20], 'center');
        messageBoiteDialogue('Bravo to '.ucfirst($pkmn['Name']).'!');

        waitForInput([31,0]);
        Display::clearSprite([3,18]);
    }
     Display::clearGameScreen();
    Display::drawSprite(getSprites('trainer'), [6,18]);
    sleep(1);

    messageBoiteDialogue('Bravo '.$name.' and your team to defeat the league!', -1);
    messageBoiteDialogue("But it's not over!", -1);
    messageBoiteDialogue("We've heard that a very strong pokemon has appeared.", -1);
    messageBoiteDialogue("Are you ready? Go for it!", -1);
}

//////////////////////////////////////////////////////////////////////////////////////////////
//// ENDING //////////////////////////////////////////////////////////////////////
function cinematicEnding(&$save){
     Display::clearGameScreen();
    messageBoiteDialogue('Congratulations! You beat the game!', -1);
    $name = getDataFromSave('name', Parameters::getSavePath('myGame'));
    $win = getDataFromSave('Game wins', Parameters::getSavePath('myGame'));
    foreach($save['Team'] as $pkmn){
         Display::clearGameScreen();
        Display::drawSprite(getSprites($pkmn['Sprite']), [3,18]);
        Display::drawBox([4,20],[20,20]);

        Display::justifyText(ucfirst($pkmn['Name']), 20, [21,20], 'center');
        Display::justifyText("Lv: ".$pkmn['Level'], 20, [22,20], 'center');
        messageBoiteDialogue('Bravo to '.ucfirst($pkmn['Name']).'!');

        waitForInput([31,0]);
        Display::clearSprite([3,18]);
    }
     Display::clearGameScreen();
    Display::drawSprite(getSprites('trainer'), [6,18]);
    messageBoiteDialogue('Bravo '.$name.' and your team to defeat the game!', -1);
    if($win == 0){
        messageBoiteDialogue('New Pokemons have apparently appeared. New birds according to trainers.', -1);
    }
    else if ($win < 5){
        messageBoiteDialogue('You unlock new floors for the next time with new trainers and Pokemons.', -1);
    }
    messageBoiteDialogue("Your adventure isn't over yet. You must catch all the Pokemon!", -1);
    messageBoiteDialogue("See you later.", -1);
    // CONDITION POKEDEX UNLOCK FULL ??
}

function endGame(){
    deleteSave(Parameters::getSavePath('save'));
    $gameWins = getDataFromSave('Game wins', Parameters::getSavePath('myGame'));
    ++$gameWins;
    $floorMaxReturn = ($gameWins*10) + Parameters::getIndexFloorMaxOriginal() > 140 ? 141 : ($gameWins*10) + Parameters::getIndexFloorMaxOriginal();
    setData($floorMaxReturn, 'IndexFloor Max', Parameters::getSavePath('myGame'));
    setData($gameWins, 'Game wins', Parameters::getSavePath('myGame'));
}

function screenLose(){
    Display::clearGameScreen();
    addData(1, 'loses', Parameters::getSavePath('myGame'));
    setData(getDataFromSave('IndexFloor', Parameters::getSavePath('save')), 'Record IndexFloor', Parameters::getSavePath('myGame'));
    $floor = getDataFromSave('IndexFloor', Parameters::getSavePath('save'));

    Display::drawSprite(getSprites('Pokeball'), [3,18]);
    messageBoiteDialogue('You lost at '. $floor . ' floor...', -1);
    deleteSave(Parameters::getSavePath('save'));
}
?>