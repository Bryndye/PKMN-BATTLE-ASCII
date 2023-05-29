<?php
// include 'graphics.php';
function intro(){
    drawGameCadre();
    
    // Animation de * en diagonale sur l'écran
    $height = getScreenScale();
    for ($i = 0; $i < $height[0]-2; $i++) {
        clearGameScreen();
        // drawFullBox([1,1],[$i,2*$i+4]);
        if($i != ($height[0]-1) && $i > 1){
            drawFullBox([3,3],[$i,2*$i]);
        }
        if($i>6){
            drawDiagonal([4,4], [$i-6,2*($i-3)]);
            // drawFullBox([1,1],[($i-6)+4,2*($i-3)]);
            drawDiagonal([3,3],[$i-5,2*($i-1)]);
            drawDiagonal([3,3],[$i-3,2*($i-3)]);
        }
        usleep(25000); // Arrête l'exécution d'un programme durant un laps de temps
    }
    clearGameScreen();

    // Fait apparaitre un Charizard au milieu de l'écran pendant x TEMPS
    animationIntro();

    // Menu titre + press pour joueur
    drawGameCadre();
    drawSprite(getSprites('title'),[3,2]);
    drawSprite(getSprites('Pikachu'),[15,15]);

    waitForInput();
}

function animationIntro(){
    drawSprite(getSprites('Charizard'),[3,2]);
    sleep(2);
    drawSprite(getSprites('effectTitle'),[3,2]);
    sleep(1);
    drawSprite(getSprites('effectFireTitle'),[22,53]);
    sleep(1);
    drawSprite(getSprites('effectFireTitle2'),[21,4]);
    sleep(1);
}
function menuStart(){
    drawGameCadre();
    
    $choiceBefore = [];
    if(isSaveExist(getSavePath('save'),true)){
        drawBoxTextJusitfy(getPosMenuHUD(), ['1 : CONTINUE', '2 : DELETE', '3 : QUIT']);
        $choiceBefore = [1,2,3];
    }
    else{
        drawBox([7,20],[5,5]);
        textArea('1 : NEW GAME', [7,7]);
        textArea("3 : QUIT", [9,7]);
        $choiceBefore = [1,3];
    }

    drawStatsFromSaveToMenu();

    // Attend la selection entre 1 et 2
    $choice = waitForInput([31,0],$choiceBefore);
    if($choice == 3){
        exitGame();
    }
    elseif($choice == 2){
        deleteSave(getSavePath('save'));
    }

    clearGameScreen();
}
function exitGame(){
    echo "\033c";
    exit();
}

function drawStatsFromSaveToMenu(){
    if(isSaveExist(getSavePath('myGame'))){
        drawBox([21,30],[3,28]);
        $save = getSave(getSavePath('myGame'));
        textArea('Name : '.$save['name'], [5,30]);
        textArea('Pokedex : '. countPkmnCatchFromPokedex().'/151', [7,30]);
        textArea('Floor Max : '.$save['IndexFloor Max'], [8,30]);
        textArea('Win Count : '.$save['Game wins'], [9,30]);

        if(isSaveExist(getSavePath('save'))){
            $saveFight = getSave(getSavePath('save'));
            textArea('------ Current Game ------', [11,30]);
            textArea('Floor : '.$saveFight['IndexFloor'], [13,30]);
            textArea("Money : ".$saveFight['Money'], [14,30]);
            
            $y = 0;
            foreach($saveFight['Team'] as $key => $pkmn){
                textArea($pkmn['Name']."  Lv: ".$pkmn['Level'], [16+$y,30]);
                $y +=1;
            }
        }
    }
}

function chooseFirstPokemon(){
    drawBoiteDialogue();
    drawSprite(getSprites('Pokeball'), [8,2]);
    drawSprite(getSprites('Pokeball'), [8,32]);
    drawSprite(getSprites('Pokeball'), [1,17]);
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
    if(!isSaveExist(getSavePath('myGame'))){
        cinematicPresentation();
    }
    else{
        $file = file_get_contents(getSavePath('myGame'));
        $array = json_decode($file, true);

        if(!isset($array['name'])){
            deleteSave(getSavePath('myGame'));
            cinematicPresentation();
        }
    }
}

