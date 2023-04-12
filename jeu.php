<?php
// INIT SCRIPTS
include_once 'Programs/Save/saveManager.php';
include_once 'Resources/Pokemons/pokemonList.php';
include_once 'Resources/Pokemons/typeMatchUp.php';

include_once 'Programs/Places/SpecificScreens.php';
include_once 'Programs/Places/hub.php';
include_once 'Programs/Places/shop.php';
include_once 'Programs/Places/itemsManager.php';

include_once 'Programs/Fight/fightSystem.php';
include_once 'Programs/Fight/programFight.php';
include_once 'Programs/Fight/iaProgram.php';

include_once 'Programs/visuals/graphics.php'; 
include_once 'Programs/visuals/sprites.php';
include_once 'Programs/visuals/hudfight.php';

include_once 'Resources/animations.php';
include_once 'Resources/inputs.php';
include_once 'Resources/config.php';


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
    $saveProfile = getSave('Save/myGame.json');
    $save = getSaveIfExist();
    $pkmnTeamJoueur = &$save['Team'];
    saveData($pkmnTeamJoueur, 'Team');

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
        // HUB
        drawHub($save);

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
    }
}
?>