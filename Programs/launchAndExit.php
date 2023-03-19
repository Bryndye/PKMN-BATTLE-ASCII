<?php
// include 'graphics.php';
function intro(){
    displayGameCadre();
    echo "\033[?25l";
    
    // Animation de * en diagonale sur l'écran
    for ($i = 0; $i < 30; $i++) {
        clearInGame();
        // echo "\033[?25l"; //hide cursor
        echo "\033[".$i.";".($i+$i)."H";
        echo "*";
        usleep(10000); // Arrête l'exécution d'un programme durant un laps de temps
    }
    
    // Fait apparaitre un Charizard au milieu de l'écran pendant x TEMPS
    include 'visuals/sprites.php';
    animationIntro();


    // Menu titre + press pour joueur
    displayGameCadre();
    displaySprite($sprites['title'],[10,6]);
    
    // echo 'Press any to enter';
    waitForInput([25,20]);
}

function animationIntro(){
    include 'visuals/sprites.php';
    displaySprite($sprites['Charizard'],[1,2]);
    sleep(2);
    displaySprite($sprites['effectTitle'],[1,2]);
    sleep(1);
    displaySprite($sprites['effectFireTitle'],[22,53]);
    sleep(1);
    displaySprite($sprites['effectFireTitle2'],[21,4]);
    sleep(1);
}
function menuStart(){
    displayGameCadre();
    displayBox([7,20],[5,5]);

    echo "\033[7;7H";
    echo isSaveExist('json/save.json',true) ? '1 : CONTINUE' : "1 : NEW GAME";
    echo "\033[9;7H";
    echo "2 : QUIT";
    displayStatsFromSaveToMenu();

    // Attend la selection entre 1 et 2
    $choice = waitForInput([31,0],[1,2]);
    if($choice == 2){
        exitGame();
    }
    displayBox([29,60],[1,1]); // Cadre du jeu
    clearArea([27,58],[2,2]); // Efface l'écran
}
function exitGame(){
    echo "\033c";
    exit();
}

function displayStatsFromSaveToMenu(){
    if(isSaveExist('json/myGame.json')){
        displayBox([21,30],[3,28]);
        $save = getSave('json/myGame.json');
        writeSentence('Name : '.$save['name'], [5,30]);
        writeSentence('Pokedex : '. count($save['Pokedex']), [7,30]);
        writeSentence('Floor Max : '.$save['IndexFloor Max'], [8,30]);
        writeSentence('Win Count : '.$save['Game wins'], [9,30]);

        if(isSaveExist()){
            $saveFight = getSave();
            writeSentence('------ Current Game ------', [11,30]);
            writeSentence('Floor : '.$saveFight['IndexFloor'], [13,30]);
            writeSentence("Money : ".$saveFight['Money'], [14,30]);
            
            $y = 0;
            foreach($saveFight['Team'] as $key => $pkmn){
                writeSentence($pkmn['Name']."  Lv: ".$pkmn['Level'], [16+$y,30]);
                $y +=1;
            }
        }
    }
}

function chooseFirstPokemon(){
    displayBoiteDialogue();
    include 'visuals/sprites.php';
    displaySprite($sprites["Pokeball"], [8,2]);
    displaySprite($sprites["Pokeball"], [8,32]);
    displaySprite($sprites["Pokeball"], [1,17]);
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
    // $team[1] = generatePkmnBattle(rand(1,151), 15);
    return $team;
}

//////////////////////////////////////////////////////////////////////////////////////////////
//// FIRST TIME IN GAME //////////////////////////////////////////////////////////////////////
function startGame(){
    if(!isSaveExist('json/myGame.json')){
        cinematicPresentation();
    }
    else{
        $file = file_get_contents('json/myGame.json');
        $array = json_decode($file, true);

        if(!isset($array['name'])){
            deleteSave('json/myGame.json');
            cinematicPresentation();
        }
    }
}