function cinematicPresentation(){
    $posSprite = [5,16];
    drawGameCadre();
    drawBoiteDialogue();
    drawSprite(getSprites('trainer'), $posSprite);
    messageBoiteDialogue("Hello, i'm Prof. Twig and welcome to the world of Pokemon!", -1);
    messageBoiteDialogue("Let me show you what a pokemon is.", -1);
    clearArea([15,50],[2,2]);
    clearSprite($posSprite);
    drawSprite(getSprites('Pokeball_1'),$posSprite);
    sleep(1);
    drawSprite(getSprites("Pikachu"), $posSprite);
    messageBoiteDialogue("Here's Pikachu!", -1);
    messageBoiteDialogue("He's an electric type. You can meet him later on your journey.", -1);
    clearSprite($posSprite);
    drawSprite(getSprites('trainer'), $posSprite);
    messageBoiteDialogue("By the way, what is your name?", -1);

    messageBoiteDialogue("'To select/ choose an action, write your answer under this box.'", -1);
    saveMainManager();
    $save = getSave(getSavePath('myGame'));
    messageBoiteDialogue("Hi ". $save['name'].". Let me introduce you the rules.", -1);
    messageBoiteDialogue("But this time, it will be different. You have 100 battles to win.", -1);
    messageBoiteDialogue("You loose, you restart by choosing your 'first' Pokemon.", -1);
    messageBoiteDialogue("Between your battles, you can heal your pokemon, buy items and rest", -1);
    messageBoiteDialogue("Careful with captures! You can't stock Pokemons like before. If you capture one, you have to replace one from your team.", -1);
    messageBoiteDialogue("Do you see the difference? Of course you do!", -1);
    messageBoiteDialogue("So, you are ready. Good luck!", -1);
}

function cinematicLeagueEnding(&$save){
    clearGameScreen();
    $name = getDataFromSave('name', getSavePath('myGame'));
    messageBoiteDialogue('Congratulations! You beat the league Pokemon!', -1);

    foreach($save['Team'] as $pkmn){
        clearGameScreen();
        drawSprite(getSprites($pkmn['Sprite']), [3,18]);
        drawBox([4,20],[20,20]);

        justifyText($pkmn['Name'], 20, [21,20], 'center');
        justifyText("Lv: ".$pkmn['Level'], 20, [22,20], 'center');
        messageBoiteDialogue('Bravo to '.$pkmn['Name'].'!');

        waitForInput([31,0]);
        clearSprite([3,18]);
    }
    clearGameScreen();
    drawSprite(getSprites('trainer'), [6,18]);
    sleep(1);

    messageBoiteDialogue('Bravo '.$name.' and your team to defeat the league!', -1);
    messageBoiteDialogue("But it's not over!", -1);
    messageBoiteDialogue("We've heard that a very strong pokemon has appeared.", -1);
    messageBoiteDialogue("Are you ready? Go for it!", -1);
}

//////////////////////////////////////////////////////////////////////////////////////////////
//// ENDING //////////////////////////////////////////////////////////////////////
function cinematicEnding(&$save){
    clearGameScreen();
    messageBoiteDialogue('Congratulations! You beat the game!', -1);
    $name = getDataFromSave('name', getSavePath('myGame'));
    $win = getDataFromSave('Game wins', getSavePath('myGame'));
    foreach($save['Team'] as $pkmn){
        clearGameScreen();
        drawSprite(getSprites($pkmn['Sprite']), [3,18]);
        drawBox([4,20],[20,20]);

        justifyText($pkmn['Name'], 20, [21,20], 'center');
        justifyText("Lv: ".$pkmn['Level'], 20, [22,20], 'center');
        messageBoiteDialogue('Bravo to '.$pkmn['Name'].'!');

        waitForInput([31,0]);
        clearSprite([3,18]);
    }
    clearGameScreen();
    drawSprite(getSprites('trainer'), [6,18]);
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
    deleteSave(getSavePath('save'));
    $gameWins = getDataFromSave('Game wins', getSavePath('myGame'));
    ++$gameWins;
    $floorMaxReturn = ($gameWins*10) + 100 >= 140 ? 140 : ($gameWins*10) + 100;
    setData($floorMaxReturn, 'IndexFloor Max', getSavePath('myGame'));
    setData($gameWins, 'Game wins', getSavePath('myGame'));
}

function screenLose(){
    clearGameScreen();
    addData(1, 'loses', getSavePath('myGame'));
    $floor = getDataFromSave('IndexFloor', getSavePath('save'));

    drawSprite(getSprites('Pokeball'), [3,18]);
    messageBoiteDialogue('You lost at '. $floor . ' floor...', -1);
    deleteSave(getSavePath('save'));
}
?>