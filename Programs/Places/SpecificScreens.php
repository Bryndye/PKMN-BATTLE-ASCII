<?php
// include 'graphics.php';
function intro(){
    drawGameCadre();
    
    // Animation de * en diagonale sur l'écran
    for ($i = 0; $i < 30; $i++) {
        clearGameScreen();
        drawFullBox([1,1],[$i,2*$i]);
        usleep(10000); // Arrête l'exécution d'un programme durant un laps de temps
    }
    
    // Fait apparaitre un Charizard au milieu de l'écran pendant x TEMPS
    include 'Resources/sprites.php';
    animationIntro();


    // Menu titre + press pour joueur
    drawGameCadre();
    drawSprite($sprites['title'],[10,6]);
    
    // echo 'Press any to enter';
    waitForInput([25,20]);
}

function animationIntro(){
    include 'Resources/sprites.php';
    drawSprite($sprites['Charizard'],[1,2]);
    sleep(2);
    drawSprite($sprites['effectTitle'],[1,2]);
    sleep(1);
    drawSprite($sprites['effectFireTitle'],[22,53]);
    sleep(1);
    drawSprite($sprites['effectFireTitle2'],[21,4]);
    sleep(1);
}
function menuStart(){
    drawGameCadre();
    
    $choiceBefore = [];
    if(isSaveExist('Save/save.json',true)){
        drawBox([9,20],[5,5], '|', '-');
        textArea('1 : CONTINUE', [7,7]);
        textArea("2 : DELETE", [9,7]);
        textArea("3 : QUIT", [11,7]);
        $choiceBefore = [1,2,3];
    }
    else{
        drawBox([7,20],[5,5], '|', '-');
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
        deleteSave();
    }
    drawBox([29,60],[1,1]); // Cadre du jeu
    clearArea([27,58],[2,2]); // Efface l'écran
}
function exitGame(){
    echo "\033c";
    exit();
}

function drawStatsFromSaveToMenu(){
    if(isSaveExist('Save/myGame.json')){
        drawBox([21,30],[3,28], '|', '-');
        $save = getSave('Save/myGame.json');
        textArea('Name : '.$save['name'], [5,30]);
        textArea('Pokedex : '. count($save['Pokedex']), [7,30]);
        textArea('Floor Max : '.$save['IndexFloor Max'], [8,30]);
        textArea('Win Count : '.$save['Game wins'], [9,30]);

        if(isSaveExist()){
            $saveFight = getSave();
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
    include 'Resources/sprites.php';
    drawSprite($sprites["Pokeball"], [8,2]);
    drawSprite($sprites["Pokeball"], [8,32]);
    drawSprite($sprites["Pokeball"], [1,17]);
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
    return [$team, $choice];
}

//////////////////////////////////////////////////////////////////////////////////////////////
//// FIRST TIME IN GAME //////////////////////////////////////////////////////////////////////
function startGame(){
    if(!isSaveExist('Save/myGame.json')){
        cinematicPresentation();
    }
    else{
        $file = file_get_contents('Save/myGame.json');
        $array = json_decode($file, true);

        if(!isset($array['name'])){
            deleteSave('Save/myGame.json');
            cinematicPresentation();
        }
    }
}

function cinematicPresentation(){
    $posSprite = [5,16];
    drawGameCadre();
    drawBoiteDialogue();
    include 'Resources/sprites.php';
    drawSprite($sprites['trainer'], $posSprite);
    messageBoiteDialogue("Hello, i'm Prof. Twig and welcome to the world of Pokemon!", true);
    messageBoiteDialogue("Let me show you what a pokemon is.", true);
    clearSprite($posSprite);
    drawSprite($sprites['Pokeball_1'],$posSprite);
    sleep(1);
    drawSprite($sprites["Pikachu"], $posSprite);
    messageBoiteDialogue("Here's Pikachu!", true);
    messageBoiteDialogue("He's an electric type. You can meet him later on your journey.", true);
    clearSprite($posSprite);
    drawSprite($sprites['trainer'], $posSprite);
    messageBoiteDialogue("By the way, what is your name?", true);

    messageBoiteDialogue("'To select/ choose an action, write your answer under this box.'", true);
    saveMainManager();
    $save = getSave('Save/myGame.json');
    messageBoiteDialogue("Hi ". $save['name'].". Let me introduce you the rules.", true);
    messageBoiteDialogue("But this time, it will be different. You have 100 battles to win.", true);
    messageBoiteDialogue("You loose, you restart by choosing your 'first' Pokemon.", true);
    messageBoiteDialogue("Between your battles, you can heal your pokemon, buy items and rest", true);
    messageBoiteDialogue("Careful with captures! You can't stock Pokemons like before. If you capture one, you have to replace one from your team.", true);
    messageBoiteDialogue("Do you see the difference? Of course you do!", true);
    messageBoiteDialogue("So, you are ready. Good luck!", true);
}

function cinematicLeagueEnding(&$save){
    clearGameScreen();
    messageBoiteDialogue('Congratulations! You beat the league Pokemon!', true);

    include 'Resources/sprites.php';
    foreach($save['Team'] as $pkmn){
        drawSprite($sprites[$pkmn['Sprite']], [3,18]);
        drawBox([4,20],[20,20]);
        textAreaLimited($pkmn['Name'], 50,[21, 25]);
        textAreaLimited("Lv: ".$pkmn['Level'], 50, [22, 27]);
        waitForInput([31,0]);
        clearSprite([3,18]);
    }
    clearGameScreen();
    drawSprite($sprites['trainer'], [3,18]);
    messageBoiteDialogue("But it's not over!", true);
    messageBoiteDialogue("There are challenges waiting for you!", true);
}

//////////////////////////////////////////////////////////////////////////////////////////////
//// ENDING //////////////////////////////////////////////////////////////////////
function cinematicEnding(&$save){
    clearGameScreen();
    messageBoiteDialogue('Congratulations! You beat the game!', true);
    $wins = getDataFromSave('Game wins', 'Save/myGame.json');

    include 'Resources/sprites.php';
    foreach($save['Team'] as $pkmn){
        drawSprite($sprites[$pkmn['Sprite']], [3,18]);
        drawBox([4,20],[20,20]);
        textAreaLimited($pkmn['Name'], 50,[21, 25]);
        textAreaLimited("Lv: ".$pkmn['Level'], 50, [22, 27]);
        waitForInput([31,0]);
        clearSprite([3,18]);
    }
    clearGameScreen();
    drawSprite($sprites['trainer'], [3,18]);
    messageBoiteDialogue("But it's not over!", true);
    messageBoiteDialogue("More challenges are available!", true);
    messageBoiteDialogue("Ready for another round?", true);
}

function endGame(){
    deleteSave();
    $gameWins = getDataFromSave('Game wins', 'Save/myGame.json');
    ++$gameWins;
    $indexFloorMax = getDataFromSave('IndexFloor Max', 'Save/myGame.json');
    $floorMaxReturn = ($gameWins*10) + 100;
    setData($floorMaxReturn, 'IndexFloor Max', 'Save/myGame.json');
    setData($gameWins, 'Game wins', 'Save/myGame.json');
}

function screenLose(){
    clearGameScreen();
    addData(1, 'loses', 'Save/myGame.json');
    $floor = getDataFromSave('IndexFloor');

    include 'Resources/sprites.php';
    drawSprite($sprites['Pokeball'], [3,18]);
    messageBoiteDialogue('You lost at '. $floor . ' floor...', true);
    deleteSave();
}
?>