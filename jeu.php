<?php
// INIT SCRIPTS
include_once 'Programs/Helpers/config.php';
include_once 'Programs/Helpers/inputs.php';

// Visuals
include_once 'Programs/Visuals/graphics.php'; 
include_once 'Resources/sprites.php';
include_once 'Programs/Visuals/hudfight.php';
include_once 'Programs/Visuals/hud.php';

// MAIN
include_once 'Programs/Places/bagManager.php'; // item avant save
include_once 'Programs/Save/saveManager.php';
include_once 'Programs/Helpers/pokemonManager.php';
include_once 'Programs/Helpers/typeMatchUp.php';
include_once 'Programs/Places/routesManager.php';
include_once 'Programs/Fight/fightSystem.php';

// PLACES
include_once 'Programs/Places/SpecificScreens.php';
include_once 'Programs/Places/hub.php';
include_once 'Programs/Places/shopManager.php';


// INIT LAST PROGRAMS
include_once 'Programs/Visuals/animations.php';
include_once 'Resources/trainersAndRoutes.php';
include_once 'Programs/Places/Pokedex.php';


//// SET THE GAME ////
clear();
hideCursor();
shell_exec('mode con: cols=60 lines=33');
intro();
startGame();

//// GAME ////
while(true){
    menuStart();

    //Sauvegardes joueur
    $saveProfile = saveMainManager();
    $saveParty = savePartyManager();
    $pkmnTeamJoueur = &$saveParty['Team'];

    setData($pkmnTeamJoueur, 'Team', getSavePath('save'));

    if(array_key_exists('IndexFloor', $saveParty)){
        $IndexFloor = $saveParty['IndexFloor'];
    }
    else{
        $IndexFloor = 1;
    }
    $IndexFloorMax = $saveProfile['IndexFloor Max'];
    
    // item TEMP
    // giveItemFromResources($saveParty["Bag"], 'Potion', 5);
    // giveItemFromResources($saveParty["Bag"], 'Revive', 5);
    // giveItemFromResources($saveParty["Bag"], 'Super potion', 5);
    // giveItemFromResources($saveParty["Bag"], 'PokeBall', 5);
    // giveItemFromResources($saveParty["Bag"], 'MasterBall', 5);
    // giveItemFromResources($saveParty["Bag"], 'Thunderstone', 5);
    // giveItemFromResources($saveParty["Bag"], 'Firestone', 5);
    // giveItemFromResources($saveParty["Bag"], 'Waterstone', 5);
    // giveItemFromResources($saveParty["Bag"], 'Hyper-Beam', 5);
    // giveItemFromResources($saveParty["Bag"], 'Flamethrower', 5);

    // Need to reload Trainers because Rival's starter
    generateIAs();

    // Loop gameplay if team alive
    while(true){
        // HUB
        drawHub($saveParty);
        
        // generer IA pkmn team
        $pnj = generatePNJ($IndexFloor, $pkmnTeamJoueur[0]['Level']);
        startFight($saveParty, $pnj);


        // Screen end turn floor
        if(!isTeamPkmnAlive($pkmnTeamJoueur)){
            screenLose();
            break;
        }
        else{
            ++$IndexFloor;
            $saveParty['IndexFloor'] = $IndexFloor;
            setFile($saveParty, getSavePath('save'));
        }
        waitForInput(getPosChoice());

        if($IndexFloor == 95){
            cinematicLeagueEnding($saveParty);
        }
        else if($IndexFloor > $IndexFloorMax){
            cinematicEnding($saveParty);
            endGame();
            break;
        }
    }
}
?>