function cinematicPresentation(){
    $posSprite = [5,16];
    displayGameCadre();
    displayBoiteDialogue();
    include 'visuals/sprites.php';
    displaySprite($sprites['trainer'], $posSprite);
    messageBoiteDialogue("Hello, i'm Prof. Twig and welcome to the world of Pokemon!", true);
    messageBoiteDialogue("Let me show you what a pokemon is.", true);
    clearSprite($posSprite);
    displaySprite($sprites['Pokeball_1'],$posSprite);
    sleep(1);
    displaySprite($sprites["Pikachu"], $posSprite);
    messageBoiteDialogue("Here's Pikachu!", true);
    messageBoiteDialogue("He's an electric type. You can meet him later on your journey.", true);
    clearSprite($posSprite);
    displaySprite($sprites['trainer'], $posSprite);
    messageBoiteDialogue("By the way, what is your name?", true);

    messageBoiteDialogue("'To select/ choose an action, write your answer under this box.'", true);
    createSaveMyGame();
    $save = getSave('json/myGame.json');
    messageBoiteDialogue("Hi ". $save['name'].". Let me introduce you the rules.", true);
    messageBoiteDialogue("But this time, it will be different. You have 100 battles to win.", true);
    messageBoiteDialogue("You loose, you restart by choosing your 'first' Pokemon.", true);
    messageBoiteDialogue("Between your battles, you can heal your pokemon, buy items and rest", true);
    messageBoiteDialogue("Careful with captures! You can't stock Pokemons like before. If you capture one, you have to replace one from your team.", true);
    messageBoiteDialogue("Do you see the difference? Of course you do!", true);
    messageBoiteDialogue("So, you are ready. Good luck!", true);
}

function cinematicLeagueEnding(&$save){
    clearInGame();
    messageBoiteDialogue('Congratulations! You beat the league Pokemon!', true);

    include 'visuals/sprites.php';
    foreach($save['Team'] as $pkmn){
        displaySprite($sprites[$pkmn['Sprite']], [3,18]);
        displayBox([4,20],[20,20]);
        limitSentence($pkmn['Name'], 50,[21, 25]);
        limitSentence("Lv: ".$pkmn['Level'], 50, [22, 27]);
        waitForInput([31,0]);
        clearSprite([3,18]);
    }
    clearInGame();
    displaySprite($sprites['trainer'], [3,18]);
    messageBoiteDialogue("But it's not over!", true);
    messageBoiteDialogue("There are challenges waiting for you!", true);
}

//////////////////////////////////////////////////////////////////////////////////////////////
//// ENDING //////////////////////////////////////////////////////////////////////
function cinematicEnding(&$save){
    clearInGame();
    messageBoiteDialogue('Congratulations! You beat the game!', true);
    $wins = getDataFromSave('Game wins', 'json/myGame.json');

    include 'visuals/sprites.php';
    foreach($save['Team'] as $pkmn){
        displaySprite($sprites[$pkmn['Sprite']], [3,18]);
        displayBox([4,20],[20,20]);
        limitSentence($pkmn['Name'], 50,[21, 25]);
        limitSentence("Lv: ".$pkmn['Level'], 50, [22, 27]);
        waitForInput([31,0]);
        clearSprite([3,18]);
    }
    clearInGame();
    displaySprite($sprites['trainer'], [3,18]);
    messageBoiteDialogue("But it's not over!", true);
    messageBoiteDialogue("More challenges are available!", true);
    messageBoiteDialogue("Ready for another round?", true);
}

function endGame(){
    deleteSave();
    $gameWins = getDataFromSave('Game wins', 'json/myGame.json');
    ++$gameWins;
    $indexFloorMax = getDataFromSave('IndexFloor Max', 'json/myGame.json');
    $floorMaxReturn = ($gameWins*10) + 100;
    saveData($floorMaxReturn, 'IndexFloor Max', 'json/myGame.json');
    saveData($gameWins, 'Game wins', 'json/myGame.json');
}

function screenLose(){
    clearInGame();
    addData(1, 'loses', 'json/myGame.json');
    $floor = getDataFromSave('IndexFloor');

    include 'visuals/sprites.php';
    displaySprite($sprites['Pokeball'], [3,18]);
    messageBoiteDialogue('You lost at '. $floor . ' floor...', true);
    deleteSave();
}
?>