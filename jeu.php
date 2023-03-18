<?php
// INIT SCRIPTS
include_once 'Programs/saveManager.php';
include_once 'Programs/launchAndExit.php';
include_once 'resources/inputs.php';
include_once 'resources/config.php';
include_once 'resources/pokemonList.php';
include_once 'resources/typeMatchUp.php';
include_once 'visuals/graphics.php'; 
include_once 'visuals/sprites.php';
include_once 'Programs/fightSystem.php';
include_once 'visuals/hudfight.php';
include_once 'Programs/programFight.php';
include_once 'Programs/itemsManager.php';
include_once 'Programs/iaProgram.php';
include_once 'Programs/shopEchange.php';
include_once 'Programs/shop.php';

//// SET THE GAME ////
clear();
echo "\033[?25l"; // hide cursor
// shell_exec('mode con: cols=60 lines=32');
// intro();
startGame();


//// GAME ////
while(true){
    menuStart();
    //Sauvegardes joueur
    $saveProfile = getSave('json/myGame.json');
    $save = getSaveIfExist();
    $pkmnTeamJoueur = &$save['Team'];
    saveData($pkmnTeamJoueur, 'Team');
    // array_push($pkmnTeamJoueur, generatePkmnBattle('mewtwo', 100,0,['psychic', 'thunder','flamethrower']));
    if(array_key_exists('IndexFloor', $save)){
        $IndexFloor = $save['IndexFloor'];
    }
    else{
        $IndexFloor = 1;
    }
    if(array_key_exists('IndexFloor Max', $saveProfile)){
        $IndexFloorMax = $saveProfile['IndexFloor Max'];
    }
    else{
        $IndexFloorMax = 100;
    }
    
    // item TEMP
    giveItemFromResources($save["Bag"], 'Potion', 5);
    giveItemFromResources($save["Bag"], 'Revive', 5);
    giveItemFromResources($save["Bag"], 'Super potion', 5);
    giveItemFromResources($save["Bag"], 'PokeBall', 5);
    giveItemFromResources($save["Bag"], 'MasterBall', 5);
    
    // Loop gameplay if team alive
    while(true){
        // Passage au shop
        managerShop($save);
        managerItemsIntoMenu($save);

        // generer IA pkmn team
        $pnj = generatePNJ($IndexFloor, $pkmnTeamJoueur[0]['Level']);
        startFight($save, $pnj);

        if(!isTeamPkmnAlive($pkmnTeamJoueur)){
            screenLose();
            break;
        }
        else{
            ++$IndexFloor;
            $save['IndexFloor'] = $IndexFloor;
            saveFile($save);
        }
        waitForInput([31,0]);

        if($IndexFloor == 94){
            cinematicLeagueEnding($save);
        }
        else if($IndexFloor > $IndexFloorMax){
            cinematicEnding($save);
            endGame();
            break;
        }
        continueToFight();
        // SCREEN CONTINUER OU QUITTER LE JEU
    }
}

function continueToFight(){
    clearInGame();
    displayStatsFromSaveToMenu();
    displayBox([7,15],[24,46]);
    writeSentence('1: Continue',[26,48]);
    writeSentence('2: Quit',[28,48]);
    messageBoiteDialogue('Do you want to continue ?');
    // Attend la selection entre 1 et 2
    $choice = waitForInput([31,0],[1,2]);
    if($choice == 2){
        exitGame();
    }
}


// FIN DU JEU 
// clear();

// displayBox([5,30],[12,25]);
// echo "\033[14;35H";
// echo "END";
// sleep(2);
// echo "\033c";

?>